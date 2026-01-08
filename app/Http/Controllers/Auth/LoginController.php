<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // validasi ringan
        $request->validate([
            'email' => 'required|email',
            'password' => 'nullable',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ADMIN DEMO
        |--------------------------------------------------------------------------
        */
        if ($request->email === 'admin@demo.com') {
            session([
                'demo_login' => true,
                'demo_user' => [
                    'id'    => 1,
                    'name'  => 'Admin Demo',
                    'email' => 'admin@demo.com',
                    'roles' => 'admin',
                ],
            ]);

            return redirect()->route('admin.index');
        }

        /*
        |--------------------------------------------------------------------------
        | MEMBER DEMO
        |--------------------------------------------------------------------------
        */
        if ($request->email === 'member@demo.com') {
            session([
                'demo_login' => true,
                'demo_user' => [
                    'id'    => 2,
                    'name'  => 'Member Demo',
                    'email' => 'member@demo.com',
                    'roles' => 'member',
                ],
            ]);

            return redirect()->route('member.index');
        }

        return back()->withErrors([
            'email' => 'Gunakan akun demo: admin@demo.com atau member@demo.com',
        ]);
    }

    public function logout(Request $request)
    {
        // logout Laravel (aman walau tidak login)
        Auth::logout();

        // hapus session demo
        $request->session()->forget([
            'demo_login',
            'demo_user',
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
