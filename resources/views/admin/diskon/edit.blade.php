@extends('admin.layout')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Diskon</h1>

<form action="{{ route('diskon.update', $diskon->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium">Nama Diskon</label>
        <input type="text" name="nama_diskon" value="{{ old('nama_diskon', $diskon->nama_diskon) }}" 
            class="border rounded p-2 w-full" required>
    </div>

    <div>
        <label class="block text-sm font-medium">Kode Diskon (opsional)</label>
        <input type="text" name="kode" value="{{ old('kode', $diskon->kode) }}" 
            class="border rounded p-2 w-full">
    </div>

    <div>
        <label class="block text-sm font-medium">Tipe Diskon</label>
        <select name="tipe" class="border rounded p-2 w-full">
            <option value="persentase" {{ old('tipe', $diskon->tipe) == 'persentase' ? 'selected' : '' }}>Persentase</option>
            <option value="nominal" {{ old('tipe', $diskon->tipe) == 'nominal' ? 'selected' : '' }}>Nominal</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium">Nilai Diskon</label>
        <input type="number" name="nilai" value="{{ old('nilai', $diskon->nilai) }}" 
            class="border rounded p-2 w-full" required min="1">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Jam Mulai</label>
            <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $diskon->jam_mulai) }}" 
                class="border rounded p-2 w-full">
        </div>
        <div>
            <label class="block text-sm font-medium">Jam Selesai</label>
            <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $diskon->jam_selesai) }}" 
                class="border rounded p-2 w-full">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium">Tanggal Mulai</label>
            <input type="date" name="mulai" value="{{ old('mulai', $diskon->mulai) }}" 
                class="border rounded p-2 w-full">
        </div>
        <div>
            <label class="block text-sm font-medium">Tanggal Berakhir</label>
            <input type="date" name="berakhir" value="{{ old('berakhir', $diskon->berakhir) }}" 
                class="border rounded p-2 w-full">
        </div>
    </div>

    <button type="submit" 
        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">Update</button>
    <a href="{{ route('diskon.index') }}" 
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">
        Batal
    </a>
</form>
@endsection
