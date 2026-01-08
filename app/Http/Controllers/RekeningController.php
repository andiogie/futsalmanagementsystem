<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    /**
     * Tampilkan daftar rekening
     */
    public function index()
    {
        $rekenings = Rekening::latest()->get();
        return view('admin.rekening.index', compact('rekenings'));
    }

    public function indexMember()
    {
        $rekenings = Rekening::latest()->get();
        return view('member.index', compact('rekenings'));
    }

    /**
     * Form tambah rekening baru
     */
    public function create()
    {
        return view('admin.rekening.create');
    }

    /**
     * Simpan rekening baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'bank_account' => 'required|string|max:50',
            'bank_name'    => 'required|string|max:50',
            'account_name' => 'required|string|max:100',
        ]);

        Rekening::create($request->only(['bank_account', 'bank_name', 'account_name']));

        return redirect()->route('rekening.index')->with('success', 'Rekening berhasil ditambahkan.');
    }

    /**
     * Form edit rekening
     */
    public function edit(Rekening $rekening)
    {
        return view('admin.rekening.edit', compact('rekening'));
    }

    /**
     * Update rekening
     */
    public function update(Request $request, Rekening $rekening)
    {
        $request->validate([
            'bank_account' => 'required|string|max:50',
            'bank_name'    => 'required|string|max:50',
            'account_name' => 'required|string|max:100',
        ]);

        $rekening->update($request->only(['bank_account', 'bank_name', 'account_name']));

        return redirect()->route('rekening.index')->with('success', 'Rekening berhasil diperbarui.');
    }

    /**
     * Hapus rekening
     */
    public function destroy(Rekening $rekening)
    {
        $rekening->delete();
        return redirect()->route('rekening.index')->with('success', 'Rekening berhasil dihapus.');
    }
}
