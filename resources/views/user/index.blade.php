@extends('layouts.user')

@section('title', 'Beranda')

@section('content')
    {{-- Hero Section dengan Gradient Background --}}
    <section class="relative bg-gradient-to-br from-red-600 via-red-700 to-red-800 py-32 text-center rounded-2xl shadow-2xl mb-16 overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(255,255,255,.1) 20px, rgba(255,255,255,.1) 40px);"></div>
        </div>
        
        {{-- Floating Elements --}}
        <div class="absolute top-10 left-10 w-20 h-20 bg-white bg-opacity-10 rounded-full animate-bounce"></div>
        <div class="absolute bottom-10 right-10 w-16 h-16 bg-white bg-opacity-10 rounded-full animate-pulse"></div>
        <div class="absolute top-1/2 left-20 w-12 h-12 bg-white bg-opacity-10 rounded-full animate-ping"></div>
        
        <div class="relative z-10">
            <div class="animate-fadeInUp">
                <h1 class="text-5xl md:text-7xl font-extrabold mb-6 text-white leading-tight">
                    Selamat Datang di 
                    <span class="text-yellow-300 drop-shadow-lg">Harum Motor</span>
                </h1>
                <p class="text-xl md:text-2xl mb-12 text-red-100 max-w-4xl mx-auto leading-relaxed">
                    🔧 Solusi terbaik untuk servis kendaraan dan pembelian sparepart berkualitas dengan teknisi berpengalaman
                </p>
            </div>
            
            <div class="flex flex-col sm:flex-row justify-center gap-6 animate-fadeInUp animation-delay-300">
                <a href="{{ route('user.booking') }}" 
                   class="group px-10 py-4 bg-white text-red-600 font-bold rounded-full shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300 hover:bg-yellow-50">
                    <i class="fas fa-calendar-plus mr-3 group-hover:animate-bounce"></i>
                    Booking Servis
                </a>
                <a href="{{ route('user.spareparts.index') }}" 
                   class="group px-10 py-4 bg-transparent text-white font-bold rounded-full border-2 border-white hover:bg-white hover:text-red-600 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-shopping-cart mr-3 group-hover:animate-bounce"></i>
                    Beli Sparepart
                </a>
            </div>
        </div>
    </section>

    {{-- About Section dengan Card Design --}}
    <section id="about" class="py-20 bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl mb-16">
        <div class="max-w-6xl mx-auto text-center px-6">
            <div class="animate-fadeInUp">
                <div class="inline-block bg-red-600 text-white px-6 py-2 rounded-full text-sm font-semibold mb-6">
                    ✨ TENTANG KAMI
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-8 text-gray-900">
                    Kenapa Memilih <span class="text-red-600 relative">
                        Harum Motor
                        <div class="absolute -bottom-2 left-0 right-0 h-1 bg-red-600 rounded-full"></div>
                    </span>?
                </h2>
                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border-l-8 border-red-600">
                    <p class="text-gray-700 text-lg md:text-xl leading-relaxed">
                        🏆 <strong>Harum Motor</strong> adalah bengkel terpercaya yang telah melayani ribuan pelanggan dengan 
                        <span class="text-red-600 font-semibold">layanan servis kendaraan profesional</span> dan 
                        <span class="text-red-600 font-semibold">penjualan sparepart original</span> dengan harga terjangkau. 
                        Kami berkomitmen memberikan pelayanan terbaik untuk kepuasan dan kepercayaan pelanggan.
                    </p>
                    <div class="flex flex-wrap justify-center gap-8 mt-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-red-600">500+</div>
                            <div class="text-gray-600">Pelanggan Puas</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-red-600">5+</div>
                            <div class="text-gray-600">Tahun Pengalaman</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Services Section dengan Modern Cards --}}
    <section id="services" class="py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 animate-fadeInUp">
                <div class="inline-block bg-red-600 text-white px-6 py-2 rounded-full text-sm font-semibold mb-6">
                    🔧 LAYANAN KAMI
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Layanan <span class="text-red-600">Premium</span> Kami
                </h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Dapatkan pelayanan terbaik dengan teknologi modern dan teknisi berpengalaman
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                {{-- Service Card 1 --}}
                <div class="group bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border-t-4 border-red-600 overflow-hidden">
                    <div class="p-8 text-center relative">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-red-50 rounded-bl-full"></div>
                        <div class="bg-gradient-to-br from-red-500 to-red-600 w-20 h-20 rounded-2xl mx-auto mb-6 flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3a3.75 3.75 0 00-3.75 3.75v.75H5.25a2.25 2.25 0 00-2.25 2.25v6a2.25 2.25 0 002.25 2.25h.75v.75a3.75 3.75 0 003.75 3.75h4.5a3.75 3.75 0 003.75-3.75v-.75h.75a2.25 2.25 0 002.25-2.25v-6a2.25 2.25 0 00-2.25-2.25h-.75v-.75A3.75 3.75 0 0014.25 3h-4.5zM9 12h6"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-4 text-gray-900 group-hover:text-red-600 transition-colors">
                            🔧 Servis Berkala
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            Perawatan rutin berkualitas tinggi untuk menjaga performa optimal kendaraan Anda dengan standar internasional.
                        </p>
                    </div>
                </div>

                {{-- Service Card 2 --}}
                <div class="group bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border-t-4 border-red-600 overflow-hidden">
                    <div class="p-8 text-center relative">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-red-50 rounded-bl-full"></div>
                        <div class="bg-gradient-to-br from-red-500 to-red-600 w-20 h-20 rounded-2xl mx-auto mb-6 flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 14a4 4 0 01-8 0m8 0a4 4 0 00-8 0m8 0v1a3 3 0 01-3 3H9a3 3 0 01-3-3v-1m8 0a4 4 0 00-8 0m8 0v1a3 3 0 01-3 3H9a3 3 0 01-3-3v-1"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-xl mb-4 text-gray-900 group-hover:text-red-600 transition-colors">
                            ⚙️ Sparepart Original
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            Jaminan sparepart asli dan bergaransi resmi untuk semua merek kendaraan dengan harga kompetitif.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 bg-gradient-to-r from-red-600 to-red-800 rounded-2xl mt-16">
        <div class="text-center text-white px-6">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Siap Merawat Kendaraan Anda? 🚗</h2>
            <p class="text-red-100 text-lg mb-8 max-w-2xl mx-auto">
                Hubungi kami sekarang untuk konsultasi gratis dan dapatkan penawaran terbaik!
            </p>
            <a href="{{ route('user.booking') }}" 
               class="inline-block bg-white text-red-600 font-bold px-8 py-4 rounded-full hover:bg-yellow-100 transition-all duration-300 transform hover:scale-105 shadow-xl">
                <i class="fas fa-phone mr-2"></i>
                Hubungi Sekarang
            </a>
        </div>
    </section>

    {{-- Custom CSS untuk Animasi --}}
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .animation-delay-300 {
            animation-delay: 0.3s;
        }
        
        .shadow-3xl {
            box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
@endsection