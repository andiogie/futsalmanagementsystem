@extends('auth.auth')

@section('title', 'Verifikasi Email - FutsalGo')

@section('content')
<div class="w-full max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center mb-6">Verifikasi Email</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="mb-4">
            <label class="block text-sm font-medium">Kode OTP</label>
            <input type="text" name="otp" class="w-full px-3 py-2 border rounded" required>
        </div>

        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
            Verifikasi
        </button>
    </form>

    <form method="POST" action="{{ route('otp.send') }}" class="mt-3 text-center">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <button type="submit" class="text-sm text-blue-600 hover:underline">
            Kirim ulang OTP
        </button>
    </form>
</div>
@endsection
