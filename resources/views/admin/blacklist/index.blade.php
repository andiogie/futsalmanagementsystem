@extends('admin.layout')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Daftar Blacklist</h1>
    <p class="mb-6">Kelola daftar nomor WhatsApp yang masuk blacklist.</p>

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

    <x-button href="{{ route('blacklist.create') }}" class="btn-primary mb-4">Tambah Blacklist</x-button>

    {{-- Desktop --}}
    <div class="hidden sm:block overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">Nomor WhatsApp</th>
                    <th class="p-2 border">Alasan</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($blacklists as $b)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 border text-center">{{ $b->id }}</td>
                        <td class="p-2 border text-center">{{ $b->whatsapp }}</td>
                        <td class="p-2 border text-center">{{ $b->alasan }}</td>
                        <td class="p-2 border text-center">
                            <div class="flex justify-center gap-2">
                                <form action="{{ route('blacklist.destroy', $b->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin mau hapus data ini?')">
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
                        <td colspan="4" class="p-4 text-center text-gray-500">Belum ada data blacklist</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile --}}
    <div class="block sm:hidden space-y-4">
        @forelse ($blacklists as $b)
            <div class="bg-white p-4 rounded-lg shadow-md border">
                <p><span class="font-semibold">ID :</span> {{ $b->id }}</p>
                <p><span class="font-semibold">Nomor WhatsApp :</span> {{ $b->whatsapp }}</p>
                <p><span class="font-semibold">Alasan :</span> {{ $b->alasan }}</p>

                <div class="flex gap-2 mt-3">
                    <form action="{{ route('blacklist.destroy', $b->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin mau hapus data ini?')" 
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
            <p class="text-center text-gray-500">Belum ada data blacklist</p>
        @endforelse
    </div>
@endsection
