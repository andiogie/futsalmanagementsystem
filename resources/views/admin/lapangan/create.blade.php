@extends('admin.layout')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Tambah Master Lapangan</h1>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('lapangan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded shadow-md">
        @csrf

        <!-- Nama Lapangan -->
        <div>
            <label class="block font-semibold mb-1">Nama Lapangan</label>
            <input type="text" name="nama_lapangan" class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-400" value="{{ old('nama_lapangan') }}" required>
        </div>

        <!-- Foto Lapangan -->
        <div>
            <label class="block font-semibold mb-1">Foto Lapangan (opsional)</label>
            <input type="file" name="foto_lapangan" class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        <!-- Tarif -->
        <div>
            <label class="block font-semibold mb-1">Tarif (Rp)</label>
            <input type="number" name="tarif" class="w-full border rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-green-400" value="{{ old('tarif') }}" required>
        </div>

    <button type="submit" 
        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">Simpan</button>
    <a href="{{ route('lapangan.index') }}" 
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">
        Batal
    </a>
    </form>
@endsection
