@extends('admin.layout')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Tambah Rekening</h1>

    <form action="{{ route('rekening.store') }}" method="POST" class="space-y-4 bg-white p-6 shadow rounded-lg">
        @csrf
        <div>
            <label class="block font-medium">Nama Bank / E-Wallet</label>
            <input type="text" name="bank_name" value="{{ old('bank_name') }}" 
                   class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block font-medium">Nomor Rekening / Nomor HP</label>
            <input type="text" name="bank_account" value="{{ old('bank_account') }}" 
                   class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block font-medium">Nama Pemilik</label>
            <input type="text" name="account_name" value="{{ old('account_name') }}" 
                   class="w-full border p-2 rounded" required>
        </div>

        <button type="submit" 
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">Simpan</button>
        <a href="{{ route('rekening.index') }}" 
            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">
            Batal
        </a>
    </form>
</div>
@endsection
