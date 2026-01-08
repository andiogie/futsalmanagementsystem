<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}
    <title>@yield('title', 'Member FutsalGo')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <!-- Tailwind & Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Alert Error -->
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-4">
            <strong>Akses Ditolak!</strong> {{ session('error') }}
        </div>
    @endif

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside id="sidebar"
               class="fixed md:static inset-y-0 left-0 w-64 bg-green-600 text-white p-4 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50">
            <h2 class="text-2xl font-bold mb-6 flex items-center">
                <i class="fa-solid fa-futbol mr-2"></i> FutsalGo
            </h2>
            <nav class="space-y-2">
                <a href="/member" class="block p-2 hover:bg-green-700 rounded">🏠 Dashboard</a>
                <a href="{{ route('member.booking') }}" class="block p-2 hover:bg-green-700 rounded">📅 Booking Lapangan</a>
                <a href="{{ route('member.calendar') }}" class="block p-2 hover:bg-green-700 rounded">🗓️ Calendar Booking</a>
                <a href="{{ route('member.riwayat') }}" class="block p-2 hover:bg-green-700 rounded">🕒 Riwayat Booking</a>
                <a href="{{ route('member.profile') }}" class="block p-2 hover:bg-green-700 rounded">👤 Profil</a>
                <a href="{{ route('member.about') }}" class="block p-2 hover:bg-green-700 rounded">ℹ️ Tentang Aplikasi</a>
            </nav>
        </aside>

        <!-- Overlay (Mobile) -->
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 md:hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col w-full">

            <!-- Header -->
            <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <!-- Tombol Sidebar Mobile -->
                    <button id="menuBtn" class="md:hidden text-green-600 text-2xl focus:outline-none">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h1 class="text-xl font-bold text-green-600">@yield('title', 'Member')</h1>
                </div>

                <!-- User Menu -->
                @auth
                    <div class="flex items-center space-x-3">
                        <span class="font-medium text-gray-700">👋 {{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm text-white">
                                Logout
                            </button>
                        </form>
                    </div>
                @endauth
            </header>

            <!-- Content -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Script -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
