@extends('auth.auth')

@section('title', 'Login - FutsalGo')

@section('content')
<div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

    {{-- Success message --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
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

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" 
                class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-500" 
                required>
        </div>

        {{-- Password --}}
        <div class="mb-6 relative">
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" id="password"
                class="w-full px-3 py-2 border rounded pr-16 focus:outline-none focus:ring-2 focus:ring-green-500" 
                required>

            <!-- Tombol Show / Hide -->
            <button type="button" id="togglePassword"
                class="absolute right-3 top-[33px] text-sm text-green-600 hover:underline">
                Show
            </button>
        </div>

        {{-- Submit --}}
        <button type="submit" id="global-spinner"
            class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
            Login
        </button>
    </form>

    {{-- Links --}}
    <div class="flex justify-between mt-4 text-sm">
        <a href="{{ url('/daftar_member') }}" class="text-green-600 hover:underline">
            Daftar sebagai member
        </a>
        <a href="{{ url('/forgot') }}" class="text-gray-600 hover:underline">
            Lupa password?
        </a>
    </div>
</div>


@endsection
