@extends('member.layout')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit Profil</h1>

    @if (session('success'))
        <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('members.update', auth()->user()->id) }}" method="POST" class="bg-white p-6 shadow rounded space-y-4">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div>
            <label class="block text-gray-700">Nama</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        {{-- No WhatsApp --}}
        <div>
            <label class="block text-gray-700">Nomor WhatsApp</label>
            <input type="text" name="nowa" value="{{ old('nowa', auth()->user()->nowa) }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        {{-- Ganti Password (opsional) --}}
        <div>
            <label class="block text-gray-700">Password Baru</label>
            <input type="password" name="password"
                   placeholder="Kosongkan jika tidak ingin ganti password"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation"
                   placeholder="Ulangi password baru"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
@endsection