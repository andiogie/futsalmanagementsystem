<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OtpNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DEMO MODE (BYPASS DATABASE & OTP)
        |--------------------------------------------------------------------------
        | Aktifkan dengan DEMO_MODE=true di .env / Railway Variables
        */
        if (config('app.demo_mode')) {

            // Admin Demo
            if ($request->email === 'admin@demo.com') {
                session([
                    'demo_login' => true,
                    'demo_user' => [
                        'name' => 'Admin Demo',
                        'email' => 'admin@demo.com',
                        'roles' => 'admin',
                    ],
                ]);

                return redirect()->route('admin.index');
            }

            // Member Demo
            if ($request->email === 'member@demo.com') {
                session([
                    'demo_login' => true,
                    'demo_user' => [
                        'name' => 'Member Demo',
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

        /*
        |--------------------------------------------------------------------------
        | LOGIN NORMAL (PRODUCTION)
        |--------------------------------------------------------------------------
        */
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek apakah email ada
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->route('register.member.form')
                ->withErrors(['email' => 'Email belum terdaftar.']);
        }

        // Cek password
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Cek verifikasi
            if (!$user->is_verified) {
                $otp = rand(100000, 999999);

                User::where('id', $user->id)->update([
                    'otp' => $otp,
                    'otp_expires_at' => now()->addMinutes(10),
                ]);

                // Kirim OTP (boleh dimatikan di demo)
                Notification::send($user, new OtpNotification($otp));

                Auth::logout();

                return redirect()->route('otp.verify.form', ['email' => $user->email])
                    ->withErrors(['email' => 'Akun belum diverifikasi.']);
            }

            // Redirect by role
            if (in_array($user->roles, ['admin', 'owner'])) {
                return redirect()->route('admin.index');
            }

            if ($user->roles === 'member') {
                return redirect()->route('member.index');
            }

            Auth::logout();
            return redirect('/login')->withErrors([
                'email' => 'Role tidak dikenali.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->forget('demo_login');
        $request->session()->forget('demo_user');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
