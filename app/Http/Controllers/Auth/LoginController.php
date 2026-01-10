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
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek apakah email sudah ada di database
        $user = \App\Models\User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->route('register.member.form') // ganti sesuai route register kamu
                ->withErrors(['email' => 'Email belum terdaftar. Silakan registrasi dulu.']);
        }

        // Kalau email ada → cek password
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();


            // Cek apakah sudah verifikasi email
            if (!$user->is_verified) {
                // generate OTP baru
                $otp = rand(100000, 999999);

                User::where('id', $user->id)->update([
                    'otp' => $otp,
                    'otp_expires_at' => now()->addMinutes(10),
                ]);

                // kirim via Notification
                // $user->notify(new OtpNotification($otp));
                Notification::send($user, new OtpNotification($otp));

                Auth::logout(); // logout dulu biar tidak bisa akses
                return redirect()->route('otp.verify.form', ['email' => $user->email])
                    ->withErrors(['email' => 'Akun belum diverifikasi. Silakan masukkan kode OTP yang sudah dikirim.']);
            }

            // cek role
            if ($user->roles === 'admin' || $user->roles === 'owner') {
                return redirect()->route('admin.index');
            } elseif ($user->roles === 'member') {
                return redirect()->route('member.index');
            } else {
                Auth::logout();
                return redirect('/login')->withErrors([
                    'email' => 'Role tidak dikenali. Hubungi admin.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
