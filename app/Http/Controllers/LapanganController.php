<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lapangan;
use Illuminate\Support\Facades\Storage;


class LapanganController extends Controller
{
    // Tampilkan semua lapangan
    public function index()
    {
        $lapangan = Lapangan::orderBy('id', 'asc')->paginate(10);
        return view('admin.lapangan.index', compact('lapangan'));
    }

    // Form tambah lapangan
    public function create()
    {
        return view('admin.lapangan.create');
    }

    // Simpan lapangan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'foto_lapangan' => 'nullable|image|max:2048',
            'tarif' => 'required|integer',
        ]);

        $data = $request->only(['nama_lapangan', 'tarif']);

        if ($request->hasFile('foto_lapangan')) {
            // simpan file ke storage/app/public/uploads/lapangan
            $path = $request->file('foto_lapangan')->store('uploads/lapangan', 'public');
            $data['foto_lapangan'] = 'storage/' . $path;
        }

        Lapangan::create($data);

        return redirect()->route('lapangan.index')->with('success', 'Lapangan berhasil ditambahkan!');
    }

    // Form edit lapangan
    public function edit($id)
    {
        $lapangan = Lapangan::findOrFail($id);
        return view('admin.lapangan.edit', compact('lapangan'));
    }

    // Update lapangan
    public function update(Request $request, $id)
    {
        $lapangan = Lapangan::findOrFail($id);

        $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'foto_lapangan' => 'nullable|image|max:2048',
            'tarif' => 'required|integer',
        ]);

        $data = $request->only(['nama_lapangan', 'tarif']);

        if ($request->hasFile('foto_lapangan')) {
            // hapus file lama kalau ada
            if ($lapangan->foto_lapangan) {
                $oldPath = str_replace('storage/', '', $lapangan->foto_lapangan);
                Storage::disk('public')->delete($oldPath);
            }

            // upload baru
            $path = $request->file('foto_lapangan')->store('uploads/lapangan', 'public');
            $data['foto_lapangan'] = 'storage/' . $path;
        }

        $lapangan->update($data);

        return redirect()->route('lapangan.index')->with('success', 'Lapangan berhasil diperbarui!');
    }


    // Hapus lapangan
    public function destroy($id)
    {
        $lapangan = Lapangan::findOrFail($id);

        if ($lapangan->foto_lapangan) {
            $oldPath = str_replace('storage/', '', $lapangan->foto_lapangan);
            Storage::disk('public')->delete($oldPath);
        }

        $lapangan->delete();

        return redirect()->route('lapangan.index')->with('success', 'Lapangan berhasil dihapus!');
    }
}
