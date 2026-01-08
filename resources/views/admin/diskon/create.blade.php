@extends('admin.layout')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Tambah Diskon</h1>

    <form action="{{ route('diskon.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow-md">
        @csrf

        {{-- Nama Diskon --}}
        <div>
            <label class="block text-sm font-medium mb-1">Nama Diskon</label>
            <input type="text" name="nama_diskon" class="w-full border rounded p-2" required>
        </div>

        {{-- Kode Diskon --}}
        <div>
            <label class="block text-sm font-medium mb-1">Kode Diskon</label>
            <input type="text" name="kode" class="w-full border rounded p-2" placeholder="Opsional (misal: HEMAT10)">
        </div>

        {{-- Tipe Diskon --}}
        <div>
            <label class="block text-sm font-medium mb-1">Tipe Diskon</label>
            <select name="tipe" class="w-full border rounded p-2">
                <option value="persentase" selected>Persentase (%)</option>
                <option value="nominal">Nominal (Rp)</option>
            </select>
        </div>

        {{-- Nilai Diskon --}}
        <div>
            <label class="block text-sm font-medium mb-1">Nilai Diskon</label>
            <input type="number" name="nilai" class="w-full border rounded p-2" required min="1" placeholder="Contoh: 10 atau 5000">
        </div>

        {{-- Jam Berlaku --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Jam Mulai</label>
                <input type="time" name="jam_mulai" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Jam Selesai</label>
                <input type="time" name="jam_selesai" class="w-full border rounded p-2">
            </div>
        </div>

        {{-- Periode Berlaku --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Mulai</label>
                <input type="date" name="mulai" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Berakhir</label>
                <input type="date" name="berakhir" class="w-full border rounded p-2">
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <button type="submit" 
        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">Simpan</button>
    <a href="{{ route('diskon.index') }}" 
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">
        Batal
    </a>
    </form>
@endsection
