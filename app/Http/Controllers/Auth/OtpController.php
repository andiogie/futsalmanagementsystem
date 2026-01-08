<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OtpNotification;
use App\Models\User;
use Carbon\Carbon;

class OtpController extends Controller
{
    // Tampilkan form verifikasi OTP
    public function showVerifyForm(Request $request)
    {
        return view('auth.verify-otp', ['email' => $request->email]);
    }

    // Kirim OTP ke email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        $otp = rand(100000, 999999);

        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        // ✅ kirim notifikasi
        $user->notify(new OtpNotification($otp));

        return redirect()->route('otp.verify.form', ['email' => $user->email])
            ->with('success', 'Kode OTP telah dikirim ke email.');
    }

    // Proses verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp'   => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp !== $request->otp || $user->otp_expires_at < now()) {
            return back()->withErrors(['otp' => 'Kode OTP salah atau sudah kadaluarsa.']);
        }

        // ✅ Mark verified
        $user->email_verified_at = now();
        $user->is_verified = 1; // <--- tambahin ini
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        Auth::login($user);

        return redirect()->route('login')
            ->with('success', 'Email berhasil diverifikasi! Silahkan login kembali');
    }
}
