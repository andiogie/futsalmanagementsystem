<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Blacklist;
use App\Models\Booking;
use App\Models\Diskon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{

    public function index()
    {
        $bookings = Booking::with('lapangan') // <--- tambahkan eager load
            ->orderBy('id', 'asc')
            ->paginate(10);

        Booking::where('is_notified', false)->update(['is_notified' => true]);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $lapangan = Lapangan::all();
        $today = now()->toDateString();

        $diskons = Diskon::where(function ($q) use ($today) {
            $q->whereNull('mulai')->orWhere('mulai', '<=', $today);
        })
            ->where(function ($q) use ($today) {
                $q->whereNull('berakhir')->orWhere('berakhir', '>=', $today);
            })
            ->get(['kode', 'tipe', 'nilai']);

        return view('member.booking', compact('lapangan', 'diskons'));
    }

    public function createNonMember()
    {
        $lapangan = Lapangan::all();
        $today = now()->toDateString();

        $diskons = Diskon::where(function ($q) use ($today) {
            $q->whereNull('mulai')->orWhere('mulai', '<=', $today);
        })
            ->where(function ($q) use ($today) {
                $q->whereNull('berakhir')->orWhere('berakhir', '>=', $today);
            })
            ->get(['kode', 'tipe', 'nilai']);

        return view('admin.bookings.create', compact('lapangan', 'diskons'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'whatsapp'    => 'required|string|max:20',
            'tanggal'     => 'required|date',
            'lapangan_id' => 'required',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
            'durasi'      => 'required',
            'tarif_awal'  => 'required',
            'kode_diskon' => 'nullable|string',
        ]);

        if (Blacklist::where('whatsapp', $validated['whatsapp'])->exists()) {
            return back()->withErrors(['msg' => 'Nomor ini diblokir dan tidak bisa melakukan booking.']);
        }

        // Invoice No
        $lastBooking = Booking::latest('id')->first();
        $nextNumber = $lastBooking ? $lastBooking->id + 1 : 1;
        $invoiceNo = 'INV-' . now()->format('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Ambil variabel untuk cek bentrok
        $tanggal     = $validated['tanggal'];
        $jam_mulai   = $validated['jam_mulai'];
        $jam_selesai = $validated['jam_selesai'];

        // Cek jadwal bentrok
        $conflict = Booking::where('tanggal', $tanggal)
            ->where(function ($query) use ($jam_mulai, $jam_selesai) {
                $query->where(function ($q) use ($jam_mulai, $jam_selesai) {
                    $q->where('jam_mulai', '<', $jam_selesai)
                        ->where('jam_selesai', '>', $jam_mulai);
                });
            })
            ->exists();

        if ($conflict) {
            return back()
                ->withErrors(['msg' => 'Jadwal bentrok! Silakan pilih jam lain.'])
                ->withInput();
        }

        // Bersihkan " jam" & "Rp "
        $validated['durasi'] = (int) str_replace(' jam', '', $validated['durasi']);
        $tarifAwal = (int) str_replace(['Rp', ' ', '.'], '', $request->tarif_awal);
        $tarifAkhir = $tarifAwal;
        $diskonId = null;
        // $validated['tarif']  = (int) str_replace(['Rp', ' ', '.'], '', $validated['tarif']);
        $validated['tarif_awal'] = $tarifAwal;
        $validated['tarif'] = max($tarifAkhir, 0);
        $validated['invoice_no'] = $invoiceNo;
        $validated['payment_type'] = null;
        $validated['payment_status'] = 'Pending';



        // Cek Diskon
        if ($request->filled('kode_diskon')) {
            $diskon = Diskon::where('kode', $request->kode_diskon)
                ->where(function ($q) use ($request) {
                    $tgl = $request->tanggal;
                    $q->whereNull('mulai')->orWhere('mulai', '<=', $tgl);
                })
                ->where(function ($q) use ($request) {
                    $tgl = $request->tanggal;
                    $q->whereNull('berakhir')->orWhere('berakhir', '>=', $tgl);
                })
                ->first();

            if (! $diskon) {
                return back()->withErrors(['kode_diskon' => 'Kode diskon tidak valid atau sudah kadaluarsa.'])->withInput();
            }

            if ($diskon->jam_mulai && $diskon->jam_selesai) {
                // jam booking harus dalam range diskon
                if ($request->jam_mulai < $diskon->jam_mulai || $request->jam_mulai >= $diskon->jam_selesai) {
                    return back()->withErrors(['kode_diskon' => 'Kode diskon hanya berlaku antara jam ' . $diskon->jam_mulai . ' - ' . $diskon->jam_selesai])->withInput();
                }
            }

            if ($diskon->tipe === 'persentase') {
                $tarifAkhir = (int) round($tarifAwal - ($tarifAwal * $diskon->nilai / 100));
            } else {
                $tarifAkhir = max(0, $tarifAwal - (int)$diskon->nilai);
            }

            $validated['tarif'] = $tarifAkhir;
        }



        // Simpan ke DB
        Booking::create($validated);

        // Redirect ke /member dengan pesan sukses
        if ($request->is('/admin/*')) {
            // kalau URL diawali admin → redirect ke halaman admin bookings
            return redirect()->route('admin.bookings.index')
                ->with('success', 'Booking berhasil disimpan dengan Invoice No: ' . $invoiceNo);
        } else {
            // default member → redirect ke halaman member
            return redirect('/member')->with(
                'success',
                'Booking berhasil disimpan dengan Invoice No: ' . $invoiceNo . '. Harap simpan sebagai bukti masuk ke lapangan.'
            );
        }
        // return redirect('/member')->with('success', 'Booking berhasil disimpan dengan Invoice No: ' . $invoiceNo . '. Harap lakukan Upload Bukti Bayar.');
    }

    public function storeNonMember(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'whatsapp'    => 'required|string|max:20',
            'tanggal'     => 'required|date',
            'lapangan_id' => 'required',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
            'durasi'      => 'required',
            'tarif_awal'  => 'required',
            'kode_diskon' => 'nullable|string',
        ]);

        if (Blacklist::where('whatsapp', $validated['whatsapp'])->exists()) {
            return back()->withErrors(['msg' => 'Nomor ini diblokir dan tidak bisa melakukan booking.']);
        }

        // Invoice No
        $lastBooking = Booking::latest('id')->first();
        $nextNumber = $lastBooking ? $lastBooking->id + 1 : 1;
        $invoiceNo = 'INV-' . now()->format('Ymd') . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        // Ambil variabel untuk cek bentrok
        $tanggal     = $validated['tanggal'];
        $jam_mulai   = $validated['jam_mulai'];
        $jam_selesai = $validated['jam_selesai'];

        // Cek jadwal bentrok
        $conflict = Booking::where('tanggal', $tanggal)
            ->where(function ($query) use ($jam_mulai, $jam_selesai) {
                $query->where(function ($q) use ($jam_mulai, $jam_selesai) {
                    $q->where('jam_mulai', '<', $jam_selesai)
                        ->where('jam_selesai', '>', $jam_mulai);
                });
            })
            ->exists();

        if ($conflict) {
            return back()
                ->withErrors(['msg' => 'Jadwal bentrok! Silakan pilih jam lain.'])
                ->withInput();
        }

        // Bersihkan " jam" & "Rp "
        $validated['durasi'] = (int) str_replace(' jam', '', $validated['durasi']);
        $tarifAwal = (int) str_replace(['Rp', ' ', '.'], '', $request->tarif_awal);
        $tarifAkhir = $tarifAwal;
        $diskonId = null;
        // $validated['tarif']  = (int) str_replace(['Rp', ' ', '.'], '', $validated['tarif']);
        $validated['tarif_awal'] = $tarifAwal;
        $validated['tarif'] = max($tarifAkhir, 0);
        $validated['invoice_no'] = $invoiceNo;
        $validated['payment_type'] = null;
        $validated['payment_status'] = 'Pending';



        // Cek Diskon
        if ($request->filled('kode_diskon')) {
            $diskon = Diskon::where('kode', $request->kode_diskon)
                ->where(function ($q) use ($request) {
                    $tgl = $request->tanggal;
                    $q->whereNull('mulai')->orWhere('mulai', '<=', $tgl);
                })
                ->where(function ($q) use ($request) {
                    $tgl = $request->tanggal;
                    $q->whereNull('berakhir')->orWhere('berakhir', '>=', $tgl);
                })
                ->first();

            if (! $diskon) {
                return back()->withErrors(['kode_diskon' => 'Kode diskon tidak valid atau sudah kadaluarsa.'])->withInput();
            }

            if ($diskon->jam_mulai && $diskon->jam_selesai) {
                // jam booking harus dalam range diskon
                if ($request->jam_mulai < $diskon->jam_mulai || $request->jam_mulai >= $diskon->jam_selesai) {
                    return back()->withErrors(['kode_diskon' => 'Kode diskon hanya berlaku antara jam ' . $diskon->jam_mulai . ' - ' . $diskon->jam_selesai])->withInput();
                }
            }

            if ($diskon->tipe === 'persentase') {
                $tarifAkhir = (int) round($tarifAwal - ($tarifAwal * $diskon->nilai / 100));
            } else {
                $tarifAkhir = max(0, $tarifAwal - (int)$diskon->nilai);
            }

            $validated['tarif'] = $tarifAkhir;
        }



        // Simpan ke DB
        Booking::create($validated);

        // Redirect ke /member dengan pesan sukses

        return redirect('/admin/bookings')->with('success', 'Booking berhasil disimpan dengan Invoice No: ' . $invoiceNo . '. Harap simpan sebagai bukti masuk ke lapangan.');
    }

    public function riwayat()
    {
        $nowa = Auth::user()->nowa;

        $bookings = Booking::with('lapangan') // <--- eager load
            ->where('whatsapp', $nowa)
            ->orderByDesc('tanggal')
            ->orderBy('jam_mulai')
            ->paginate(10);

        return view('member.riwayat', compact('bookings'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        // Cek kalau sudah pernah upload
        if ($booking->payment_proof) {
            return back()->with('error', 'Bukti bayar sudah diupload sebelumnya.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('payment_proof');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('payment_proof', $filename, 'public');

        $booking->update([
            'payment_proof' => $path,
        ]);

        return back()->with('success', 'Bukti bayar berhasil diupload. Menunggu verifikasi admin.');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $bookings = Booking::with('lapangan') // <-- tambahkan eager loading di sini
            ->when($query, function ($q) use ($query) {
                $q->where('nama', 'like', "%$query%")
                    ->orWhere('whatsapp', 'like', "%$query%")
                    ->orWhere('invoice_no', 'like', "%$query%");
            })
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->appends(['q' => $query]);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'payment_type'   => 'nullable|in:Cash,QRIS,Transfer',
            'payment_status' => 'required|in:Pending,Paid,Cancel',
            'payment_proof'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // bukti transfer/foto
            'notes'  => 'nullable|string|max:255', // alasan cancel
        ]);

        // Handle upload file bukti pembayaran
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $validated['payment_proof'] = $path;
        }

        $booking->update($validated);

        return redirect()->route('bookings.index')->with('success', 'Status pembayaran berhasil diperbarui!');
    }

    public function apiBookings()
    {
        $bookings = Booking::with('lapangan')->get();

        $events = $bookings->filter(function ($booking) {
            // Buang booking yang status Cancel
            return $booking->payment_status !== 'Cancel';
        })->map(function ($booking) {
            // Tentukan warna sesuai status
            $color = '#6b7280'; // default abu2
            if ($booking->payment_status === 'Pending') {
                $color = '#facc15'; // kuning
            } elseif ($booking->payment_status === 'Paid') {
                $color = '#22c55e'; // hijau
            }

            return [
                'id'    => $booking->id,
                'title' => $booking->lapangan->nama_lapangan . ' - ' . $booking->nama,
                'start' => $booking->tanggal . 'T' . $booking->jam_mulai,
                'end'   => $booking->tanggal . 'T' . $booking->jam_selesai,
                'color' => $color,
                'status' => $booking->payment_status, // tambahin biar jelas
            ];
        });

        return response()->json($events->values()); // values() biar index rapi
    }

    public function cetakInvoice($id)
    {
        $booking = Booking::with('lapangan')->findOrFail($id);

        $pdf = Pdf::loadView('member.invoice-pdf', compact('booking'))
            ->setPaper('A4', 'portrait');

        // Bisa langsung download:
        return $pdf->download("Invoice-{$booking->invoice_no}.pdf");

        // Atau tampilkan di browser:
        // return $pdf->stream("Invoice-{$booking->invoice_no}.pdf");
    }
}
