<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Laporan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date   = $request->input('end_date');

        if ($start_date && $end_date) {
            // Jika ada filter rentang tanggal
            $range = [$start_date, $end_date];
        } else {
            // Default: bulan ini
            $range = [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()];
        }

        // Hitung pemasukan dari booking (Paid)
        $pemasukan_booking = Booking::whereBetween('tanggal', $range)
            ->where('payment_status', 'Paid')
            ->sum('tarif');

        // Hitung pemasukan manual
        $pemasukan_manual = Laporan::whereBetween('tanggal', $range)
            ->where('tipe', 'Pemasukan')
            ->sum('jumlah');

        $total_pemasukan = $pemasukan_booking + $pemasukan_manual;

        // Hitung pengeluaran
        $pengeluaran = Laporan::whereBetween('tanggal', $range)
            ->where('tipe', 'Pengeluaran')
            ->sum('jumlah');

        // Laba bersih
        $laba = $total_pemasukan - $pengeluaran;

        // Detail transaksi booking
        $transaksi_booking = Booking::select(
            'id',
            'tanggal',
            'invoice_no as deskripsi',
            'payment_type as metode',
            'tarif as jumlah'
        )
            ->whereBetween('tanggal', $range)
            ->where('payment_status', 'Paid')
            ->get()
            ->map(function ($item) {
                $item->tipe = 'Pemasukan';
                $item->sumber = 'bookings';
                return $item;
            });

        // Detail transaksi manual
        $transaksi_manual = Laporan::select(
            'id',
            'tanggal',
            'deskripsi',
            'metode',
            'jumlah',
            'tipe',
            'bukti'
        )
            ->whereBetween('tanggal', $range)
            ->get()
            ->map(function ($item) {
                $item->sumber = 'laporans';
                return $item;
            });

        // Gabungkan
        $transaksi = collect($transaksi_booking)
            ->concat($transaksi_manual)
            ->sortByDesc(fn($item) => Carbon::parse($item->tanggal))
            ->values(); // reset index

        // Manual pagination
        $perPage = 10;
        $currentPage = $request->get('page', 1);
        $total = $transaksi->count();

        $pagedData = $transaksi->forPage($currentPage, $perPage)->values();

        $transaksi_paginated = new LengthAwarePaginator(
            $pagedData,
            $total,
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.laporan.index', [
            'total_pemasukan' => $total_pemasukan,
            'pengeluaran' => $pengeluaran,
            'laba' => $laba,
            'transaksi' => $transaksi_paginated,
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.laporan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'   => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'tipe'      => 'required|in:Pemasukan,Pengeluaran',
            'metode'    => 'nullable|string|max:100',
            'jumlah'    => 'required|numeric|min:0',
            'bukti'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('bukti')) {
            $filename = time() . '_' . $request->file('bukti')->getClientOriginalName();
            $path = $request->file('bukti')->storeAs('bukti', $filename, 'public');
            $validated['bukti'] = $path;
        }

        Laporan::create($validated);

        return redirect()->route('laporan.index')
            ->with('success', 'Laporan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('admin.laporan.edit', compact('laporan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'tanggal'   => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'tipe'      => 'required|in:Pemasukan,Pengeluaran',
            'metode'    => 'nullable|string|max:100',
            'jumlah'    => 'required|numeric|min:0',
            'bukti'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('bukti')) {
            // Hapus bukti lama (jika ada)
            if ($laporan->bukti && Storage::disk('public')->exists($laporan->bukti)) {
                Storage::disk('public')->delete($laporan->bukti);
            }

            $filename = time() . '_' . $request->file('bukti')->getClientOriginalName();
            $path = $request->file('bukti')->storeAs('bukti', $filename, 'public');
            $validated['bukti'] = $path;
        }

        $laporan->update($validated);

        return redirect()->route('laporan.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus!');
    }



    public function exportPdf(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year  = $request->get('year', now()->year);

        // Data sama kaya di index()
        $pemasukan_booking = Booking::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->where('payment_status', 'Paid')
            ->sum('tarif');

        $pemasukan_manual = Laporan::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->where('tipe', 'Pemasukan')
            ->sum('jumlah');

        $total_pemasukan = $pemasukan_booking + $pemasukan_manual;

        $pengeluaran = Laporan::whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->where('tipe', 'Pengeluaran')
            ->sum('jumlah');

        $laba = $total_pemasukan - $pengeluaran;

        $transaksi_booking = Booking::select(
            'id',
            'tanggal',
            'invoice_no as deskripsi',
            'payment_type as metode',
            'tarif as jumlah'
        )
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->where('payment_status', 'Paid')
            ->get()
            ->map(function ($item) {
                $item->tipe = 'Pemasukan';
                $item->sumber = 'bookings';
                return $item;
            });

        $transaksi_manual = Laporan::select('id', 'tanggal', 'deskripsi', 'metode', 'jumlah', 'tipe')
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->get()
            ->map(function ($item) {
                $item->sumber = 'laporans';
                return $item;
            });

        $transaksi = $transaksi_booking->merge($transaksi_manual)->sortBy('tanggal');

        // Kirim ke view PDF
        $pdf = Pdf::loadView('admin.laporan.pdf', [
            'total_pemasukan' => $total_pemasukan,
            'pengeluaran' => $pengeluaran,
            'laba' => $laba,
            'transaksi' => $transaksi,
            'month' => $month,
            'year' => $year,
        ]);

        return $pdf->download("laporan-keuangan-{$month}-{$year}.pdf");
    }
}
