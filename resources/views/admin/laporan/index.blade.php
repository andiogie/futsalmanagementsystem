@extends('admin.layout')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Laporan Keuangan</h1>
    <p class="mb-6">Laporan keuangan untuk pengecekan data pemasukan dan pengeluaran.</p>
    
    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif
    
    <x-button href="{{ route('laporan.create') }}" class="btn-primary">Tambah Transaksi</x-button>


    <!-- Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-sm font-semibold">Total Pemasukan</h2>
            <p class="text-xl sm:text-2xl font-bold text-green-600">
                Rp {{ number_format($total_pemasukan, 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-sm font-semibold">Total Pengeluaran</h2>
            <p class="text-xl sm:text-2xl font-bold text-red-600">
                Rp {{ number_format($pengeluaran, 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-sm font-semibold">Laba Bersih</h2>
            <p class="text-xl sm:text-2xl font-bold text-blue-600">
                Rp {{ number_format($laba, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <!-- Filter tanggal -->
<div class="mb-6 bg-white p-4 rounded-lg shadow">
    <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-col sm:flex-row gap-3">
        <div>
            <label class="block text-sm font-medium">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}"
                   class="border rounded px-3 py-2 w-full">
        </div>
        <div>
            <label class="block text-sm font-medium">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}"
                   class="border rounded px-3 py-2 w-full">
        </div>
        <div class="flex items-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Filter
            </button>
        </div>
    </form>
</div>
    <!-- ✅ Tabel versi desktop -->
    <div class="hidden sm:block bg-white p-4 rounded-lg shadow overflow-x-auto">
        <h2 class="text-lg font-semibold mb-4">Detail Transaksi Bulan Ini</h2>
        <table class="min-w-full border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2 border">Tanggal</th>
                    <th class="px-4 py-2 border">Deskripsi</th>
                    <th class="px-4 py-2 border">Tipe</th>
                    <th class="px-4 py-2 border">Metode</th>
                    <th class="px-4 py-2 border">Jumlah</th>
                    <th class="px-4 py-2 border">Bukti Bayar</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $t)
                    <tr>
                        <td class="border px-4 py-2">{{ $t->tanggal }}</td>
                        <td class="border px-4 py-2">{{ $t->deskripsi }}</td>
                        <td class="border px-4 py-2">
                            @if($t->tipe === 'Pemasukan')
                                <span class="text-green-600 font-semibold">{{ $t->tipe }}</span>
                            @else
                                <span class="text-red-600 font-semibold">{{ $t->tipe }}</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2">{{ $t->metode }}</td>
                        <td class="border px-4 py-2">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                        <td class="p-2 border">
                            @if($t->bukti)
                                <a href="{{ asset('storage/' . $t->bukti) }}" target="_blank" class="text-blue-600 text-sm font-medium underline hover:text-blue-800 transition">
                                    Lihat Bukti
                                </a>
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </td>
                        <td class="border px-4 py-2">
                            @if($t->sumber === 'laporans')
                                <a href="{{ route('laporan.edit', $t->id) }}" 
                                    class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
                                <form action="{{ route('laporan.destroy', $t->id) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Yakin hapus transaksi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
                                </form>
                            @elseif($t->sumber === 'bookings')
                                <span class="text-gray-400 italic">Auto (Booking)</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Belum ada transaksi bulan ini</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
<div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4">
    {{-- Showing data (kiri) --}}
    <div class="text-sm text-gray-600">
        Menampilkan {{ $transaksi->firstItem() }} - {{ $transaksi->lastItem() }} dari {{ $transaksi->total() }} data
    </div>

    {{-- Tombol Export PDF (tengah) --}}
    <div class="flex-1 flex justify-center">
        <a href="{{ route('laporan.export.pdf', ['month' => now()->month, 'year' => now()->year]) }}"
           class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
           Export PDF
        </a>
    </div>

    {{-- Pagination (kanan) --}}
    <div>
        {{ $transaksi->links() }}
    </div>
</div>
    </div>

    <!-- ✅ Card versi member -->
    <div class="block sm:hidden space-y-4">
        @forelse($transaksi as $t)
            <div class="bg-white p-4 rounded-lg shadow border">
                <p><span class="font-semibold">Tanggal:</span> {{ $t->tanggal }}</p>
                <p><span class="font-semibold">Deskripsi:</span> {{ $t->deskripsi }}</p>
                <p>
                    <span class="font-semibold">Tipe:</span>
                    @if($t->tipe === 'Pemasukan')
                        <span class="text-green-600 font-semibold">{{ $t->tipe }}</span>
                    @else
                        <span class="text-red-600 font-semibold">{{ $t->tipe }}</span>
                    @endif
                </p>
                <p><span class="font-semibold">Metode:</span> {{ $t->metode }}</p>
                <p><span class="font-semibold">Jumlah:</span> Rp {{ number_format($t->jumlah, 0, ',', '.') }}</p>

                <div class="flex gap-2 mt-3">
                    @if($t->sumber === 'laporans')
                        <a href="{{ route('laporan.edit', $t->id) }}" 
                           class="flex-1 px-3 py-1 text-center bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
                        <form action="{{ route('laporan.destroy', $t->id) }}" method="POST"
                              class="flex-1" onsubmit="return confirm('Yakin hapus transaksi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
                        </form>
                    @elseif($t->sumber === 'bookings')
                        <span class="text-gray-400 italic">Auto (Booking)</span>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">Belum ada transaksi bulan ini</p>
        @endforelse
<div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-4">
    {{-- Showing data (kiri) --}}
    <div class="text-sm text-gray-600">
        Menampilkan {{ $transaksi->firstItem() }} - {{ $transaksi->lastItem() }} dari {{ $transaksi->total() }} data
    </div>

    {{-- Tombol Export PDF (tengah) --}}
    <div class="flex-1 flex justify-center">
        <a href="{{ route('laporan.export.pdf', ['month' => now()->month, 'year' => now()->year]) }}"
           class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
           Export PDF
        </a>
    </div>

    {{-- Pagination (kanan) --}}
    <div>
        {{ $transaksi->links() }}
    </div>
</div>
    </div>
@endsection