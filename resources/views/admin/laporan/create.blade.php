@extends('admin.layout')

@section('content')
<h1 class="text-2xl font-bold mb-6">Tambah Transaksi</h1>

<form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-4">
    @csrf

    <div>
        <label class="block text-sm font-medium">Tanggal</label>
        <input type="date" name="tanggal" class="border rounded p-2 w-full" required>
    </div>

    <div>
        <label class="block text-sm font-medium">Deskripsi</label>
        <input type="text" name="deskripsi" class="border rounded p-2 w-full" required>
    </div>

    <div>
        <label class="block text-sm font-medium">Tipe</label>
        <select name="tipe" class="border rounded p-2 w-full" required>
            <option value="Pemasukan">Pemasukan</option>
            <option value="Pengeluaran">Pengeluaran</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium">Metode</label>
        <select name="metode" class="border rounded p-2 w-full">
            <option value="">-- Pilih Metode --</option>
            <option value="Cash">Cash</option>
            <option value="QRIS">QRIS</option>
            <option value="Transfer">Transfer</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium">Jumlah</label>
        <input type="number" name="jumlah" class="border rounded p-2 w-full" required>
    </div>

    <div>
        <label class="block text-sm font-medium">Upload Bukti (opsional)</label>
        <input type="file" name="bukti" accept="image/*" class="border rounded p-2 w-full">
    </div>

    <button type="submit" 
        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">Simpan</button>
    <a href="{{ route('laporan.index') }}" 
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">
        Batal
    </a>
</form>
@endsection
