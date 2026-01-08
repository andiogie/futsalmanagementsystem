@extends('auth.auth')

@section('title', 'Daftar Member - FutsalGo')

@section('content')
{{-- pastikan di <head> auth.blade.php ada: <style>[x-cloak]{display:none !important}</style> --}}

<div x-data="{ showEula: false, agreed: false }" class="w-full max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">

    <h2 class="text-2xl font-bold text-center mb-6">Daftar Member</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register.member') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium">No WhatsApp</label>
            <input type="text" name="nowa" value="{{ old('nowa') }}" class="w-full px-3 py-2 border rounded" required>
        </div>

<div class="mb-4 relative">
    <label class="block text-sm font-medium">Password</label>
    <input type="password" name="password" id="password"
           class="w-full px-3 py-2 border rounded pr-16" required>

    <button type="button" id="togglePassword"
            class="absolute right-3 top-[30px] text-sm text-green-600 hover:underline">
        Show
    </button>
</div>

<div class="mb-4 relative">
    <label class="block text-sm font-medium">Konfirmasi Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation"
           class="w-full px-3 py-2 border rounded pr-16" required>

    <button type="button" id="togglePasswordConfirmation"
            class="absolute right-3 top-[30px] text-sm text-green-600 hover:underline">
        Show
    </button>
</div>


        <!-- hidden value supaya backend tahu user sudah setuju -->
        <input type="hidden" name="agreed" :value="agreed ? 1 : 0">

        <div class="flex items-center gap-3 mt-3 mb-6">
            <!-- Checkbox hanya memicu modal, tidak langsung men-set agreed -->
            <input type="checkbox" id="eula" class="mr-2" :checked="agreed" @click.prevent="showEula = true">
            <label for="eula" class="text-sm">Saya setuju dengan syarat & ketentuan</label>
        </div>

        <div class="flex gap-2">
            <button type="submit"
                :disabled="!agreed"
                class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 disabled:opacity-50">
                Daftar
            </button>

            <a href="{{ route('login') }}"
               class="w-full text-center bg-red-600 text-white py-2 rounded hover:bg-gray-400">
                Batal
            </a>
        </div>
    </form>

    <!-- Modal EULA: ADA DI DALAM SCOPE x-data -->
    <div x-show="showEula" x-cloak
         class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div @click.away="showEula = false" class="bg-white w-11/12 max-w-lg p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-bold mb-4">Syarat & Ketentuan</h3>
            <div class="text-sm space-y-2 max-h-60 overflow-y-auto mb-4">
                <p>✅ Pastikan data yang Anda masukkan benar dan valid.</p>
                <p>🚫 Dilarang keras melakukan booking palsu (fake booking).</p>
                <p>📵 Nomor WhatsApp Anda bisa masuk blacklist jika terbukti melakukan pelanggaran.</p>
                <p>⚖️ Admin berhak membatalkan booking jika terjadi kecurangan.</p>
            </div>

            <div class="flex justify-end space-x-2">
                <button @click="showEula=false; agreed=false" class="px-4 py-2 bg-gray-300 rounded">Tolak</button>

                <!-- jika setuju: set agreed true lalu close modal -->
                <button @click="agreed = true; showEula = false" class="px-4 py-2 bg-green-600 text-white rounded">
                    Saya Setuju
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
