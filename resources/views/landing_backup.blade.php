<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FutsalGo - Booking Lapangan Futsal Online</title>
    
    <!-- TailwindCSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- AOS Animation Library -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
        
        .hero-pattern {
            background-image: 
                radial-gradient(circle at 25px 25px, rgba(255,255,255,.1) 2px, transparent 0),
                radial-gradient(circle at 75px 75px, rgba(255,255,255,.1) 2px, transparent 0);
            background-size: 100px 100px;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .pulse-ring {
            animation: pulse-ring 1.5s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }
        
        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }
            100% {
                transform: scale(2.4);
                opacity: 0;
            }
        }
        
        .member-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        
        .member-menu.open {
            transform: translateX(0);
        }
        
        .hamburger span {
            display: block;
            width: 25px;
            height: 3px;
            background: white;
            margin: 5px 0;
            transition: 0.3s;
        }
        
        .hamburger.active span:nth-child(1) {
            transform: rotate(-45deg) translate(-5px, 6px);
        }
        
        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }
        
        .hamburger.active span:nth-child(3) {
            transform: rotate(45deg) translate(-5px, -6px);
        }
        
        .feature-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            transition: all 0.4s ease;
        }
        
        .feature-card:hover {
            background: linear-gradient(145deg, #f0fdf4 0%, #dcfce7 100%);
        }
    </style>
</head>
<body class="overflow-x-hidden">
    
    <!-- Header with Hamburger Menu -->
    <header class="fixed w-full top-0 z-50 gradient-bg shadow-lg">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <i class="fa-solid fa-futbol text-white text-2xl floating"></i>
                    <div class="absolute inset-0 rounded-full pulse-ring bg-white opacity-20"></div>
                </div>
                <h1 class="text-2xl font-bold text-white">FutsalGo</h1>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-8">
                <a href="#home" class="text-white hover:text-green-200 transition duration-300 font-medium">Beranda</a>
                <a href="#fitur" class="text-white hover:text-green-200 transition duration-300 font-medium">Fitur</a>
                <a href="#keunggulan" class="text-white hover:text-green-200 transition duration-300 font-medium">Keunggulan</a>
                <a href="#kontak" class="text-white hover:text-green-200 transition duration-300 font-medium">Kontak</a>
            </nav>
            
            <div class="hidden md:block">
                <a href="#kontak" class="bg-white text-green-600 px-6 py-2 rounded-full font-semibold hover:bg-green-50 transition duration-300 shadow-lg">
                    Demo Gratis
                </a>
            </div>
            
            <!-- Hamburger Menu Button -->
            <button class="md:hidden hamburger focus:outline-none" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
        
        <!-- Mobile Menu -->
        <div class="member-menu fixed inset-0 bg-green-600 z-40 md:hidden" id="memberMenu">
            <div class="flex flex-col items-center justify-center h-full space-y-8">
                <a href="#home" class="text-white text-2xl font-semibold hover:text-green-200 transition duration-300 member-link">Beranda</a>
                <a href="#fitur" class="text-white text-2xl font-semibold hover:text-green-200 transition duration-300 member-link">Fitur</a>
                <a href="#keunggulan" class="text-white text-2xl font-semibold hover:text-green-200 transition duration-300 member-link">Keunggulan</a>
                <a href="#kontak" class="text-white text-2xl font-semibold hover:text-green-200 transition duration-300 member-link">Kontak</a>
                <a href="#kontak" class="bg-white text-green-600 px-8 py-3 rounded-full font-semibold hover:bg-green-50 transition duration-300 shadow-lg">
                    Demo Gratis
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="min-h-screen gradient-bg hero-pattern flex items-center pt-20">
        <div class="container mx-auto px-4">
            <div class="text-center text-white" data-aos="fade-up">
                <div class="mb-8">
                    <span class="inline-block bg-white bg-opacity-20 text-black px-6 py-2 rounded-full text-sm font-semibold mb-6 glass-effect">
                        🚀 Platform Booking Terdepan
                    </span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                    Booking Lapangan<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-300">Futsal</span> 
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-purple-300">Mudah</span>
                </h1>
                
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto opacity-90 leading-relaxed">
                    Revolusi cara booking lapangan futsal dengan teknologi modern. 
                    Tidak perlu datang langsung atau telepon!
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                    <a href="#kontak" class="bg-white text-green-600 px-8 py-4 rounded-full font-bold text-lg hover:bg-green-50 transition duration-300 shadow-2xl hover:scale-105 transform">
                        <i class="fas fa-rocket mr-2"></i>
                        Mulai Sekarang
                    </a>
                    
                    <a href="#fitur" class="glass-effect text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:bg-opacity-30 transition duration-300 border border-white border-opacity-30">
                        <i class="fas fa-play mr-2"></i>
                        Lihat Demo
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto text-center">
                    <div class="glass-effect p-6 rounded-2xl" data-aos="fade-up" data-aos-delay="100">
                        <div class="text-3xl font-bold mb-2">24/7</div>
                        <div class="opacity-80">Booking Kapan Saja</div>
                    </div>
                    <div class="glass-effect p-6 rounded-2xl" data-aos="fade-up" data-aos-delay="200">
                        <div class="text-3xl font-bold mb-2">Real-time</div>
                        <div class="opacity-80">Update Ketersediaan</div>
                    </div>
                    <div class="glass-effect p-6 rounded-2xl" data-aos="fade-up" data-aos-delay="300">
                        <div class="text-3xl font-bold mb-2">100%</div>
                        <div class="opacity-80">Sistem Otomatis</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-block bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    Fitur Unggulan
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                    Mengapa Memilih <span class="text-green-600">FutsalGo?</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Platform terlengkap untuk mengelola booking lapangan futsal dengan teknologi terdepan
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card p-8 rounded-2xl shadow-lg hover-lift" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-member-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Booking Online</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Pemesanan langsung via website responsif, tanpa perlu download aplikasi tambahan. Akses dari mana saja!
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card p-8 rounded-2xl shadow-lg hover-lift" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-clock text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Real-time Slot</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Lihat ketersediaan lapangan secara real-time dan konfirmasi booking langsung dalam hitungan detik.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card p-8 rounded-2xl shadow-lg hover-lift" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-credit-card text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Pembayaran Mudah</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Dukung berbagai metode pembayaran: Transfer bank, e-wallet, QRIS, dan kartu kredit.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card p-8 rounded-2xl shadow-lg hover-lift" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Laporan Analytics</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Dashboard lengkap dengan laporan pemasukan, statistik booking, dan analisis performa bisnis.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card p-8 rounded-2xl shadow-lg hover-lift" data-aos="fade-up" data-aos-delay="500">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-400 to-pink-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Member Management</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Kelola data member, sistem poin loyalitas, dan program membership dengan mudah.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card p-8 rounded-2xl shadow-lg hover-lift" data-aos="fade-up" data-aos-delay="600">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-bell text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Smart Notification</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Notifikasi otomatis via WhatsApp, Email, dan SMS untuk konfirmasi booking dan reminder.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Advantages Section -->
    <section id="keunggulan" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right">
                    <span class="inline-block bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-semibold mb-6">
                        Keunggulan Sistem
                    </span>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-8">
                        Solusi Terlengkap untuk <span class="text-green-600">Bisnis Futsal</span>
                    </h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg mb-2">Interface User-Friendly</h3>
                                <p class="text-gray-600">Desain modern dan intuitif yang mudah digunakan oleh semua kalangan</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg mb-2">Sistem Keamanan Tinggi</h3>
                                <p class="text-gray-600">Enkripsi data dan sistem backup otomatis untuk keamanan maksimal</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg mb-2">Support 24/7</h3>
                                <p class="text-gray-600">Tim teknis siap membantu Anda kapan saja dengan respon cepat</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="relative" data-aos="fade-left">
                    <div class="relative z-10 bg-white rounded-3xl shadow-2xl p-8">
                        <div class="text-center">
                            <i class="fas fa-trophy text-6xl text-yellow-500 mb-6"></i>
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">Tingkatkan Omset Hingga</h3>
                            <div class="text-5xl font-bold text-green-600 mb-4">300%</div>
                            <p class="text-gray-600">Dengan sistem booking otomatis dan manajemen yang efisien</p>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-blue-500 rounded-3xl transform rotate-6 opacity-20"></div>
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-400 to-pink-500 rounded-3xl transform -rotate-6 opacity-20"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="kontak" class="py-20 gradient-bg text-white">
        <div class="container mx-auto px-4 text-center">
            <div data-aos="fade-up">
                <span class="inline-block bg-white bg-opacity-20 text-white px-4 py-2 rounded-full text-sm font-semibold mb-6 glass-effect">
                    Hubungi Kami
                </span>
                <h2 class="text-4xl md:text-5xl font-bold mb-8">
                    Siap Memulai <span class="text-yellow-300">Revolusi</span> Booking?
                </h2>
                <p class="text-xl mb-12 max-w-2xl mx-auto opacity-90">
                    Dapatkan demo gratis dan konsultasi lengkap untuk mengoptimalkan bisnis futsal Anda
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto mb-12">
                    <a href="https://wa.me/6281234567890" target="_blank" 
                       class="glass-effect p-6 rounded-2xl hover:bg-white hover:bg-opacity-30 transition duration-300 group">
                        <i class="fab fa-whatsapp text-4xl mb-4 group-hover:scale-110 transition duration-300"></i>
                        <h3 class="font-bold text-lg mb-2">WhatsApp</h3>
                        <p class="opacity-80">Chat langsung dengan tim kami</p>
                    </a>
                    
                    <a href="mailto:info@futsalgo.com" 
                       class="glass-effect p-6 rounded-2xl hover:bg-white hover:bg-opacity-30 transition duration-300 group">
                        <i class="fas fa-envelope text-4xl mb-4 group-hover:scale-110 transition duration-300"></i>
                        <h3 class="font-bold text-lg mb-2">Email</h3>
                        <p class="opacity-80">Kirim pertanyaan detail</p>
                    </a>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="https://wa.me/6281234567890" target="_blank"
                       class="bg-white text-green-600 px-8 py-4 rounded-full font-bold text-lg hover:bg-green-50 transition duration-300 shadow-2xl hover:scale-105 transform">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Demo Gratis Sekarang
                    </a>
                    
                    <a href="mailto:info@futsalgo.com"
                       class="glass-effect text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:bg-opacity-30 transition duration-300 border border-white border-opacity-30">
                        <i class="fas fa-calendar mr-2"></i>
                        Jadwalkan Konsultasi
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <i class="fa-solid fa-futbol text-green-500 text-2xl"></i>
                        <h3 class="text-2xl font-bold">FutsalGo</h3>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-md">
                        Platform booking lapangan futsal terdepan yang membantu bisnis Anda berkembang dengan teknologi modern.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition duration-300">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition duration-300">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-bold text-lg mb-4">Fitur</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-green-500 transition duration-300">Booking Online</a></li>
                        <li><a href="#" class="hover:text-green-500 transition duration-300">Pembayaran</a></li>
                        <li><a href="#" class="hover:text-green-500 transition duration-300">Laporan</a></li>
                        <li><a href="#" class="hover:text-green-500 transition duration-300">Notifikasi</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold text-lg mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>
                            <i class="fas fa-phone mr-2"></i>
                            +62 812-3456-7890
                        </li>
                        <li>
                            <i class="fas fa-envelope mr-2"></i>
                            info@futsalgo.com
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Jakarta, Indonesia
                        </li>
                    </ul>
                </div>
            </div>
            
            <hr class="border-gray-800 my-8">
            
            <div class="text-center text-gray-400">
                <p>&copy; 2025 FutsalGo. All rights reserved. Made with ❤️ in Indonesia</p>
            </div>
        </div>
    </footer>

    <!-- AOS Animation Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true
        });

        // Hamburger Menu Toggle
        const hamburger = document.getElementById('hamburger');
        const memberMenu = document.getElementById('memberMenu');
        
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            memberMenu.classList.toggle('open');
            document.body.classList.toggle('overflow-hidden');
        });

        // Close member menu when clicking on a link
        const memberLinks = document.querySelectorAll('.member-link');
        memberLinks.forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                memberMenu.classList.remove('open');
                document.body.classList.remove('overflow-hidden');
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Header background on scroll
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.classList.add('bg-opacity-95');
                header.classList.add('backdrop-blur-sm');
            } else {
                header.classList.remove('bg-opacity-95');
                header.classList.remove('backdrop-blur-sm');
            }
        });

        // Add some interactive animations
        const cards = document.querySelectorAll('.feature-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                const icon = card.querySelector('i');
                icon.style.transform = 'rotate(5deg) scale(1.1)';
            });
            
            card.addEventListener('mouseleave', () => {
                const icon = card.querySelector('i');
                icon.style.transform = 'rotate(0deg) scale(1)';
            });
        });

        // Parallax effect for hero section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const hero = document.querySelector('#home');
            if (hero) {
                hero.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });
    </script>
</body>
</html>