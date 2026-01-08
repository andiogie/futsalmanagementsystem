<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}
    <title>@yield('title', 'Admin FutsalGo')</title>

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
                <a href="{{ route('admin.index') }}" class="block p-2 hover:bg-green-700 rounded">🏠 Dashboard</a>
                @if(auth()->user()->roles === 'owner')
                    <a href="{{ route('laporan.index') }}" class="block p-2 hover:bg-green-700 rounded">💰 Laporan Keuangan</a>
                    <a href="{{ route('admin.calendar') }}" class="block p-2 hover:bg-green-700 rounded">🗓️ Calendar Booking</a>
                @endif
                @if(auth()->user()->roles === 'admin')
                    <a href="{{ route('members.index') }}" class="block p-2 hover:bg-green-700 rounded">👥 Cek Member</a>
                    <a href="{{ route('bookings.index') }}" class="block p-2 hover:bg-green-700 rounded">📅 Cek Status Booking</a>
                    <a href="{{ route('laporan.index') }}" class="block p-2 hover:bg-green-700 rounded">💰 Laporan Keuangan</a>
                    <a href="{{ route('admin.calendar') }}" class="block p-2 hover:bg-green-700 rounded">🗓️ Calendar Booking</a>
                    <a href="{{ route('lapangan.index') }}" class="block p-2 hover:bg-green-700 rounded">🏟️ Master Lapangan</a>
                    <a href="{{ route('rekening.index') }}" class="block p-2 hover:bg-green-700 rounded">🏦 Master Rekening</a>
                    <a href="{{ route('blacklist.index') }}" class="block p-2 hover:bg-green-700 rounded">🚫 Blacklist</a>
                    <a href="{{ route('diskon.index') }}" class="block p-2 hover:bg-green-700 rounded">🏷️ Diskon</a>
                @endif
                <a href="{{ route('admin.about') }}" class="block p-2 hover:bg-green-700 rounded">ℹ️ Tentang Aplikasi</a>
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
                    <h1 class="text-xl font-bold text-green-600">@yield('title', 'Admin')</h1>
                </div>

                <!-- User Menu -->    
                @auth
                    <div class="flex items-center space-x-4 relative">
                        {{-- Notifikasi Dropdown --}}
                        @php
                            $notifCount = \App\Models\Booking::where('is_notified', false)->count();
                            $latestBookings = \App\Models\Booking::latest()->take(5)->get();
                        @endphp

                        <div class="relative" id="notifWrapper">
                            <button id="notifBtn" class="relative focus:outline-none">
                                <i class="fa-solid fa-bell text-xl text-gray-700"></i>
                                @if($notifCount > 0)
                                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-1.5">
                                        {{ $notifCount }}
                                    </span>
                                @endif
                            </button>

                            <!-- Dropdown -->
                            <div id="notifDropdown"
                                 class="hidden absolute right-0 sm:right-0 sm:w-72 w-screen max-w-xs bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                                <div class="p-3 font-semibold border-b bg-gray-50">Notifikasi Booking</div>
                                <ul class="max-h-64 overflow-y-auto">
                                    @forelse($latestBookings as $b)
                                        <li class="border-b">
                                            <a href="{{ route('bookings.edit', $b->id) }}" class="block p-3 hover:bg-gray-100">
                                                <p class="text-sm font-medium">#{{ $b->invoice_no }}</p>
                                                <p class="text-xs text-gray-600">
                                                    {{ $b->nama }} - {{ $b->tanggal }} {{ $b->jam_mulai }}-{{ $b->jam_selesai }}
                                                </p>
                                            </a>
                                        </li>
                                    @empty
                                        <li class="p-3 text-sm text-gray-500">Tidak ada notifikasi</li>
                                    @endforelse
                                </ul>
                                <div class="p-2 text-center">
                                    <a href="{{ route('bookings.index') }}" class="text-green-600 hover:underline text-sm">
                                        Lihat Semua Booking
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Nama User --}}
                        <span class="font-medium text-gray-700">
                            👋 {{ Auth::user()->name }}
                        </span>

                        {{-- Tombol Logout --}}
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm text-white">
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
    <script>
        // Toggle sidebar (mobile)
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        }

        // Toggle dropdown notif
        document.addEventListener("DOMContentLoaded", function () {
            const notifBtn = document.getElementById("notifBtn");
            const notifDropdown = document.getElementById("notifDropdown");

            if (notifBtn && notifDropdown) {
                notifBtn.addEventListener("click", () => {
                    notifDropdown.classList.toggle("hidden");
                });

                // Klik di luar -> tutup dropdown
                document.addEventListener("click", function (e) {
                    if (!notifBtn.contains(e.target) && !notifDropdown.contains(e.target)) {
                        notifDropdown.classList.add("hidden");
                    }
                });
            }
        });
    </script>
</body>
</html>
