{{-- Fitur yang belom bener: 
1. fix fitur review buat User
2. invoice jadinya mau gimana (done)
3. order sparepart di admin belom dibenerin
4. ui/ux masih ngeblip2 (putih putih gittuuu) 


kalau mau jalanin web ini jangan lupa vite nya brow--}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User | @yield('title', 'Beranda')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Glassmorphism Effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #dc2626, #b91c1c);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #b91c1c, #991b1b);
        }
        
        /* Navbar Animation */
        #navbar {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Hover Effects */
        .nav-link {
            position: relative;
            overflow: hidden;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #dc2626, #ef4444);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::before {
            width: 100%;
        }
        
        /* Gradient Button */
        .gradient-btn {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%);
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
            transition: all 0.3s ease;
        }
        
        .gradient-btn:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 50%, #7f1d1d 100%);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
            transform: translateY(-2px);
        }
        
        /* Logo Animation */
        .logo-icon {
            transition: transform 0.3s ease;
        }
        
        .logo-container:hover .logo-icon {
            transform: rotate(15deg) scale(1.1);
        }
        
        /* Floating Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        
        /* Mobile Menu Animation */
        .mobile-menu {
            max-height: 0;
            opacity: 0;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .mobile-menu.active {
            max-height: 300px;
            opacity: 1;
        }
        
        /* Footer Gradient */
        .footer-gradient {
            background: linear-gradient(135deg, #1f2937 0%, #111827 50%, #0f172a 100%);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-gray-100 text-gray-800">

{{-- Navbar Enhanced --}}
<nav id="navbar" class="glass-effect shadow-xl fixed top-0 w-full z-50">
    <div class="container mx-auto flex items-center justify-between py-4 px-6">
        {{-- Logo & Brand Enhanced --}}
        <div class="flex items-center gap-4 logo-container">
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-red-500 to-red-700 rounded-xl blur opacity-75"></div>
                <div class="relative bg-gradient-to-br from-red-600 to-red-800 p-3 rounded-xl logo-icon">
                    <i class="fas fa-wrench text-white text-lg"></i>
                </div>
            </div>
            <div>
                <span class="text-2xl font-extrabold text-gray-900">
                    Harum<span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-red-800">Motor</span>
                </span>
                <div class="text-xs text-gray-500 tracking-widest font-medium flex items-center gap-1">
                    <div class="w-1 h-1 bg-red-500 rounded-full float-animation"></div>
                    CAR WORKSHOP
                </div>
            </div>
        </div>
        
        {{-- Menu Enhanced --}}
        <ul class="hidden lg:flex items-center gap-8 font-medium text-sm">
            <li>
                <a href="{{ route('user.home') }}" 
                   class="nav-link {{ request()->routeIs('user.home') ? 'text-red-600 font-semibold' : 'text-gray-700 hover:text-red-600' }} pb-1 transition-all duration-300">
                    <i class="fas fa-home mr-2 text-xs"></i>HOME
                </a>
            </li>
            <li>
                <a href="{{ route('user.home') }}#about" class="nav-link text-gray-700 hover:text-red-600 pb-1 transition-all duration-300">
                    <i class="fas fa-info-circle mr-2 text-xs"></i>ABOUT US
                </a>
            </li>
            <li>
                <a href="{{ route('user.home') }}#services" class="nav-link text-gray-700 hover:text-red-600 pb-1 transition-all duration-300">
                    <i class="fas fa-tools mr-2 text-xs"></i>SERVICES
                </a>
            </li>
            <li>
                <a href="{{ route('user.spareparts.index') }}" 
                   class="nav-link {{ request()->routeIs('user.spareparts*') ? 'text-red-600 font-semibold' : 'text-gray-700 hover:text-red-600' }} pb-1 transition-all duration-300">
                    <i class="fas fa-cog mr-2 text-xs"></i>SPAREPART
                </a>
            </li>
        </ul>
        
        {{-- User Menu Enhanced --}}
        <div class="hidden lg:flex items-center gap-4">
            @auth
                {{-- User Profile Dropdown --}}
                <div class="relative group">
                    <button class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all duration-300">
                        <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-red-700 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-xs"></i>
                        </div>
                        <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>
                        <i class="fas fa-chevron-down text-gray-500 text-xs group-hover:rotate-180 transition-transform duration-300"></i>
                    </button>
                    
                    {{-- Dropdown Menu --}}
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 border border-gray-100">
                        <div class="p-2">
                            <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition-all duration-200">
                                <i class="fas fa-user-circle"></i>Profile
                            </a>
                            <a href="{{ route('user.mybookings') }}" class="flex items-center gap-3 px-3 py-2 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition-all duration-200">
                                <i class="fas fa-calendar-check"></i>My Bookings
                            </a>
                            <hr class="my-2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200">
                                    <i class="fas fa-sign-out-alt"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                {{-- Book Schedule Button --}}
                <a href="{{ route('user.booking') }}" 
                   class="gradient-btn px-6 py-3 text-white font-bold rounded-xl transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-calendar-plus"></i>
                    BOOK A SCHEDULE
                </a>
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-red-600 font-medium transition-all duration-300">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </a>
                <a href="{{ route('login') }}" 
                   class="gradient-btn px-6 py-3 text-white font-bold rounded-xl transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-user-plus"></i>
                    
                </a>
            @endauth
        </div>
        
        {{-- Mobile Menu Button --}}
        <button id="mobile-menu-btn" class="lg:hidden p-2 text-gray-700 hover:text-red-600 transition-colors">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
    
    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="mobile-menu lg:hidden bg-white border-t border-gray-200">
        <div class="container mx-auto px-6 py-4 space-y-3">
            <a href="{{ route('user.home') }}" class="block px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition-all">
                <i class="fas fa-home mr-3"></i>HOME
            </a>
            <a href="{{ route('user.home') }}#about" class="block px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition-all">
                <i class="fas fa-info-circle mr-3"></i>ABOUT US
            </a>
            <a href="{{ route('user.home') }}#services" class="block px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition-all">
                <i class="fas fa-tools mr-3"></i>SERVICES
            </a>
            <a href="{{ route('user.spareparts.index') }}" class="block px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition-all">
                <i class="fas fa-cog mr-3"></i>SPAREPART
            </a>
            @auth
                <a href="{{ route('user.mybookings') }}" class="block px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition-all">
                    <i class="fas fa-calendar-check mr-3"></i>My Bookings
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-all">
                        <i class="fas fa-sign-out-alt mr-3"></i>Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-lg transition-all">
                    <i class="fas fa-sign-in-alt mr-3"></i>Login
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- Main Content Enhanced --}}
<main class="container mx-auto py-8 px-4 mt-28 min-h-screen">
    <div class="animate-fade-in">
        @yield('content')
    </div>
</main>

{{-- Footer Enhanced --}}
<footer class="footer-gradient text-white relative overflow-hidden mt-20">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(255,255,255,.1) 20px, rgba(255,255,255,.1) 40px);"></div>
    </div>
    
    <div class="relative container mx-auto px-6 py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            {{-- Company Info --}}
            <div class="md:col-span-2">
                <div class="flex items-center gap-4 mb-6">
                    <div class="bg-gradient-to-br from-red-600 to-red-800 p-3 rounded-xl float-animation">
                        <i class="fas fa-wrench text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold">Harum Motor</h3>
                        <p class="text-gray-300 text-sm">Bengkel Terpercaya</p>
                    </div>
                </div>
                <p class="text-gray-300 leading-relaxed mb-6">
                    Harum Motor adalah bengkel terpercaya yang telah melayani ribuan pelanggan dengan layanan servis profesional dan sparepart berkualitas.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 bg-white bg-opacity-10 rounded-full flex items-center justify-center hover:bg-red-600 transition-all duration-300">
                        <i class="fab fa-facebook text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white bg-opacity-10 rounded-full flex items-center justify-center hover:bg-red-600 transition-all duration-300">
                        <i class="fab fa-instagram text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white bg-opacity-10 rounded-full flex items-center justify-center hover:bg-red-600 transition-all duration-300">
                        <i class="fab fa-whatsapp text-white"></i>
                    </a>
                </div>
            </div>
            
            {{-- Quick Links --}}
            <div>
                <h4 class="text-lg font-semibold mb-6 text-red-400">Menu Cepat</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('user.home') }}" class="text-gray-300 hover:text-white transition-colors flex items-center gap-2">
                        <i class="fas fa-chevron-right text-red-500 text-xs"></i>Beranda
                    </a></li>
                    <li><a href="{{ route('user.spareparts.index') }}" class="text-gray-300 hover:text-white transition-colors flex items-center gap-2">
                        <i class="fas fa-chevron-right text-red-500 text-xs"></i>Sparepart
                    </a></li>
                    <li><a href="{{ route('user.home') }}#services" class="text-gray-300 hover:text-white transition-colors flex items-center gap-2">
                        <i class="fas fa-chevron-right text-red-500 text-xs"></i>Services
                    </a></li>
                </ul>
            </div>
            
            {{-- Contact Info --}}
            <div>
                <h4 class="text-lg font-semibold mb-6 text-red-400">Kontak Kami</h4>
                <div class="space-y-3 text-gray-300">
                    <p class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt text-red-400 mt-1"></i>
                        <span>Jl. Suryakencana km.2, desa Pamuruyan no. 244</span>
                    </p>
                    <p class="flex items-center gap-3">
                        <i class="fas fa-phone text-red-400"></i>
                        <span>+62 123 456 789</span>
                    </p>
                    <p class="flex items-center gap-3">
                        <i class="fas fa-envelope text-red-400"></i>
                        <a href="mailto:info@harummotor.com" class="hover:text-white transition-colors">info@harummotor.com</a>
                    </p>
                </div>
            </div>
        </div>
        
        {{-- Copyright --}}
        <div class="border-t border-gray-700 mt-12 pt-8 text-center">
            <p class="text-gray-400">
                &copy; {{ date('Y') }} Harum Motor. All rights reserved. Made with 
                <i class="fas fa-heart text-red-500"></i> for your car
            </p>
        </div>
    </div>
