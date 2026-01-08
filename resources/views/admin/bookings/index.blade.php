@extends('admin.layout')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Cek Status Booking</h1>
    <p class="mb-6">Daftar halaman booking beserta status nya.</p>
    
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

    <x-button href="{{ route('bookings.non_member.create') }}" class="btn-primary">Tambah Booking</x-button>
    
    <form action="{{ route('bookings.search') }}" method="GET" class="mb-4 flex gap-2">
        <input type="text" name="q" placeholder="Cari nama / WA / invoice" 
            class="border rounded p-2 w-full">
        <x-button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
            Cari
        </x-button>
    </form>

    {{-- Desktop --}}
    <div class="hidden sm:block overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">Invoice No</th>
                    <th class="p-2 border">WhatsApp</th>
                    <th class="p-2 border">Tanggal</th>
                    <th class="p-2 border">Lapangan</th>
                    <th class="p-2 border">Jam Mulai</th>
                    <th class="p-2 border">Jam Selesai</th>
                    <th class="p-2 border">Durasi</th>
                    <th class="p-2 border">Tarif</th>
                    <th class="p-2 border">Payment Type</th>
                    <th class="p-2 border">Status Bayar</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $booking)
                    <tr>
                        <td class="p-2 border">{{ $booking->id }}</td>
                        <td class="p-2 border">{{ $booking->nama }}</td>
                        <td class="p-2 border">{{ $booking->invoice_no }}</td>
                        <td class="p-2 border">{{ $booking->whatsapp }}</td>
                        <td class="p-2 border">{{ $booking->tanggal }}</td>
                        <td class="p-2 border">{{ $booking->lapangan?->nama_lapangan }}</td>
                        <td class="p-2 border">{{ $booking->jam_mulai }}</td>
                        <td class="p-2 border">{{ $booking->jam_selesai }}</td>
                        <td class="p-2 border">{{ $booking->durasi }} Jam</td>
                        <td class="p-2 border">Rp {{ number_format($booking->tarif, 0, ',', '.') }}</td>
                        <td class="p-2 border">
                            {{ $booking->payment_type ?? '-' }}
                        </td>
                        <td class="p-2 border">
                            @if ($booking->payment_status == 'Paid')
                                <span class="px-2 py-1 text-xs rounded bg-green-200 text-green-800">Paid</span>
                            @elseif ($booking->payment_status == 'Pending')
                                <span class="px-2 py-1 text-xs rounded bg-yellow-200 text-yellow-800">Pending</span>
                            @elseif ($booking->payment_status == 'Cancel')
                                <span class="px-2 py-1 text-xs rounded bg-red-200 text-red-800">Cancel</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-800">-</span>
                            @endif
                        </td>
                        <td class="p-2 border">
                            <a href="{{ route('bookings.edit', $booking->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="p-4 text-center text-gray-500">Belum ada data booking</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $bookings->links() }}
        </div>
    </div>

    {{-- ✅ Card/list untuk member --}}
    <div class="block sm:hidden space-y-4">
        @forelse ($bookings as $booking)
            <div class="bg-white p-4 rounded-lg shadow-md border">
                <p><span class="font-semibold">ID :</span> {{ $booking->id }}</p>
                <p><span class="font-semibold">Nama :</span> {{ $booking->nama }}</p>
                <p><span class="font-semibold">Invoice No :</span> {{ $booking->invoice_no }}</p>
                <p><span class="font-semibold">WhatsApp :</span> {{ $booking->whatsapp }}</p>
                <p><span class="font-semibold">Tanggal :</span> {{ $booking->tanggal }}</p>
                <p><span class="font-semibold">Tanggal :</span> {{ $booking->lapangan?->nama_lapangan }}</p>
                <p><span class="font-semibold">Jam Mulai :</span> {{ $booking->jam_mulai }}</p>
                <p><span class="font-semibold">Jam Selesai :</span> {{ $booking->jam_selesai }}</p>
                <p><span class="font-semibold">Durasi :</span> {{ $booking->durasi }} Jam</p>
                <p><span class="font-semibold">Tarif :</span> Rp {{ number_format($booking->tarif, 0, ',', '.') }}</p>
                <p><span class="font-semibold">Payment Type :</span> {{ $booking->payment_type ?? '-' }}</p>
                <p><span class="font-semibold">Status Bayar :</span>
                    @if ($booking->payment_status == 'Paid')
                        <span class="px-2 py-1 text-xs rounded bg-green-200 text-green-800">Paid</span>
                    @elseif ($booking->payment_status == 'Pending')
                        <span class="px-2 py-1 text-xs rounded bg-yellow-200 text-yellow-800">Pending</span>
                    @elseif ($booking->payment_status == 'Cancel')
                        <span class="px-2 py-1 text-xs rounded bg-red-200 text-red-800">Cancel</span>
                    @else
                        <span class="px-2 py-1 text-xs rounded bg-gray-200 text-gray-800">-</span>
                    @endif
                </p>

                <div class="flex gap-2 mt-3">
                    <a href="{{ route('bookings.edit', $booking->id) }}" class="flex-1 px-3 py-1 text-center bg-blue-500 text-white rounded hover:bg-blue-600">Edit</a>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">Belum ada data booking</p>
        @endforelse
        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection