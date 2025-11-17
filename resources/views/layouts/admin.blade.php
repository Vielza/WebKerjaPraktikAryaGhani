<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Harum Motor</title>
    
    {{-- CSS Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    {{-- Tailwind CDN sebagai backup --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Font Family */
        body {
            font-family: 'Inter', 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Theme Variables */
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #e2e8f0;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --text-tertiary: #9ca3af;
            --border-color: rgba(0, 0, 0, 0.1);
            --glass-bg: rgba(255, 255, 255, 0.95);
            --sidebar-bg: linear-gradient(180deg, #1f2937 0%, #111827 100%);
            --sidebar-text: #d1d5db;
            --header-bg: rgba(255, 255, 255, 0.95);
            --dropdown-bg: #ffffff;
            --modal-bg: #ffffff;
        }

        [data-theme="dark"] {
            --bg-primary: #111827;
            --bg-secondary: #1f2937;
            --bg-tertiary: #374151;
            --text-primary: #f9fafb;
            --text-secondary: #d1d5db;
            --text-tertiary: #9ca3af;
            --border-color: rgba(255, 255, 255, 0.1);
            --glass-bg: rgba(31, 41, 55, 0.95);
            --sidebar-bg: linear-gradient(180deg, #0f172a 0%, #020617 100%);
            --sidebar-text: #e2e8f0;
            --header-bg: rgba(31, 41, 55, 0.95);
            --dropdown-bg: #1f2937;
            --modal-bg: #1f2937;
        }

        /* Custom Design */
        .glass-effect {
            background: var(--header-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
        }

        .sidebar-gradient {
            background: var(--sidebar-bg);
        }

        .menu-active {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
            transform: translateX(8px);
        }

        .menu-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: var(--sidebar-text);
        }

        .menu-item:hover {
            transform: translateX(4px);
            background: rgba(239, 68, 68, 0.1);
        }

        .content-area {
            min-height: 100vh;
            background: var(--bg-secondary);
            color: var(--text-primary);
        }

        .floating-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .notification-dot {
            animation: pulse 2s infinite;
        }

        /* DROPDOWN STYLES */
        .dropdown-menu {
            background: var(--dropdown-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            z-index: 9999 !important;
            position: absolute !important;
            color: var(--text-primary);
        }

        .dropdown-show {
            opacity: 1;
            transform: translateY(0px) scale(1);
            visibility: visible;
        }

        .dropdown-hide {
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
            visibility: hidden;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        header {
            z-index: 100 !important;
            position: relative;
        }

        /* Modal Styles */
        .modal-content {
            background: var(--modal-bg);
            color: var(--text-primary);
        }

        /* Input Styles */
        .form-input {
            background: var(--bg-primary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        .form-input:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        /* Button Styles */
        .btn-secondary {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        /* Theme Toggle Animation */
        .theme-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Text Color Classes */
        .text-theme-primary { color: var(--text-primary) !important; }
        .text-theme-secondary { color: var(--text-secondary) !important; }
        .text-theme-tertiary { color: var(--text-tertiary) !important; }
        .bg-theme-primary { background-color: var(--bg-primary) !important; }
        .bg-theme-secondary { background-color: var(--bg-secondary) !important; }
        .border-theme { border-color: var(--border-color) !important; }

        /* Override specific classes for theme */
        [data-theme="dark"] .text-gray-900 { color: var(--text-primary) !important; }
        [data-theme="dark"] .text-gray-700 { color: var(--text-secondary) !important; }
        [data-theme="dark"] .text-gray-600 { color: var(--text-secondary) !important; }
        [data-theme="dark"] .text-gray-500 { color: var(--text-tertiary) !important; }
        [data-theme="dark"] .bg-white { background-color: var(--bg-primary) !important; }
        [data-theme="dark"] .bg-gray-50 { background-color: var(--bg-secondary) !important; }
        [data-theme="dark"] .bg-gray-100 { background-color: var(--bg-tertiary) !important; }
        [data-theme="dark"] .border-gray-200 { border-color: var(--border-color) !important; }
        [data-theme="dark"] .border-gray-300 { border-color: var(--border-color) !important; }

        /* Font Icons Fallback */
        .fas, .far, .fab, .fal, .fad, .fa {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 6 Brands", sans-serif;
            font-weight: 900;
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            text-rendering: auto;
            line-height: 1;
        }

        /* Backup icons dengan Unicode */
        .fa-chart-pie::before { content: '\f200'; }
        .fa-calendar-check::before { content: '\f274'; }
        .fa-cogs::before { content: '\f085'; }
        .fa-star::before { content: '\f005'; }
        .fa-file-invoice::before { content: '\f570'; }
        .fa-shopping-bag::before { content: '\f290'; }
        .fa-bell::before { content: '\f0f3'; }
        .fa-cog::before { content: '\f013'; }
        .fa-user-cog::before { content: '\f4fe'; }
        .fa-palette::before { content: '\f53f'; }
        .fa-shield-alt::before { content: '\f3ed'; }
        .fa-question-circle::before { content: '\f059'; }
        .fa-sign-out-alt::before { content: '\f2f5'; }
        .fa-times::before { content: '\f00d'; }
        .fa-bars::before { content: '\f0c9'; }
        .fa-plus::before { content: '\f067'; }
        .fa-edit::before { content: '\f044'; }
        .fa-trash::before { content: '\f2ed'; }
        .fa-eye::before { content: '\f06e'; }
        .fa-save::before { content: '\f0c7'; }
        .fa-tag::before { content: '\f02b'; }
        .fa-align-left::before { content: '\f036'; }
        .fa-money-bill-wave::before { content: '\f53a'; }
        .fa-cubes::before { content: '\f1b3'; }
        .fa-image::before { content: '\f03e'; }
        .fa-boxes::before { content: '\f468'; }
        .fa-tools::before { content: '\f7d9'; }
        .fa-exclamation-triangle::before { content: '\f071'; }
        .fa-rupiah-sign::before { content: '\e23d'; }
        .fa-search-plus::before { content: '\f00e'; }
        .fa-comments::before { content: '\f086'; }
        .fa-wrench::before { content: '\f0ad'; }
        .fa-shopping-cart::before { content: '\f07a'; }
        .fa-info-circle::before { content: '\f05a'; }
        .fa-check::before { content: '\f00c'; }
        .fa-check-circle::before { content: '\f058'; }
        .fa-exclamation-circle::before { content: '\f06a'; }
        .fa-sun::before { content: '\f185'; }
        .fa-moon::before { content: '\f186'; }
        .fa-database::before { content: '\f1c0'; }
        .fa-download::before { content: '\f019'; }
        .fa-upload::before { content: '\f093'; }
        .fa-chevron-right::before { content: '\f054'; }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.3); border-radius: 2px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.5); }

        [data-theme="dark"] ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); }
        [data-theme="dark"] ::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.4); }

        /* Tambahkan class utilities untuk konsistensi */
        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }
        
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        
        .line-clamp-3 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        /* Responsive table adjustments */
        @media (max-width: 1024px) {
            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .table-container table {
                min-width: 800px;
            }
        }

        /* Card hover effects */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Status indicators */
        .status-indicator {
            position: relative;
            display: inline-flex;
            align-items: center;
        }
        
        .status-indicator::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .status-success::before { background-color: #10b981; }
        .status-warning::before { background-color: #f59e0b; }
        .status-danger::before { background-color: #ef4444; }
        .status-info::before { background-color: #3b82f6; }

        /* Loading states */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
        
        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #ef4444;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 overflow-hidden font-sans theme-transition" data-theme="light">
    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-75 z-40 lg:hidden hidden transition-opacity duration-300"></div>
    
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-72 sidebar-gradient shadow-2xl flex flex-col fixed lg:relative h-full z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
            <!-- Sidebar Header -->
            <div class="p-6 border-b border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-br from-red-500 to-red-600 p-3 rounded-xl shadow-lg">
                            <i class="fas fa-tools text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-white">Harum Motor</h1>
                            <p class="text-sm text-red-400 font-medium">Admin Panel</p>
                        </div>
                    </div>
                    <button id="close-sidebar" class="lg:hidden text-gray-400 hover:text-white p-2 rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <!-- Main Menu -->
                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-3">Menu Utama</h3>
                    
                    <a href="{{ route('admin.dashboard') }}" class="menu-item flex items-center px-4 py-3 text-gray-300 rounded-xl hover:text-white {{ request()->routeIs('admin.dashboard') ? 'menu-active text-white' : '' }}">
                        <div class="bg-blue-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-chart-pie text-blue-400"></i>
                        </div>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('admin.bookings') }}" class="menu-item flex items-center px-4 py-3 text-gray-300 rounded-xl hover:text-white relative {{ request()->routeIs('admin.bookings*') ? 'menu-active text-white' : '' }}">
                        <div class="bg-green-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-calendar-check text-green-400"></i>
                        </div>
                        <span class="font-medium">Data Booking</span>
                        @php
                            $pendingCount = \App\Models\ServiceBooking::where('status', 'pending')->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full notification-dot">
                                {{ $pendingCount }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('admin.spareparts.index') }}" class="menu-item flex items-center px-4 py-3 text-gray-300 rounded-xl hover:text-white {{ request()->routeIs('admin.spareparts*') ? 'menu-active text-white' : '' }}">
                        <div class="bg-purple-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-cogs text-purple-400"></i>
                        </div>
                        <span class="font-medium">Data Sparepart</span>
                    </a>

                    <a href="{{ route('admin.reviews.index') }}" class="menu-item flex items-center px-4 py-3 text-gray-300 rounded-xl hover:text-white {{ request()->routeIs('admin.reviews*') ? 'menu-active text-white' : '' }}">
                        <div class="bg-yellow-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>
                        <span class="font-medium">Review Pelanggan</span>
                    </a>
                </div>

                <!-- Transaksi Menu -->
                <div>
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-3">Transaksi</h3>
                    
                    <a href="{{ route('admin.invoices.index') }}" class="menu-item flex items-center px-4 py-3 text-gray-300 rounded-xl hover:text-white {{ request()->routeIs('admin.invoices*') ? 'menu-active text-white' : '' }}">
                        <div class="bg-indigo-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-file-invoice text-indigo-400"></i>
                        </div>
                        <span class="font-medium">Invoice</span>
                    </a>

                    <!-- PERBAIKI LINK ORDER SPAREPART -->
                    <a href="{{ url('/admin/orders') }}" class="menu-item flex items-center px-4 py-3 text-gray-300 rounded-xl hover:text-white relative {{ request()->routeIs('admin/orders*') ? 'menu-active text-white' : '' }}">
                        <div class="bg-teal-500/20 p-2 rounded-lg mr-3">
                            <i class="fas fa-shopping-bag text-teal-400"></i>
                        </div>
                        <span class="font-medium">Order Sparepart</span>
                        @php
                            try {
                                $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count();
                            } catch (\Exception $e) {
                                $pendingOrdersCount = 0;
                            }
                        @endphp
                        @if($pendingOrdersCount > 0)
                            <span class="ml-auto bg-orange-500 text-white text-xs px-2 py-1 rounded-full notification-dot">
                                {{ $pendingOrdersCount }}
                            </span>
                        @endif
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="glass-effect border-b border-white/20 px-6 py-4 shadow-sm relative z-[100]">
                <div class="flex items-center justify-between">
                    <!-- Left Section -->
                    <div class="flex items-center space-x-4">
                        <button id="mobile-menu-btn" class="lg:hidden p-2 text-gray-600 hover:text-gray-900 rounded-lg hover:bg-white/50 transition-colors">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">@yield('title', 'Dashboard')</h1>
                            <p class="text-sm text-gray-600">{{ now()->format('l, d F Y') }}</p>
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="flex items-center space-x-4">
                        <!-- Quick Stats -->
                        <div class="hidden md:flex items-center space-x-4">
                            <div class="floating-card px-4 py-2 rounded-xl">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span class="text-sm font-medium text-gray-700">System Online</span>
                                </div>
                            </div>
                        </div>

                        <!-- Notifications -->
                        <div class="relative">
                            <button id="notification-btn" class="relative p-3 text-gray-600 hover:text-gray-900 hover:bg-white/50 rounded-xl transition-colors">
                                <i class="fas fa-bell text-lg"></i>
                                <span id="notification-badge" class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full notification-dot"></span>
                            </button>
                            
                            <!-- Notification Dropdown -->
                            <div id="notification-dropdown" class="dropdown-menu dropdown-hide absolute right-0 mt-2 w-80 rounded-2xl transform transition-all duration-200 origin-top-right">
                                <div class="p-4 border-b border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-bold text-gray-900">Notifikasi</h3>
                                        <span class="bg-red-100 text-red-600 px-2 py-1 rounded-full text-xs font-medium">3 Baru</span>
                                    </div>
                                </div>
                                
                                <div class="max-h-96 overflow-y-auto">
                                    <div class="p-4 hover:bg-gray-50 border-b border-gray-100 cursor-pointer transition-colors">
                                        <div class="flex items-start space-x-3">
                                            <div class="bg-blue-100 p-2 rounded-full flex-shrink-0">
                                                <i class="fas fa-calendar-check text-blue-600 text-sm"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900">Booking Baru</p>
                                                <p class="text-xs text-gray-500 mt-1">Ada booking servis baru dari pelanggan</p>
                                                <p class="text-xs text-gray-400 mt-1">5 menit yang lalu</p>
                                            </div>
                                            <div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="p-4 hover:bg-gray-50 border-b border-gray-100 cursor-pointer transition-colors">
                                        <div class="flex items-start space-x-3">
                                            <div class="bg-green-100 p-2 rounded-full flex-shrink-0">
                                                <i class="fas fa-shopping-cart text-green-600 text-sm"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900">Order Sparepart</p>
                                                <p class="text-xs text-gray-500 mt-1">Order baru untuk sparepart motor</p>
                                                <p class="text-xs text-gray-400 mt-1">10 menit yang lalu</p>
                                            </div>
                                            <div class="w-2 h-2 bg-green-500 rounded-full flex-shrink-0"></div>
                                        </div>
                                    </div>

                                    <div class="p-4 hover:bg-gray-50 border-b border-gray-100 cursor-pointer transition-colors">
                                        <div class="flex items-start space-x-3">
                                            <div class="bg-yellow-100 p-2 rounded-full flex-shrink-0">
                                                <i class="fas fa-star text-yellow-600 text-sm"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900">Review Baru</p>
                                                <p class="text-xs text-gray-500 mt-1">Pelanggan memberikan review 5 bintang</p>
                                                <p class="text-xs text-gray-400 mt-1">1 jam yang lalu</p>
                                            </div>
                                            <div class="w-2 h-2 bg-yellow-500 rounded-full flex-shrink-0"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-4 border-t border-gray-200">
                                    <button class="w-full text-center text-sm font-medium text-red-600 hover:text-red-700 transition-colors">
                                        Lihat Semua Notifikasi
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Settings -->
                        <div class="relative">
                            <button id="settings-btn" class="p-3 text-gray-600 hover:text-gray-900 hover:bg-white/50 rounded-xl transition-colors">
                                <i class="fas fa-cog text-lg"></i>
                            </button>
                            
                            <!-- Settings Dropdown - DIPERBAIKI -->
                            <div id="settings-dropdown" class="dropdown-menu dropdown-hide absolute right-0 mt-2 w-64 rounded-2xl transform transition-all duration-200 origin-top-right">
                                <div class="p-4 border-b border-gray-200">
                                    <h3 class="font-bold text-gray-900">Pengaturan</h3>
                                </div>
                                
                                <div class="p-2">
                                    <!-- Profile Settings -->
                                    <button onclick="openProfileModal()" class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl transition-colors">
                                        <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                            <i class="fas fa-user-cog text-blue-600 text-sm"></i>
                                        </div>
                                        <div class="text-left">
                                            <div class="text-sm font-medium">Profil Admin</div>
                                            <div class="text-xs text-gray-500">Edit informasi profil</div>
                                        </div>
                                    </button>                                                                    
                                    
                                    <!-- Backup & Restore -->
                                    <button onclick="openBackupModal()" class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl transition-colors">
                                        <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                                            <i class="fas fa-database text-indigo-600 text-sm"></i>
                                        </div>
                                        <div class="text-left">
                                            <div class="text-sm font-medium">Backup Data</div>
                                            <div class="text-xs text-gray-500">Backup & restore database</div>
                                        </div>
                                    </button>
                                    
                                    <!-- System Info -->
                                    <button onclick="openSystemInfoModal()" class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl transition-colors">
                                        <div class="bg-yellow-100 p-2 rounded-lg mr-3">
                                            <i class="fas fa-info-circle text-yellow-600 text-sm"></i>
                                        </div>
                                        <div class="text-left">
                                            <div class="text-sm font-medium">Info Sistem</div>
                                            <div class="text-xs text-gray-500">Informasi versi & status</div>
                                        </div>
                                    </button>
                                    
                                    <!-- Help -->
                                    <button onclick="openHelpModal()" class="w-full flex items-center px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl transition-colors">
                                        <div class="bg-orange-100 p-2 rounded-lg mr-3">
                                            <i class="fas fa-question-circle text-orange-600 text-sm"></i>
                                        </div>
                                        <div class="text-left">
                                            <div class="text-sm font-medium">Bantuan</div>
                                            <div class="text-xs text-gray-500">Panduan & dokumentasi</div>
                                        </div>
                                    </button>
                                    
                                    <!-- Logout -->
                                    <div class="border-t border-gray-200 mt-2 pt-2">
                                        <form action="{{ route('logout') }}" method="POST" class="w-full">
                                            @csrf
                                            <button type="submit" class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                                                <div class="bg-red-100 p-2 rounded-lg mr-3">
                                                    <i class="fas fa-sign-out-alt text-red-600 text-sm"></i>
                                                </div>
                                                <div class="text-left">
                                                    <div class="text-sm font-medium">Logout</div>
                                                    <div class="text-xs text-red-500">Keluar dari sistem</div>
                                                </div>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="flex-1 overflow-auto content-area">
                <div class="p-6">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    {{-- JavaScript dari sebelumnya tetap sama --}}
    <script>
        // Theme Management
        let currentTheme = localStorage.getItem('theme') || 'light';
        
        // Initialize theme on page load
        function initTheme() {
            const body = document.body;
            const themeIndicator = document.getElementById('theme-indicator');
            const themeIcon = document.getElementById('theme-icon');
            
            body.setAttribute('data-theme', currentTheme);
            
            if (currentTheme === 'dark') {
                themeIndicator.textContent = 'Dark';
                themeIndicator.classList.remove('bg-gray-100');
                themeIndicator.classList.add('bg-gray-800', 'text-white');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
                body.classList.remove('bg-gray-900');
                body.classList.add('bg-gray-800');
            } else {
                themeIndicator.textContent = 'Light';
                themeIndicator.classList.remove('bg-gray-800', 'text-white');
                themeIndicator.classList.add('bg-gray-100');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
                body.classList.remove('bg-gray-800');
                body.classList.add('bg-gray-900');
            }
        }

        // Toggle Theme Function
        function toggleTheme() {
            const body = document.body;
            const themeIndicator = document.getElementById('theme-indicator');
            const themeIcon = document.getElementById('theme-icon');
            
            // Switch theme
            currentTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            // Apply theme with animation
            body.style.transition = 'all 0.3s ease';
            body.setAttribute('data-theme', currentTheme);
            
            if (currentTheme === 'dark') {
                // Dark mode
                themeIndicator.textContent = 'Dark';
                themeIndicator.classList.remove('bg-gray-100');
                themeIndicator.classList.add('bg-gray-800', 'text-white');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
                
                showToast('🌙 Dark mode diaktifkan', 'success');
            } else {
                // Light mode
                themeIndicator.textContent = 'Light';
                themeIndicator.classList.remove('bg-gray-800', 'text-white');
                themeIndicator.classList.add('bg-gray-100');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
                
                showToast('☀️ Light mode diaktifkan', 'success');
            }
            
            // Save to localStorage
            localStorage.setItem('theme', currentTheme);
            
            // Hide dropdown
            hideAllDropdowns();
            
            // Remove transition after animation completes
            setTimeout(() => {
                body.style.transition = '';
            }, 300);
        }

        // Apply theme to dynamic content
        function applyThemeToElement(element) {
            const currentTheme = document.body.getAttribute('data-theme');
            
            if (currentTheme === 'dark') {
                element.classList.add('dark-theme');
            } else {
                element.classList.remove('dark-theme');
            }
        }

        // Keep all existing JavaScript functionality
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobile-overlay');
        const closeSidebar = document.getElementById('close-sidebar');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            mobileOverlay.classList.toggle('hidden');
        }

        mobileMenuBtn?.addEventListener('click', toggleSidebar);
        closeSidebar?.addEventListener('click', toggleSidebar);
        mobileOverlay?.addEventListener('click', toggleSidebar);

        // DROPDOWN FUNCTIONALITY
        const notificationBtn = document.getElementById('notification-btn');
        const notificationDropdown = document.getElementById('notification-dropdown');
        const notificationBadge = document.getElementById('notification-badge');
        const settingsBtn = document.getElementById('settings-btn');
        const settingsDropdown = document.getElementById('settings-dropdown');

        function showDropdown(dropdown) {
            if (dropdown) {
                dropdown.classList.remove('dropdown-hide');
                dropdown.classList.add('dropdown-show');
                dropdown.style.zIndex = '9999';
            }
        }

        function hideDropdown(dropdown) {
            if (dropdown) {
                dropdown.classList.remove('dropdown-show');
                dropdown.classList.add('dropdown-hide');
            }
        }

        function hideAllDropdowns() {
            hideDropdown(notificationDropdown);
            hideDropdown(settingsDropdown);
        }

        notificationBtn?.addEventListener('click', function(e) {
            e.stopPropagation();
            hideDropdown(settingsDropdown);
            
            if (notificationDropdown.classList.contains('dropdown-show')) {
                hideDropdown(notificationDropdown);
            } else {
                showDropdown(notificationDropdown);
                if (notificationBadge) {
                    notificationBadge.style.display = 'none';
                }
            }
        });

        settingsBtn?.addEventListener('click', function(e) {
            e.stopPropagation();
            hideDropdown(notificationDropdown);
            
            if (settingsDropdown.classList.contains('dropdown-show')) {
                hideDropdown(settingsDropdown);
            } else {
                showDropdown(settingsDropdown);
            }
        });

        document.addEventListener('click', function(e) {
            if (!notificationBtn?.contains(e.target) && !notificationDropdown?.contains(e.target)) {
                hideDropdown(notificationDropdown);
            }
            
            if (!settingsBtn?.contains(e.target) && !settingsDropdown?.contains(e.target)) {
                hideDropdown(settingsDropdown);
            }
        });

        notificationDropdown?.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        settingsDropdown?.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // Modal Functions
        function openProfileModal() {
            document.getElementById('modal-overlay').classList.remove('hidden');
            document.getElementById('profile-modal').classList.remove('hidden');
            hideAllDropdowns();
            setTimeout(() => {
                document.querySelector('#profile-modal .transform').classList.remove('scale-95');
                document.querySelector('#profile-modal .transform').classList.add('scale-100');
            }, 10);
        }

        function openSecurityModal() {
            document.getElementById('modal-overlay').classList.remove('hidden');
            document.getElementById('security-modal').classList.remove('hidden');
            hideAllDropdowns();
            setTimeout(() => {
                document.querySelector('#security-modal .transform').classList.remove('scale-95');
                document.querySelector('#security-modal .transform').classList.add('scale-100');
            }, 10);
        }

        function openSystemInfoModal() {
            document.getElementById('modal-overlay').classList.remove('hidden');
            document.getElementById('system-info-modal').classList.remove('hidden');
            hideAllDropdowns();
            setTimeout(() => {
                document.querySelector('#system-info-modal .transform').classList.remove('scale-95');
                document.querySelector('#system-info-modal .transform').classList.add('scale-100');
            }, 10);
        }

        function openHelpModal() {
            document.getElementById('modal-overlay').classList.remove('hidden');
            document.getElementById('help-modal').classList.remove('hidden');
            hideAllDropdowns();
            setTimeout(() => {
                document.querySelector('#help-modal .transform').classList.remove('scale-95');
                document.querySelector('#help-modal .transform').classList.add('scale-100');
            }, 10);
        }

        function openBackupModal() {
            document.getElementById('modal-overlay').classList.remove('hidden');
            document.getElementById('backup-modal').classList.remove('hidden');
            hideAllDropdowns();
            setTimeout(() => {
                document.querySelector('#backup-modal .transform').classList.remove('scale-95');
                document.querySelector('#backup-modal .transform').classList.add('scale-100');
            }, 10);
        }

        function closeAllModals() {
            const modals = ['profile-modal', 'security-modal', 'system-info-modal', 'help-modal', 'backup-modal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.querySelector('.transform').classList.add('scale-95');
                    modal.querySelector('.transform').classList.remove('scale-100');
                }
            });
            
            setTimeout(() => {
                document.getElementById('modal-overlay').classList.add('hidden');
                modals.forEach(modalId => {
                    document.getElementById(modalId).classList.add('hidden');
                });
            }, 200);
        }

        function saveProfile() {
            showToast('Profil berhasil disimpan!', 'success');
            closeAllModals();
        }

        function changePassword() {
            const oldPassword = document.getElementById('old-password').value;
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            if (!oldPassword || !newPassword || !confirmPassword) {
                showToast('Semua field harus diisi!', 'error');
                return;
            }

            if (newPassword !== confirmPassword) {
                showToast('Password baru dan konfirmasi tidak sama!', 'error');
                return;
            }

            if (newPassword.length < 8) {
                showToast('Password harus minimal 8 karakter!', 'error');
                return;
            }

            showToast('Password berhasil diubah!', 'success');
            closeAllModals();
        }

        function createBackup() {
            showToast('Backup sedang dibuat...', 'info');
            setTimeout(() => {
                showToast('Backup berhasil dibuat!', 'success');
                closeAllModals();
            }, 3000);
        }

        function restoreBackup() {
            if (confirm('Yakin ingin restore backup? Data saat ini akan diganti.')) {
                showToast('Restore backup dimulai...', 'info');
                setTimeout(() => {
                    showToast('Restore backup berhasil!', 'success');
                    closeAllModals();
                }, 5000);
            }
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            
            toast.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-[9999] transform translate-x-full transition-transform duration-300`;
            toast.innerHTML = `
                <div class="flex items-center space-x-2">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }

        // Close modal when clicking overlay
        document.getElementById('modal-overlay')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeAllModals();
            }
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                mobileOverlay.classList.add('hidden');
            }
            hideAllDropdowns();
        });

        // Initialize theme when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initTheme();
            hideAllDropdowns();
            
            // Add theme transition to all relevant elements
            const elementsToTransition = document.querySelectorAll('.glass-effect, .dropdown-menu, .floating-card, .modal-content');
            elementsToTransition.forEach(element => {
                element.classList.add('theme-transition');
            });
        });

        // Watch for theme changes and update dynamically created elements
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList') {
                    mutation.addedNodes.forEach(function(node) {
                        if (node.nodeType === 1) { // Element node
                            applyThemeToElement(node);
                        }
                    });
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    </script>

    {{-- TAMBAHKAN MODAL OVERLAY DAN MODALS DI BAWAH MAIN CONTENT --}}

    <!-- Modal Overlay -->
    <div id="modal-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-[9998] hidden transition-opacity duration-300"></div>

    <!-- Profile Modal -->
    <div id="profile-modal" class="fixed inset-0 z-[9999] hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Edit Profil Admin</h3>
                        <button onclick="closeAllModals()" class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <form onsubmit="event.preventDefault(); saveProfile();">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" id="admin-name" value="{{ Auth::user()->name ?? 'Admin' }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" id="admin-email" value="{{ Auth::user()->email ?? 'admin@harummotor.com' }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                                <input type="tel" id="admin-phone" value="0812-3456-7890" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>
                        
                        <div class="flex space-x-4 mt-6">
                            <button type="button" onclick="closeAllModals()" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                Batal
                            </button>
                            <button type="submit" class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Modal -->
    <div id="security-modal" class="fixed inset-0 z-[9999] hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Keamanan</h3>
                        <button onclick="closeAllModals()" class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <form onsubmit="event.preventDefault(); changePassword();">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password Lama</label>
                                <input type="password" id="old-password" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                <input type="password" id="new-password" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                <input type="password" id="confirm-password" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>
                        
                        <div class="flex space-x-4 mt-6">
                            <button type="button" onclick="closeAllModals()" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                Batal
                            </button>
                            <button type="submit" class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors">
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- System Info Modal -->
    <div id="system-info-modal" class="fixed inset-0 z-[9999] hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Informasi Sistem</h3>
                        <button onclick="closeAllModals()" class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                            <span class="text-sm font-medium text-gray-700">Versi Sistem</span>
                            <span class="text-sm text-gray-900">v2.1.0</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                            <span class="text-sm font-medium text-gray-700">Laravel</span>
                            <span class="text-sm text-gray-900">{{ app()->version() }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                            <span class="text-sm font-medium text-gray-700">PHP</span>
                            <span class="text-sm text-gray-900">{{ PHP_VERSION }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                            <span class="text-sm font-medium text-gray-700">Status</span>
                            <span class="text-sm text-green-600 font-medium">Online</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                            <span class="text-sm font-medium text-gray-700">Last Update</span>
                            <span class="text-sm text-gray-900">{{ now()->format('d M Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button onclick="closeAllModals()" class="w-full px-4 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Modal -->
    <div id="help-modal" class="fixed inset-0 z-[9999] hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Bantuan & Panduan</h3>
                        <button onclick="closeAllModals()" class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="p-4 border border-blue-200 bg-blue-50 rounded-xl">
                            <h4 class="font-semibold text-blue-900 mb-2">📚 Panduan Penggunaan</h4>
                            <p class="text-sm text-blue-700">Pelajari cara menggunakan sistem admin Harum Motor dengan lengkap.</p>
                        </div>
                        
                        <div class="p-4 border border-green-200 bg-green-50 rounded-xl">
                            <h4 class="font-semibold text-green-900 mb-2">💬 Dukungan Teknis</h4>
                            <p class="text-sm text-green-700">Hubungi tim support untuk bantuan teknis: <br><strong>support@harummotor.com</strong></p>
                        </div>
                        
                        <div class="p-4 border border-yellow-200 bg-yellow-50 rounded-xl">
                            <h4 class="font-semibold text-yellow-900 mb-2">🔧 Pemeliharaan</h4>
                            <p class="text-sm text-yellow-700">Sistem akan maintenance setiap Minggu pukul 02:00 - 04:00 WIB.</p>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button onclick="closeAllModals()" class="w-full px-4 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Backup Modal -->
    <div id="backup-modal" class="fixed inset-0 z-[9999] hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Backup Data</h3>
                        <button onclick="closeAllModals()" class="text-gray-400 hover:text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <button onclick="createBackup()" class="w-full flex items-center justify-between p-4 border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-download text-blue-600 mr-3"></i>
                                <span class="font-medium">Buat Backup</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </button>
                        
                        <button onclick="restoreBackup()" class="w-full flex items-center justify-between p-4 border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-upload text-green-600 mr-3"></i>
                                <span class="font-medium">Restore Backup</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </button>
                    </div>
                    
                    <div class="mt-6">
                        <button onclick="closeAllModals()" class="w-full px-4 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- UPDATE JavaScript dengan fungsi modal --}}

    <script>
        // Theme Management
        let currentTheme = localStorage.getItem('theme') || 'light';
        
        // Initialize theme on page load
        function initTheme() {
            const body = document.body;
            const themeIndicator = document.getElementById('theme-indicator');
            const themeIcon = document.getElementById('theme-icon');
            
            body.setAttribute('data-theme', currentTheme);
            
            if (currentTheme === 'dark') {
                themeIndicator.textContent = 'Dark';
                themeIndicator.classList.remove('bg-gray-100');
                themeIndicator.classList.add('bg-gray-800', 'text-white');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
                body.classList.remove('bg-gray-900');
                body.classList.add('bg-gray-800');
            } else {
                themeIndicator.textContent = 'Light';
                themeIndicator.classList.remove('bg-gray-800', 'text-white');
                themeIndicator.classList.add('bg-gray-100');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
                body.classList.remove('bg-gray-800');
                body.classList.add('bg-gray-900');
            }
        }

        // Toggle Theme Function
        function toggleTheme() {
            const body = document.body;
            const themeIndicator = document.getElementById('theme-indicator');
            const themeIcon = document.getElementById('theme-icon');
            
            // Switch theme
            currentTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            // Apply theme with animation
            body.style.transition = 'all 0.3s ease';
            body.setAttribute('data-theme', currentTheme);
            
            if (currentTheme === 'dark') {
                // Dark mode
                themeIndicator.textContent = 'Dark';
                themeIndicator.classList.remove('bg-gray-100');
                themeIndicator.classList.add('bg-gray-800', 'text-white');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
                
                showToast('🌙 Dark mode diaktifkan', 'success');
            } else {
                // Light mode
                themeIndicator.textContent = 'Light';
                themeIndicator.classList.remove('bg-gray-800', 'text-white');
                themeIndicator.classList.add('bg-gray-100');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
                
                showToast('☀️ Light mode diaktifkan', 'success');
            }
            
            // Save to localStorage
            localStorage.setItem('theme', currentTheme);
            
            // Hide dropdown
            hideAllDropdowns();
            
            // Remove transition after animation completes
            setTimeout(() => {
                body.style.transition = '';
            }, 300);
        }

        // Apply theme to dynamic content
        function applyThemeToElement(element) {
            const currentTheme = document.body.getAttribute('data-theme');
            
            if (currentTheme === 'dark') {
                element.classList.add('dark-theme');
            } else {
                element.classList.remove('dark-theme');
            }
        }

        // Keep all existing JavaScript functionality
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobile-overlay');
        const closeSidebar = document.getElementById('close-sidebar');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            mobileOverlay.classList.toggle('hidden');
        }

        mobileMenuBtn?.addEventListener('click', toggleSidebar);
        closeSidebar?.addEventListener('click', toggleSidebar);
        mobileOverlay?.addEventListener('click', toggleSidebar);

        // DROPDOWN FUNCTIONALITY
        const notificationBtn = document.getElementById('notification-btn');
        const notificationDropdown = document.getElementById('notification-dropdown');
        const notificationBadge = document.getElementById('notification-badge');
        const settingsBtn = document.getElementById('settings-btn');
        const settingsDropdown = document.getElementById('settings-dropdown');

        function showDropdown(dropdown) {
            if (dropdown) {
                dropdown.classList.remove('dropdown-hide');
                dropdown.classList.add('dropdown-show');
                dropdown.style.zIndex = '9999';
            }
        }

        function hideDropdown(dropdown) {
            if (dropdown) {
                dropdown.classList.remove('dropdown-show');
                dropdown.classList.add('dropdown-hide');
            }
        }

        function hideAllDropdowns() {
            hideDropdown(notificationDropdown);
            hideDropdown(settingsDropdown);
        }

        notificationBtn?.addEventListener('click', function(e) {
            e.stopPropagation();
            hideDropdown(settingsDropdown);
            
            if (notificationDropdown.classList.contains('dropdown-show')) {
                hideDropdown(notificationDropdown);
            } else {
                showDropdown(notificationDropdown);
                if (notificationBadge) {
                    notificationBadge.style.display = 'none';
                }
            }
        });

        settingsBtn?.addEventListener('click', function(e) {
            e.stopPropagation();
            hideDropdown(notificationDropdown);
            
            if (settingsDropdown.classList.contains('dropdown-show')) {
                hideDropdown(settingsDropdown);
            } else {
                showDropdown(settingsDropdown);
            }
        });

        document.addEventListener('click', function(e) {
            if (!notificationBtn?.contains(e.target) && !notificationDropdown?.contains(e.target)) {
                hideDropdown(notificationDropdown);
            }
            
            if (!settingsBtn?.contains(e.target) && !settingsDropdown?.contains(e.target)) {
                hideDropdown(settingsDropdown);
            }
        });

        notificationDropdown?.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        settingsDropdown?.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // Modal Functions
        function openProfileModal() {
            document.getElementById('modal-overlay').classList.remove('hidden');
            document.getElementById('profile-modal').classList.remove('hidden');
            hideAllDropdowns();
            setTimeout(() => {
                document.querySelector('#profile-modal .transform').classList.remove('scale-95');
                document.querySelector('#profile-modal .transform').classList.add('scale-100');
            }, 10);
        }

        function openSecurityModal() {
            document.getElementById('modal-overlay').classList.remove('hidden');
            document.getElementById('security-modal').classList.remove('hidden');
            hideAllDropdowns();
            setTimeout(() => {
                document.querySelector('#security-modal .transform').classList.remove('scale-95');
                document.querySelector('#security-modal .transform').classList.add('scale-100');
            }, 10);
        }

        function openSystemInfoModal() {
            document.getElementById('modal-overlay').classList.remove('hidden');
            document.getElementById('system-info-modal').classList.remove('hidden');
            hideAllDropdowns();
            setTimeout(() => {
                document.querySelector('#system-info-modal .transform').classList.remove('scale-95');
                document.querySelector('#system-info-modal .transform').classList.add('scale-100');
            }, 10);
        }

        function openHelpModal() {
            document.getElementById('modal-overlay').classList.remove('hidden');
            document.getElementById('help-modal').classList.remove('hidden');
            hideAllDropdowns();
            setTimeout(() => {
                document.querySelector('#help-modal .transform').classList.remove('scale-95');
                document.querySelector('#help-modal .transform').classList.add('scale-100');
            }, 10);
        }

        function openBackupModal() {
            document.getElementById('modal-overlay').classList.remove('hidden');
            document.getElementById('backup-modal').classList.remove('hidden');
            hideAllDropdowns();
            setTimeout(() => {
                document.querySelector('#backup-modal .transform').classList.remove('scale-95');
                document.querySelector('#backup-modal .transform').classList.add('scale-100');
            }, 10);
        }

        function closeAllModals() {
            const modals = ['profile-modal', 'security-modal', 'system-info-modal', 'help-modal', 'backup-modal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.querySelector('.transform').classList.add('scale-95');
                    modal.querySelector('.transform').classList.remove('scale-100');
                }
            });
            
            setTimeout(() => {
                document.getElementById('modal-overlay').classList.add('hidden');
                modals.forEach(modalId => {
                    document.getElementById(modalId).classList.add('hidden');
                });
            }, 200);
        }

        function saveProfile() {
            showToast('Profil berhasil disimpan!', 'success');
            closeAllModals();
        }

        function changePassword() {
            const oldPassword = document.getElementById('old-password').value;
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            if (!oldPassword || !newPassword || !confirmPassword) {
                showToast('Semua field harus diisi!', 'error');
                return;
            }

            if (newPassword !== confirmPassword) {
                showToast('Password baru dan konfirmasi tidak sama!', 'error');
                return;
            }

            if (newPassword.length < 8) {
                showToast('Password harus minimal 8 karakter!', 'error');
                return;
            }

            showToast('Password berhasil diubah!', 'success');
            closeAllModals();
        }

        function createBackup() {
            showToast('Backup sedang dibuat...', 'info');
            setTimeout(() => {
                showToast('Backup berhasil dibuat!', 'success');
                closeAllModals();
            }, 3000);
        }

        function restoreBackup() {
            if (confirm('Yakin ingin restore backup? Data saat ini akan diganti.')) {
                showToast('Restore backup dimulai...', 'info');
                setTimeout(() => {
                    showToast('Restore backup berhasil!', 'success');
                    closeAllModals();
                }, 5000);
            }
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            
            toast.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-[9999] transform translate-x-full transition-transform duration-300`;
            toast.innerHTML = `
                <div class="flex items-center space-x-2">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }

        // Close modal when clicking overlay
        document.getElementById('modal-overlay')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeAllModals();
            }
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                mobileOverlay.classList.add('hidden');
            }
            hideAllDropdowns();
        });

        // Initialize theme when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initTheme();
            hideAllDropdowns();
            
            // Add theme transition to all relevant elements
            const elementsToTransition = document.querySelectorAll('.glass-effect, .dropdown-menu, .floating-card, .modal-content');
            elementsToTransition.forEach(element => {
                element.classList.add('theme-transition');
            });
        });

        // Watch for theme changes and update dynamically created elements
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList') {
                    mutation.addedNodes.forEach(function(node) {
                        if (node.nodeType === 1) { // Element node
                            applyThemeToElement(node);
                        }
                    });
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    </script>
</body>
</html>