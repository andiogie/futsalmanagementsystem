<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Rekening;

class MemberController extends Controller
{
    public function index()
    {
        // ambil semua user
        $users = User::orderBy('id', 'asc')->paginate(10);

        // arahkan ke view admin.cek_member
        return view('admin.members.index', compact('users'));
    }

    public function rekening()
    {
        // ambil semua rekening
        $rekenings = Rekening::all();

        // lempar ke view member.index (frontend user)
        return view('member.index', compact('rekenings'));
    }

    public function create()
    {
        // arahkan ke form tambah member
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'nowa'  => ['nullable', 'regex:/^(\+62|0)[0-9]{9,13}$/'],
            'roles'  => 'nullable|string|max:50',
            'password' => 'required|string|min:6', // wajib ada password baru
        ], [
            'nowa.regex' => 'Format nomor WhatsApp tidak valid',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nowa' => $request->nowa,
            'roles' => $request->role,
            'password' => bcrypt($request->password), // simpan password terenkripsi
        ]);

        return redirect()->route('members.index')
            ->with('success', 'Member berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.members.edit', compact('user'));
    }

    // Edit Profile dari menu Member 
    public function editProfile()
    {
        $user = Auth::user(); // ambil user yang login
        return view('member.profile', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi
        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'nowa'  => ['nullable', 'regex:/^(\+62|0)[0-9]{9,13}$/'],
        ];

        // Password hanya validasi kalau diisi
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        // Role hanya bisa diubah oleh admin
        if (Auth::user()->roles === 'admin') {
            $rules['role'] = 'nullable|string|in:admin,member,owner';
        }

        $request->validate($rules, [
            'nowa.regex' => 'Format nomor WhatsApp tidak valid',
        ]);

        // Update field umum
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->nowa  = $request->nowa;

        // Update password kalau diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Update role kalau admin
        if (Auth::user()->roles === 'admin' && $request->filled('role')) {
            $user->roles = $request->role;
        }

        $user->save();

        // Redirect berbeda untuk member vs admin
        if (Auth::user()->roles === 'admin') {
            return redirect()->route('members.index')
                ->with('success', 'Member berhasil diperbarui.');
        } else {
            return redirect()->route('member.profile')
                ->with('success', 'Profil berhasil diperbarui.');
        }
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $users = User::query()
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                    ->orWhere('nowa', 'like', "%$query%");
            })
            ->orderBy('id', 'asc')
            ->paginate(10) // ✅ paginasi, bukan get()
            ->appends(['q' => $query]); // biar query tetap ada saat pindah halaman

        return view('admin.members.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Jangan hapus owner
        if ($user->roles === 'owner') {
            return redirect()->back()->with('error', 'Owner tidak bisa dihapus.');
        }

        $user->delete();

        return redirect()->route('members.index')
            ->with('success', 'Member berhasil dihapus.');
    }
}
