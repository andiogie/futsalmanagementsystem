@extends('admin.layout')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Transaksi</h1>

<form action="{{ route('laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium">Tanggal</label>
        <input type="date" name="tanggal" value="{{ $laporan->tanggal }}" class="border rounded p-2 w-full" required>
    </div>

    <div>
        <label class="block text-sm font-medium">Deskripsi</label>
        <input type="text" name="deskripsi" value="{{ $laporan->deskripsi }}" class="border rounded p-2 w-full" required>
    </div>

    <div>
        <label class="block text-sm font-medium">Tipe</label>
        <select name="tipe" class="border rounded p-2 w-full" required>
            <option value="Pemasukan" {{ $laporan->tipe == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
            <option value="Pengeluaran" {{ $laporan->tipe == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium">Metode</label>
        <select name="metode" class="border rounded p-2 w-full">
            <option value="">-- Pilih Metode --</option>
            <option value="Cash" {{ $laporan->metode == 'Cash' ? 'selected' : '' }}>Cash</option>
            <option value="QRIS" {{ $laporan->metode == 'QRIS' ? 'selected' : '' }}>QRIS</option>
            <option value="Transfer" {{ $laporan->metode == 'Transfer' ? 'selected' : '' }}>Transfer</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium">Jumlah</label>
        <input type="number" name="jumlah" value="{{ $laporan->jumlah }}" class="border rounded p-2 w-full" required>
    </div>

    <div>
        <label class="block font-semibold">Bukti Transaksi</label>

        @if($laporan->bukti)
            <div class="mb-2">
                <a href="{{ asset('storage/' . $laporan->bukti) }}" target="_blank" class="text-blue-600 underline">
                    Lihat Bukti
                </a>
            </div>
        @endif

        <input type="file" name="bukti" class="w-full border rounded p-2">
    </div>

    <button type="submit" 
        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">Update</button>
    <a href="{{ route('laporan.index') }}" 
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">
        Batal
    </a>
</form>
@endsection
