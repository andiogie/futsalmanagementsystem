<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OtpNotification;

class RegisterController extends Controller
{
    private function sendOtp(User $user)
    {
        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        Mail::raw("Kode OTP kamu adalah: $otp (berlaku 10 menit)", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Verifikasi OTP - FutsalGo');
        });
    }
    public function storeMember(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'nowa' => [
                'required',
                'regex:/^[0-9]+$/',
                'digits_between:10,15',
                'unique:users,nowa',
            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 6 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'nowa.required' => 'Nomor WhatsApp wajib diisi.',
                'nowa.regex' => 'Format Nomor WhatsApp tidak valid.',
                'nowa.unique' => 'Nomor WhatsApp sudah terdaftar.'
            ]
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nowa' => $request->nowa,
            'role' => 'member', // simpan role member langsung ke tabel users
        ]);

        // generate OTP
        $otp = rand(100000, 999999);

        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        // ✅ kirim via notification
        $user->notify(new OtpNotification($otp));

        return redirect()->route('otp.verify.form', ['email' => $user->email])
            ->with('success', 'Akun berhasil dibuat! Silakan cek email untuk OTP.');
    }
}
