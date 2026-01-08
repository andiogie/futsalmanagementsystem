@extends('admin.layout')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Daftar Lapangan</h1>
    <p class="mb-6">Kelola daftar lapangan yang tersedia di sistem.</p>

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

    <x-button href="{{ route('lapangan.create') }}" class="btn-primary mb-4">Tambah Lapangan</x-button>

    {{-- Desktop --}}
    <div class="hidden sm:block overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border text-center">ID</th>
                    <th class="p-2 border">Nama Lapangan</th>
                    <th class="p-2 border text-center">Foto</th>
                    <th class="p-2 border text-center">Tarif</th>
                    <th class="p-2 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lapangan as $l)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 border text-center">{{ $l->id }}</td>
                        <td class="p-2 border">{{ $l->nama_lapangan }}</td>
                        <td class="p-2 border text-center">
                            @if ($l->foto_lapangan)
                                <img src="{{ asset($l->foto_lapangan) }}" 
                                     class="w-20 h-12 object-cover rounded mx-auto">
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="p-2 border text-center">Rp {{ number_format($l->tarif) }}</td>
                        <td class="p-2 border text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('lapangan.edit', $l->id) }}" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('lapangan.destroy', $l->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin mau hapus lapangan ini?')">
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
                        <td colspan="5" class="p-4 text-center text-gray-500">
                            Belum ada lapangan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 📱 Versi Mobile --}}
    <div class="block sm:hidden space-y-4 mt-4">
        @forelse ($lapangan as $l)
            <div class="bg-white p-4 rounded-lg shadow-md border">
                <p><span class="font-semibold">Nama Lapangan :</span> {{ $l->nama_lapangan }}</p>
                <p class="mt-1">
                    <span class="font-semibold">Tarif :</span> Rp {{ number_format($l->tarif) }}
                </p>
                <div class="mt-2">
                    <span class="font-semibold">Foto :</span><br>
                    @if ($l->foto_lapangan)
                        <img src="{{ asset($l->foto_lapangan) }}" 
                             class="w-full h-32 object-cover rounded mt-1">
                    @else
                        <div class="w-full h-32 bg-gray-100 flex items-center justify-center rounded mt-1 text-gray-400">
                            Tidak ada foto
                        </div>
                    @endif
                </div>

                <div class="flex gap-2 mt-4">
                    <a href="{{ route('lapangan.edit', $l->id) }}"
                       class="flex-1 text-center bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                        Edit
                    </a>
                    <form action="{{ route('lapangan.destroy', $l->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin mau hapus lapangan ini?')" 
                          class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500">Belum ada lapangan.</p>
        @endforelse
    </div>
@endsection
