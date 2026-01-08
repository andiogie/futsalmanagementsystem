@extends('admin.layout')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Master Rekening</h1>
    <p class="mb-6">Daftar rekening bank & e-wallet untuk pembayaran futsal.</p>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <x-button href="{{ route('rekening.create') }}" class="btn-primary mb-4">Tambah Rekening</x-button>

    {{-- Desktop --}}
    <div class="hidden sm:block overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">Nama Bank</th>
                    <th class="p-2 border">No Rekening / Akun</th>
                    <th class="p-2 border">Atas Nama</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rekenings as $rekening)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 border text-center">{{ $rekening->id }}</td>
                        <td class="p-2 border text-center">{{ $rekening->bank_name }}</td>
                        <td class="p-2 border text-center">{{ $rekening->bank_account }}</td>
                        <td class="p-2 border text-center">{{ $rekening->account_name }}</td>
                        <td class="p-2 border text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('rekening.edit', $rekening->id) }}" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('rekening.destroy', $rekening->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin hapus rekening ini?')">
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
                            Belum ada rekening
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 📱 Versi Mobile / Card --}}
    <div class="block sm:hidden space-y-4 mt-4">
        @forelse ($rekenings as $rekening)
            <div class="bg-white p-4 rounded-lg shadow-md border">
                <p><span class="font-semibold">ID:</span> {{ $rekening->id }}</p>
                <p><span class="font-semibold">Nama Bank:</span> {{ $rekening->bank_name }}</p>
                <p><span class="font-semibold">No Rekening / Akun:</span> {{ $rekening->bank_account }}</p>
                <p><span class="font-semibold">Atas Nama:</span> {{ $rekening->account_name }}</p>

                <div class="flex gap-2 mt-3">
                    <a href="{{ route('rekening.edit', $rekening->id) }}"
                       class="flex-1 px-3 py-1 text-center bg-blue-500 text-white rounded hover:bg-blue-600">
                        Edit
                    </a>
                    <form action="{{ route('rekening.destroy', $rekening->id) }}" method="POST" class="flex-1"
                          onsubmit="return confirm('Yakin hapus rekening ini?')">
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
            <p class="text-center text-gray-500">Belum ada rekening</p>
        @endforelse
    </div>
@endsection
