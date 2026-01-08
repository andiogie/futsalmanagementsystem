<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\BlacklistController;
use App\Http\Controllers\BookingController;
use App\Models\Diskon;


// =====================
// Landing Page
// =====================
Route::get('/', function () {
    return view('landing');
});



// =====================
// Auth
// =====================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registrasi Member
Route::get('/daftar_member', fn() => view('auth.daftar_member'))
    ->name('register.member.form');
Route::post('/daftar_member', [RegisterController::class, 'storeMember'])
    ->name('register.member')->middleware('throttle:3,1');

Route::post('/send-otp', [OtpController::class, 'sendOtp'])->name('otp.send')->middleware('throttle:3,1');
Route::get('/verify-otp', [OtpController::class, 'showVerifyForm'])->name('otp.verify.form');
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('otp.verify')->middleware('throttle:3,1');


// Lupa Password
Route::get('/forgot', [ForgotPasswordController::class, 'showForgotForm'])
    ->name('password.request');
// Kirim email reset password
Route::post('/forgot', [ForgotPasswordController::class, 'sendResetLink'])
    ->name('password.email')->middleware('throttle:3,1');

// Halaman form reset password (Route ini nanti di pakai jika sudah configurasi alamat email)
Route::get('/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');

// Submit password baru
Route::post('/reset', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.update')->middleware('throttle:3,1');


// =====================
// Dashboard Admin (Wajib Login)
// =====================
// Route::middleware(['auth'])->prefix('admin')->group(function () {
// Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
Route::middleware(['demo.auth', 'demo.role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.index');

    // Member
    Route::resource('members', MemberController::class)->except(['show']);
    Route::get('members/search', [MemberController::class, 'search'])->name('members.search');

    // Master Lapangan
    Route::resource('lapangan', LapanganController::class);

    // // Bookings
    Route::resource('bookings', BookingController::class)->except(['show', 'create']);
    Route::get('bookings/create', [BookingController::class, 'createNonMember'])->name('bookings.non_member.create');
    Route::post('bookings/store', [BookingController::class, 'storeNonMember'])->name('bookings.non_member.store');
    Route::get('bookings/search', [BookingController::class, 'search'])->name('bookings.search');

    Route::get('/calendar', function () {
        return view('admin.calendar');
    })->name('admin.calendar');

    // Diskon
    Route::resource('diskon', DiskonController::class)->except(['show']);

    // Route::get('/diskons/{kode}', [DiskonController::class, 'check'])->name('diskon.check');;

    Route::get('diskon/check/{kode}', [DiskonController::class, 'check'])->name('diskon.check');

    // Laporan keuangan
    Route::resource('laporan', LaporanController::class);

    Route::get('/api/bookings', [BookingController::class, 'apiBookings'])->name('admin.api.bookings')->middleware('throttle:60,1');

    // Download PDF
    Route::get('laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');

    // Rekening
    Route::resource('rekening', RekeningController::class);

    Route::resource('blacklist', BlacklistController::class);


    // Dashboard About
    Route::get('/about', function () {
        return view('admin.about');
    })->name('admin.about');
});


// =====================
// Mobile (Wajib Login)
// =====================
// Route::middleware(['auth'])->prefix('member')->name('member.')->group(function () {
// Route::middleware(['auth', 'role:member'])->prefix('member')->group(function () {
Route::middleware(['demo.auth', 'demo.role:member'])->prefix('member')->group(function () {
    Route::get('/', [RekeningController::class, 'indexMember'])->name('member.index');

    Route::get('/calendar', function () {
        return view('member.calendar');
    })->name('member.calendar');

    Route::get('/api/bookings', [BookingController::class, 'apiBookings'])->name('member.api.bookings')->middleware('throttle:60,1');


    // Riwayat booking
    Route::get('/riwayat', [BookingController::class, 'riwayat'])->name('member.riwayat')->middleware('auth');

    Route::post('/riwayat/{id}/upload-bukti', [BookingController::class, 'uploadBukti'])
        ->name('member.riwayat.uploadBukti');

    // Download PDF
    Route::get('/riwayat/{id}/invoice', [BookingController::class, 'cetakInvoice'])->name('member.riwayat.invoice');

    // Halaman booking
    Route::get('/booking', [BookingController::class, 'create'])->name('member.booking');

    // Submit booking
    Route::post('/booking', [BookingController::class, 'store'])->name('member.booking.submit');

    // Profile member
    Route::get('/profile', fn() => view('member.profile'))->name('member.profile');



    // Mobile About
    Route::get('/about', function () {
        return view('member.about');
    })->name('member.about');
});
