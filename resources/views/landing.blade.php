<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FutsalGo</title>

    <!-- Tailwind (langsung CDN, jadi gak butuh vite) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- AOS CSS (animasi scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="font-sans text-gray-800 scroll-smooth">

    <!-- NAVBAR -->
    <header class="fixed w-full bg-white shadow z-50">
        <nav class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
            <h1 class="text-2xl font-bold text-green-600">FutsalGo</h1>
            <ul class="flex space-x-6 text-gray-700 font-medium">
                <li><a href="#hero" class="hover:text-green-600">Beranda</a></li>
                <li><a href="#why" class="hover:text-green-600">Kenapa</a></li>
                <li><a href="#facilities" class="hover:text-green-600">Fasilitas</a></li>
                <li><a href="#booking" class="hover:text-green-600">Booking</a></li>
                <li><a href="#testimoni" class="hover:text-green-600">Testimoni</a></li>
                <li><a href="#maps" class="hover:text-green-600">Lokasi</a></li>
            </ul>
        </nav>
    </header>

    <!-- HERO -->
    <section id="hero" class="h-screen flex items-center justify-center bg-cover bg-center relative"
        style="background-image: url('https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=1600&q=80');">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative text-center text-white px-6" data-aos="fade-up">
            <h2 class="text-4xl md:text-6xl font-bold mb-4">Selamat Datang di <span class="text-green-400">FutsalGo</span></h2>
            <p class="mb-6 text-lg md:text-xl">Nikmati pengalaman futsal terbaik dengan booking online cepat & mudah.</p>
            <a href="#booking" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-full transition">Booking Sekarang</a>
        </div>
    </section>

    <!-- KENAPA PILIH FUTSALGO -->
    <section id="why" class="py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-12" data-aos="fade-up">Kenapa Harus Main di Sini?</h2>
            <div class="grid gap-8 md:grid-cols-3">
                <div class="p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition" data-aos="fade-right">
                    <div class="w-16 h-16 mx-auto flex items-center justify-center bg-green-100 text-green-600 rounded-full mb-4">
                        <i class="fas fa-calendar-check text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Booking Online</h3>
                    <p class="text-gray-600">Pesan lapangan hanya dengan beberapa klik tanpa ribet.</p>
                </div>
                <div class="p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition" data-aos="fade-up">
                    <div class="w-16 h-16 mx-auto flex items-center justify-center bg-blue-100 text-blue-600 rounded-full mb-4">
                        <i class="fas fa-tags text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Harga Terjangkau</h3>
                    <p class="text-gray-600">Main futsal dengan harga terbaik dan promo menarik.</p>
                </div>
                <div class="p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition" data-aos="fade-left">
                    <div class="w-16 h-16 mx-auto flex items-center justify-center bg-red-100 text-red-600 rounded-full mb-4">
                        <i class="fas fa-map-marker-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Lokasi Strategis</h3>
                    <p class="text-gray-600">Mudah diakses dari berbagai arah, cocok untuk semua tim.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FASILITAS -->
    <section id="facilities" class="py-20">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-12" data-aos="fade-up">Fasilitas Kami</h2>
            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
                <div class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden" data-aos="zoom-in">
                    <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?auto=format&fit=crop&w=800&q=80" alt="Toilet" class="w-full h-40 object-cover">
                    <h4 class="py-3 font-semibold">Toilet Bersih</h4>
                </div>
                <div class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden" data-aos="zoom-in">
                    <img src="https://images.unsplash.com/photo-1572939654823-eacb65f6f6e1?auto=format&fit=crop&w=800&q=80" alt="Mushola" class="w-full h-40 object-cover">
                    <h4 class="py-3 font-semibold">Mushola</h4>
                </div>
                <div class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden" data-aos="zoom-in">
                    <img src="https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=800&q=80" alt="Kantin" class="w-full h-40 object-cover">
                    <h4 class="py-3 font-semibold">Kantin</h4>
                </div>
                <div class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden" data-aos="zoom-in">
                    <img src="https://images.unsplash.com/photo-1525610553991-2bede1a236e2?auto=format&fit=crop&w=800&q=80" alt="Parkir" class="w-full h-40 object-cover">
                    <h4 class="py-3 font-semibold">Parkiran Luas</h4>
                </div>
                <div class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden" data-aos="zoom-in">
                    <img src="https://images.unsplash.com/photo-1508609349937-5ec4ae374ebf?auto=format&fit=crop&w=800&q=80" alt="Tribun" class="w-full h-40 object-cover">
                    <h4 class="py-3 font-semibold">Tribun Penonton</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- BOOKING -->
    <section id="booking" class="py-20 bg-green-600 text-white text-center">
        <h2 class="text-3xl font-bold mb-4" data-aos="fade-up">Booking Lapangan</h2>
        <p class="mb-6" data-aos="fade-up">Klik tombol di bawah untuk melakukan pemesanan secara online.</p>
        <a href="#" class="bg-white text-green-600 font-semibold px-6 py-3 rounded-full shadow hover:bg-gray-200 transition" data-aos="zoom-in">Mulai Booking</a>
    </section>

    <!-- TESTIMONI -->
    <section id="testimoni" class="py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-12" data-aos="fade-up">Apa Kata Mereka?</h2>
            <div class="grid gap-8 md:grid-cols-3">
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition" data-aos="fade-right">
                    <p class="italic">"Lapangan nyaman, booking gampang, recommended banget!"</p>
                    <h5 class="mt-4 font-semibold">- Andi</h5>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition" data-aos="fade-up">
                    <p class="italic">"Fasilitas lengkap, tim saya jadi betah main di sini."</p>
                    <h5 class="mt-4 font-semibold">- Rudi</h5>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition" data-aos="fade-left">
                    <p class="italic">"Harganya bersahabat, kualitas oke, lokasi gampang dicari."</p>
                    <h5 class="mt-4 font-semibold">- Budi</h5>
                </div>
            </div>
        </div>
    </section>

    <!-- MAPS -->
    <section id="maps" class="py-20">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-6" data-aos="fade-up">Lokasi Kami</h2>
            <div class="rounded-xl overflow-hidden shadow-lg" data-aos="zoom-in">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.111181647063!2d110.36364931529942!3d-7.838272779262376!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a57bfa0d4bcb9%3A0x6d90c5d0a2a3a6db!2sGOR%20Futsal!5e0!3m2!1sid!2sid!4v1694158990000!5m2!1sid!2sid" 
                    width="100%" 
                    height="400" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-400 text-center py-6">
        <p>&copy; 2025 FutsalGo. Semua Hak Dilindungi.</p>
        <p class="text-sm">Alamat: Jl. Raya Futsal No. 10, Jakarta | Telp: 0812-3456-7890</p>
    </footer>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 1000, once: true });
    </script>
</body>
</html>
