<!DOCTYPE html>
<html lang="id">
    {{-- ini adalah script yang agar sidebar berjalan di https --}}
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FutsalGo')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>[x-cloak]{ display:none !important }</style>
</head>
<body class="min-h-screen flex flex-col bg-gray-100">

    <!-- Header -->
    <header class="bg-green-600 text-white py-4 shadow-md">
        <div class="container mx-auto text-center text-xl font-bold">
            ⚽ FutsalGo
        </div>
    </header>

    <!-- Content -->
    <main class="flex-1 flex items-center justify-center">
        @yield('content')
    </main>

    <!-- Footer (opsional) -->
    <footer class="bg-gray-200 text-center text-sm py-3">
        &copy; {{ date('Y') }} FutsalGo. All rights reserved.
    </footer>
</body>
</html>