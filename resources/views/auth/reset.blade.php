@extends('auth.auth')

@section('title', 'Reset Password - FutsalGo')

@section('content')
<div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center mb-6">Reset Password</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4 relative">
            <label class="block text-sm font-medium mb-1">Password Baru</label>
            <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded pr-16" required>
            <button type="button" id="togglePassword" class="absolute right-3 top-[30px] text-sm text-green-600 hover:underline">Show</button>
        </div>

        <div class="mb-4 relative">
            <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border rounded pr-16" required>
            <button type="button" id="togglePasswordConfirmation" class="absolute right-3 top-[30px] text-sm text-green-600 hover:underline">Show</button>
        </div>

        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">Reset Password</button>
    </form>

    <div class="mt-4 text-sm text-center">
        <a href="{{ route('login') }}" class="text-green-600 hover:underline">Kembali ke login</a>
    </div>
</div>
@endsection
