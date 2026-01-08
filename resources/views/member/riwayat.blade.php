@extends('member.layout')

@section('content')
<h1 class="text-2xl font-bold mb-4 text-center">Riwayat Pesanan</h1>

{{-- Notifikasi sukses/error --}}
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        {{ session('error') }}
    </div>
@endif

{{-- Form search --}}
<form action="{{ route('member.riwayat') }}" method="GET" class="mb-4 flex gap-2">
    <input type="text" name="q" placeholder="Cari nama / WA / invoice" 
           class="border rounded p-2 w-full" value="{{ request('q') }}">
    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Cari</button>
</form>

{{-- Tabel desktop --}}
<div class="hidden sm:block overflow-x-auto bg-white shadow-md rounded-lg">
    <table class="min-w-full border border-gray-300 text-left text-sm">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2 border">Invoice</th>
                <th class="p-2 border">Tanggal</th>
                <th class="p-2 border">Lapangan</th>
                <th class="p-2 border">Jam</th>
                <th class="p-2 border">Durasi</th>
                <th class="p-2 border">Tarif</th>
                <th class="p-2 border">Payment Type</th>
                <th class="p-2 border">Status Bayar</th>
                <th class="p-2 border">Bukti Bayar</th>
                <th class="p-2 border">Catatan</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $b)
                <tr class="hover:bg-gray-50">
                    <td class="p-2 border font-semibold text-green-700">{{ $b->invoice_no }}</td>
                    <td class="p-2 border">{{ \Carbon\Carbon::parse($b->tanggal)->format('d M Y') }}</td>
                    <td class="p-2 border">{{ $b->lapangan->nama_lapangan ?? '-' }}</td>
                    <td class="p-2 border">{{ $b->jam_mulai }} - {{ $b->jam_selesai }}</td>
                    <td class="p-2 border">{{ $b->durasi }} jam</td>
                    <td class="p-2 border">Rp {{ number_format($b->tarif,0,',','.') }}</td>
                    <td class="p-2 border">{{ $b->payment_type ?? '-' }}</td>
                    <td class="p-2 border">
                        @if($b->payment_status == 'Paid')
                            <span class="px-2 py-1 text-xs rounded bg-green-200 text-green-800">Paid</span>
                        @elseif($b->payment_status == 'Pending')
                            <span class="px-2 py-1 text-xs rounded bg-yellow-200 text-yellow-800">Pending</span>
                        @elseif($b->payment_status == 'Cancel')
                            <span class="px-2 py-1 text-xs rounded bg-red-200 text-red-800">Cancel</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-800">-</span>
                        @endif
                    </td>
                    <td class="p-2 border">
                        @if(!$b->payment_proof)
                            <form action="{{ route('member.riwayat.uploadBukti', $b->id) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                                @csrf
                                <input type="file" name="payment_proof" accept="image/*" class="text-sm">
                                <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded text-xs">Upload</button>
                            </form>
                        @else
                            <a href="{{ asset('storage/' . $b->payment_proof) }}" target="_blank" class="text-blue-600 text-xs underline">Lihat Bukti</a>
                        @endif
                    </td>
                    <td class="p-2 border">{{ $b->notes }}</td>
                    <td class="p-2 border">
    <a href="{{ route('member.riwayat.invoice', $b->id) }}" 
       class="bg-blue-500 text-white px-3 py-1 rounded text-xs">Cetak</a>
</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="p-4 text-center text-gray-500">Belum ada riwayat pesanan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $bookings->links() }}</div>
</div>

{{-- Card/list member --}}
<div class="block sm:hidden space-y-4">
    @forelse ($bookings as $b)
        <div class="bg-white p-4 rounded-lg shadow-md border">
            <p><span class="font-semibold">Invoice :</span> {{ $b->invoice_no }}</p>
            <p><span class="font-semibold">Tanggal :</span> {{ \Carbon\Carbon::parse($b->tanggal)->format('d M Y') }}</p>
            <p><span class="font-semibold">Lapangan :</span> {{ $b->lapangan->nama_lapangan ?? '-' }}</p>
            <p><span class="font-semibold">Jam :</span> {{ $b->jam_mulai }} - {{ $b->jam_selesai }}</p>
            <p><span class="font-semibold">Durasi :</span> {{ $b->durasi }} jam</p>
            <p><span class="font-semibold">Tarif :</span> Rp {{ number_format($b->tarif,0,',','.') }}</p>
            <p><span class="font-semibold">Payment Type :</span> {{ $b->payment_type ?? '-' }}</p>
            <p><span class="font-semibold">Status Bayar :</span>
                @if($b->payment_status == 'Paid')
                    <span class="px-2 py-1 text-xs rounded bg-green-200 text-green-800">Paid</span>
                @elseif($b->payment_status == 'Pending')
                    <span class="px-2 py-1 text-xs rounded bg-yellow-200 text-yellow-800">Pending</span>
                @elseif($b->payment_status == 'Cancel')
                    <span class="px-2 py-1 text-xs rounded bg-red-200 text-red-800">Cancel</span>
                @else
                    <span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-800">-</span>
                @endif
            </p>
            <p><span class="font-semibold">Bukti Bayar:</span>
                <td class="p-2 border">
    @if(!$b->payment_proof)
        <form action="{{ route('member.riwayat.uploadBukti', $b->id) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
            @csrf
            <input type="file" name="payment_proof" accept="image/*" class="text-sm">
            <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded text-xs">Upload</button>
        </form>
    @else
        <a href="{{ asset('storage/' . $b->payment_proof) }}" target="_blank" class="text-blue-600 text-xs underline">Lihat Bukti</a>
    @endif
</td>
</p>
            <p><span class="font-semibold">Catatan :</span> {{ $b->notes }}</p>
            <p><a href="{{ route('member.riwayat.invoice', $b->id) }}" 
   class="inline-block mt-2 bg-blue-500 text-white px-3 py-1 rounded text-xs">Cetak Invoice</a>
</p>
        </div>
    @empty
        <p class="text-center text-gray-500">Belum ada riwayat pesanan.</p>
    @endforelse
    <div class="mt-4">{{ $bookings->links() }}</div>
</div>
@endsection
