<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diskon;

class DiskonController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function check($kode)
    {
        $diskon = Diskon::where('kode', strtoupper($kode))
            ->where(function ($q) {
                $today = now()->toDateString();
                $q->whereNull('mulai')->orWhere('mulai', '<=', $today);
            })
            ->where(function ($q) {
                $today = now()->toDateString();
                $q->whereNull('berakhir')->orWhere('berakhir', '>=', $today);
            })
            ->first();

        if (! $diskon) {
            return response()->json(['valid' => false]);
        }

        return response()->json([
            'valid' => true,
            'tipe'  => $diskon->tipe,
            'nilai' => $diskon->nilai,
            'kode'  => $diskon->kode,
        ]);
    }
    public function index()
    {
        $diskons = Diskon::orderBy('id')->get();
        return view('admin.diskon.index', compact('diskons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.diskon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_diskon' => 'required|string|max:255',
            'kode'        => 'nullable|string|max:255',
            'tipe'        => 'required|in:persentase,nominal',
            'nilai'       => 'required|integer|min:1',
            'jam_mulai'   => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i|after_or_equal:jam_mulai',
            'mulai'       => 'nullable|date',
            'berakhir'    => 'nullable|date|after_or_equal:mulai',
        ]);

        Diskon::create([
            'nama_diskon' => $request->nama_diskon,
            'kode'        => $request->kode,
            'tipe'        => $request->tipe,
            'nilai'       => $request->nilai,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'mulai'       => $request->mulai,
            'berakhir'    => $request->berakhir,
        ]);

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil ditambahkan');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $diskon = Diskon::findOrFail($id);
        return view('admin.diskon.edit', compact('diskon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $diskon = Diskon::findOrFail($id);

        $request->validate([
            'nama_diskon' => 'required|string|max:255',
            'kode'        => 'nullable|string|max:255',
            'tipe'        => 'required|in:persentase,nominal',
            'nilai'       => 'required|integer|min:1',
            'jam_mulai'   => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i|after_or_equal:jam_mulai',
            'mulai'       => 'nullable|date',
            'berakhir'    => 'nullable|date|after_or_equal:mulai',
        ]);

        $diskon->update([
            'nama_diskon' => $request->nama_diskon,
            'kode'        => $request->kode,
            'tipe'        => $request->tipe,
            'nilai'       => $request->nilai,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'mulai'       => $request->mulai,
            'berakhir'    => $request->berakhir,
        ]);

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $diskon = Diskon::findOrFail($id);
        $diskon->delete();

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil dihapus!');
    }
}
