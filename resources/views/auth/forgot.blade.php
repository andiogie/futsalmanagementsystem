@extends('auth.auth')

@section('title', 'Lupa Password - FutsalGo')

@section('content')
<div class="w-full max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">

    <h2 class="text-2xl font-bold text-center mb-6">Lupa Password</h2>

    {{-- Success message --}}
    @if (session('status'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('status') }}
        </div>
    @endif

    {{-- Error messages --}}
    @if ($errors->any())
        <div class="mb-4 text-red-600 space-y-1">
            @foreach ($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" 
                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500" 
                placeholder="Masukkan email Anda" required>
        </div>

        <button type="submit" 
            class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
            Kirim Link Reset Password
        </button>
    </form>

    <div class="flex justify-between mt-4 text-sm">
        <a href="{{ route('login') }}" class="text-gray-600 hover:underline">
            Kembali ke login
        </a>
        <a href="{{ url('/daftar_member') }}" class="text-green-600 hover:underline">
            Daftar sebagai member
        </a>
    </div>
</div>
@endsection
