@extends('admin.layout')

@section('content')
<h1 class="text-3xl font-bold mb-4">Edit Lapangan</h1>

<form action="{{ route('lapangan.update', $lapangan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded shadow-md">
    @csrf
    @method('PUT')

    <!-- Nama Lapangan -->
    <div>
        <label class="block font-semibold mb-1">Nama Lapangan</label>
        <input type="text" name="nama_lapangan" class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-400" 
               value="{{ old('nama_lapangan', $lapangan->nama_lapangan) }}" required>
        @error('nama_lapangan')<span class="text-red-500">{{ $message }}</span>@enderror
    </div>

    <!-- Foto Lapangan -->
    <div>
        <label class="block font-semibold mb-1">Foto Lapangan (opsional)</label>
        <input type="file" name="foto_lapangan" class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-400">
        @if($lapangan->foto_lapangan)
            <img src="{{ asset($lapangan->foto_lapangan) }}" class="w-32 h-20 object-cover mt-2 rounded">
        @endif
        @error('foto_lapangan')<span class="text-red-500">{{ $message }}</span>@enderror
    </div>

    <!-- Tarif -->
    <div>
        <label class="block font-semibold mb-1">Tarif</label>
        <input type="number" name="tarif" class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-400" 
               value="{{ old('tarif', $lapangan->tarif) }}" required>
        @error('tarif')<span class="text-red-500">{{ $message }}</span>@enderror
    </div>

    <!-- Tombol -->
    <button type="submit" 
        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">Update</button>
    <a href="{{ route('lapangan.index') }}" 
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">
        Batal
    </a>
</form>
@endsection
