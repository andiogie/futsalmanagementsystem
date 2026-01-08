@extends('admin.layout')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Manajemen Diskon</h1>
    <p class="mb-6">Kelola daftar diskon yang tersedia untuk pelanggan.</p>

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

    <x-button href="{{ route('diskon.create') }}" class="btn-primary mb-4">Tambah Diskon</x-button>

    {{-- Desktop --}}
    <div class="hidden sm:block overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">Nama Diskon</th>
                    <th class="p-2 border">Kode</th>
                    <th class="p-2 border">Nilai (%)</th>
                    <th class="p-2 border">Periode</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($diskons as $diskon)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 border text-center">{{ $diskon->id }}</td>
                        <td class="p-2 border text-center">{{ $diskon->nama_diskon }}</td>
                        <td class="p-2 border text-center">{{ $diskon->kode }}</td>
                        {{-- <td class="p-2 border text-center">{{ $diskon->nilai }}%</td> --}}
                        <td class="p-2 border text-center">
                            @if ($diskon->tipe === 'persen')
                                {{ $diskon->nilai }} %
                            @elseif ($diskon->tipe === 'nominal')
                                Rp {{ number_format($diskon->nilai, 0, ',', '.') }}
                            @else
                                {{ $diskon->nilai }}
                            @endif
                        </td>
                        <td class="p-2 border text-center">
                            {{ $diskon->mulai ? $diskon->mulai : '-' }} s/d 
                            {{ $diskon->berakhir ? $diskon->berakhir : '-' }}
                        </td>
                        <td class="p-2 border text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('diskon.edit', $diskon->id) }}" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('diskon.destroy', $diskon->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin mau hapus diskon ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">Belum ada diskon</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 📱 Card/list untuk mobile --}}
    <div class="block sm:hidden space-y-4">
        @forelse ($diskons as $diskon)
            <div class="bg-white p-4 rounded-lg shadow-md border">
                <p><span class="font-semibold">ID :</span> {{ $diskon->id }}</p>
                <p><span class="font-semibold">Nama Diskon :</span> {{ $diskon->nama_diskon }}</p>
                <p><span class="font-semibold">Kode :</span> {{ $diskon->kode }}</p>
                <p><span class="font-semibold">Nilai :</span> {{ $diskon->nilai }}%</p>
                <p><span class="font-semibold">Periode :</span>
                    {{ $diskon->mulai ? $diskon->mulai : '-' }} s/d 
                    {{ $diskon->berakhir ? $diskon->berakhir : '-' }}
                </p>

                <div class="flex gap-2 mt-3">
                    <a href="{{ route('diskon.edit', $diskon->id) }}" 
                       class="flex-1 px-3 py-1 text-center bg-blue-500 text-white rounded hover:bg-blue-600">
                        Edit
                    </a>
                    <form action="{{ route('diskon.destroy', $diskon->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin mau hapus diskon ini?')" 
                          class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">Belum ada diskon</p>
        @endforelse
    </div>
@endsection
