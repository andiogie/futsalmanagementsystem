@extends('admin.layout')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Tambah Member</h1>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('members.store') }}" method="POST" class="bg-white p-6 shadow rounded space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-gray-700">Nomor WhatsApp</label>
            <input type="text" name="nowa" value="{{ old('nowa') }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label for="role" class="block font-medium mb-1">Role</label>
            <select name="role" id="role" class="w-full border rounded px-3 py-2 bg-white">
                <option value="admin" {{ old('role') == 'owner' ? 'selected' : '' }}>Owner</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Password</label>
            <input type="password" name="password"
                   class="w-full border rounded px-3 py-2">
        </div>

        <button type="submit" 
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">Simpan</button>
        <a href="{{ route('members.index') }}" 
            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-semibold shadow-sm transition inline-flex items-center justify-center">
            Batal
        </a>
    </form>
@endsection