</footer>

{{-- Scripts Enhanced --}}
<script>
    // Navbar scroll effect
    let lastScrollY = window.scrollY;
    const navbar = document.getElementById('navbar');

    window.addEventListener('scroll', () => {
        const currentScrollY = window.scrollY;

        if (currentScrollY > lastScrollY && currentScrollY > 100) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }

        lastScrollY = currentScrollY;
    });

    // Mobile menu toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('active');
        const icon = mobileMenuBtn.querySelector('i');
        if (mobileMenu.classList.contains('active')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });

    // Smooth scrolling for anchor links (supports links with path + hash and smooth-scroll after navigation)
    function smoothScrollToHash(hash) {
        try {
            const target = document.querySelector(hash);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                return true;
            }
        } catch (e) { /* invalid selector */ }
        return false;
    }

    document.querySelectorAll('a[href*="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (!href) return;

            // Create full URL to parse path and hash reliably
            const linkUrl = new URL(href, window.location.origin);
            const samePath = linkUrl.pathname === window.location.pathname;

            if (linkUrl.hash) {
                if (samePath) {
                    // same page + hash -> smooth scroll without navigation
                    e.preventDefault();
                    smoothScrollToHash(linkUrl.hash);
                } else {
                    // different page with hash -> allow navigation; smooth scroll will run on load below
                    // no preventDefault so browser navigates to target page with hash
                }
            }
        });
    });

    // On load, if there's a hash in the URL, try to smooth-scroll to it (use timeout to allow content render)
    window.addEventListener('load', () => {
        if (window.location.hash) {
            setTimeout(() => {
                smoothScrollToHash(window.location.hash);
            }, 120);
        }
    });
</script>

</body>
</html>
