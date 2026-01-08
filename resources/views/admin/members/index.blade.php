@extends('admin.layout')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Cek Member Futsal</h1>
    <p class="mb-6">Daftar member futsal beserta detailnya.</p>
    
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

    <x-button href="{{ route('members.create') }}" class="btn-primary">Tambah Member</x-button>

    <form action="{{ route('members.search') }}" method="GET" class="mb-4 flex gap-2">
        <input type="text" name="q" placeholder="Cari nama / No WA" 
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
                    <th class="p-2 border">Email</th>
                    <th class="p-2 border">No WhatsApp</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="p-2 border">{{ $user->id }}</td>
                        <td class="p-2 border">{{ $user->name }}</td>
                        <td class="p-2 border">{{ $user->email }}</td>
                        <td class="p-2 border">{{ $user->nowa }}</td>
                        <td class="p-2 border">
                            <div class="flex flex-col sm:flex-row gap-2">
                                @if($user->roles === 'owner')
                                <p class="text-gray-400 italic"> This Roles Cannot be edit </p>
                                @else
                                    <a href="{{ route('members.edit', $user->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">    
                                        Edit</a>
                                <a href="#" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Hapus</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center border">Belum ada member</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
    {{ $users->links() }}
</div>
    </div>

    {{-- ✅ Versi Card (untuk layar < sm / member) --}}
    <div class="block sm:hidden space-y-4">
        @forelse ($users as $user)
            <div class="bg-white p-4 rounded-lg shadow-md border">
                <p><span class="font-semibold">ID:</span> {{ $user->id }}</p>
                <p><span class="font-semibold">Nama:</span> {{ $user->name }}</p>
                <p><span class="font-semibold">Email:</span> {{ $user->email }}</p>
                <p><span class="font-semibold">No WhatsApp:</span> {{ $user->nowa }}</p>
                @if($user->roles === 'owner')
                <p class="text-gray-400 italic"> This Roles Cannot be edit </p>
                @else
                <div class="flex gap-2 mt-3">
                    <a href="{{ route('members.edit', $user->id) }}" class="flex-1 px-3 py-1 text-center bg-blue-500 text-white rounded hover:bg-blue-600">Edit</a>
                    <a href="members.index" class="flex-1 px-3 py-1 text-center bg-red-500 text-white rounded hover:bg-red-600">Hapus</a>
                </div>
                @endif
            </div>
        @empty
            <p class="text-center text-gray-500">Belum ada member</p>
        @endforelse
        <div class="mt-4">
    {{ $users->links() }}
</div>
    </div>
@endsection