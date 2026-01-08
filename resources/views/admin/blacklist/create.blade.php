@extends('admin.layout')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Tambah Blacklist</h1>

    <form action="{{ route('blacklist.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block">Nomor WhatsApp</label>
            <input type="text" name="whatsapp" class="border p-2 w-full" required>
        </div>

        <div>
            <label class="block">Alasan</label>
            <input type="text" name="alasan" class="border p-2 w-full">
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('blacklist.index') }}" class="ml-2">Kembali</a>
    </form>
</div>
@endsection
