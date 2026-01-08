<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blacklist;

class BlacklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blacklists = Blacklist::orderBy('id', 'desc')->get();
        return view('admin.blacklist.index', compact('blacklists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blacklist.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'whatsapp' => 'required|string|max:20|unique:blacklists,whatsapp',
            'alasan'   => 'nullable|string|max:255',
        ]);

        Blacklist::create($request->all());

        return redirect()->route('blacklist.index')->with('success', 'Nomor berhasil masuk blacklist!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blacklist = Blacklist::findOrFail($id);
        $blacklist->delete();

        return redirect()->route('admin.blacklist.index')->with('success', 'Nomor berhasil dihapus dari blacklist!');
    }
}
