@extends('layouts.user')

@section('title', 'Spareparts')

@section('content')
<!-- Hero Section -->
<div class="pt-24 pb-12 bg-gradient-to-br from-red-50 via-white to-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-red-500 to-red-600 rounded-full mb-6 shadow-lg">
                <i class="fas fa-cog text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                Spareparts
                <span class="bg-gradient-to-r from-red-600 to-red-700 bg-clip-text text-transparent">Premium</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Dapatkan sparepart original berkualitas tinggi untuk kendaraan Anda dengan harga terbaik dan garansi resmi.
            </p>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-8 mx-auto max-w-4xl">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-xl shadow-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 mx-auto max-w-4xl">
                <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 text-red-800 px-6 py-4 rounded-xl shadow-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                        <p class="font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(isset($error))
            <div class="mb-8 mx-auto max-w-4xl">
                <div class="bg-gradient-to-r from-orange-50 to-yellow-50 border-l-4 border-orange-500 text-orange-800 px-6 py-4 rounded-xl shadow-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-orange-500 text-xl mr-3"></i>
                        <p class="font-medium">{{ $error }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Navigation Tabs -->
        <div class="bg-white rounded-2xl shadow-lg p-2 mb-8 max-w-md mx-auto">
            <div class="flex space-x-2">
                <a href="{{ route('user.spareparts.index') }}" 
                   class="flex-1 px-6 py-3 bg-red-600 text-white rounded-xl font-medium text-center hover:bg-red-700 transition-colors">
                    <i class="fas fa-cog mr-2"></i>Catalog
                </a>
                @auth
                    <a href="{{ route('user.orders.index') }}" 
                       class="flex-1 px-6 py-3 text-gray-600 rounded-xl font-medium text-center hover:bg-gray-100 transition-colors">
                        <i class="fas fa-shopping-bag mr-2"></i>Pesanan
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="flex-1 px-6 py-3 text-gray-600 rounded-xl font-medium text-center hover:bg-gray-100 transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                @endauth
            </div>
        </div>

        <!-- Guest Notice -->
        @guest
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-6 mb-8 max-w-4xl mx-auto">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Selamat Datang!</h3>
                            <p class="text-gray-600">Login terlebih dahulu untuk memesan.</p>
                        </div>
                    </div>
                    <a href="{{ route('login') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-medium transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                </div>
            </div>
        @endguest

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-center border border-gray-100">
                <div class="bg-gradient-to-br from-red-100 to-red-200 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-boxes text-red-600 text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $spareparts->count() }}</h3>
                <p class="text-gray-600">Produk Tersedia</p>
            </div>
            
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-center border border-gray-100">
                <div class="bg-gradient-to-br from-green-100 to-emerald-200 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-shield-alt text-green-600 text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1">100%</h3>
                <p class="text-gray-600">Original</p>
            </div>
            
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-center border border-gray-100">
                <div class="bg-gradient-to-br from-blue-100 to-sky-200 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-shipping-fast text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1">24 Jam</h3>
                <p class="text-gray-600">Pengiriman</p>
            </div>
        </div>
    </div>
</div>

<!-- Products Section -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Katalog Sparepart
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-red-500 to-red-600 rounded-full mx-auto"></div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse ($spareparts as $sparepart)
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 overflow-hidden">
                    <!-- Product Image -->
                    <div class="relative overflow-hidden h-48 bg-gradient-to-br from-gray-100 to-gray-200">
                        <!-- @php
                            // define image debug vars to avoid "Undefined variable $exists"
                            $raw = $sparepart->image ?? null;
                            // try model accessor if tersedia
                            $img = $sparepart->image_url ?? null;
                            // raw storage url (fallback)
                            $imgUrl = $raw ? (\Illuminate\Support\Facades\Storage::disk('public')->exists($raw) ? \Illuminate\Support\Facades\Storage::url($raw) : (\Illuminate\Support\Str::startsWith($raw, ['http://','https://','/']) ? $raw : (\Illuminate\Support\Str::startsWith($raw, 'storage/') ? asset($raw) : null))) : null;
                            $exists = $raw ? \Illuminate\Support\Facades\Storage::disk('public')->exists($raw) : false;
                        @endphp -->

                        @if($img)
                            <img src="{{ $img }}"
                                 alt="{{ $sparepart->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-full h-full flex items-center justify-center bg-gray-200" style="display:none;">
                                <div class="text-center">
                                    <i class="fas fa-image text-gray-400 text-4xl mb-2"></i>
                                    <p class="text-gray-500 text-sm">Image Error</p>
                                </div>
                            </div>
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-cog text-gray-400 text-4xl mb-2"></i>
                                    <p class="text-gray-500 text-sm">No Image</p>
                                </div>
                            </div>
                        @endif

                        <!-- DEBUG -->
                        <small class="text-xs text-gray-500 block mt-2">
                            URL: {{ $img ?? $imgUrl ?? '—' }} | exists on disk: {{ $exists ? 'yes' : 'no' }} | raw: {{ $raw ?? 'null' }}
                        </small>
                    </div>

                    <!-- Product Info -->
                    <div class="p-6 space-y-4">
                        <!-- Product Name -->
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-red-600 transition-colors line-clamp-2">
                            {{ $sparepart->name }}
                        </h3>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm line-clamp-2 leading-relaxed">
                            {{ $sparepart->description ?? 'Sparepart berkualitas original dengan garansi resmi.' }}
                        </p>

                        <!-- Price & Stock -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <div>
                                <span class="text-xl font-bold text-red-600">
                                    Rp{{ number_format($sparepart->price, 0, ',', '.') }}
                                </span>
                                <div class="text-xs text-gray-500">Harga satuan</div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold {{ $sparepart->stock > 5 ? 'text-green-600' : 'text-orange-600' }}">
                                    {{ $sparepart->stock }}
                                </div>
                                <div class="text-xs text-gray-500">Stok</div>
                            </div>
                        </div>

                        <!-- CONDITIONAL ORDER SECTION -->
                        @auth
                            <!-- ORDER FORM - UNTUK USER YANG SUDAH LOGIN -->
                            <form action="{{ route('spareparts.order', $sparepart->id) }}" method="POST" class="space-y-4">
                                @csrf
                                @if($sparepart->stock > 0)
                                    <!-- Quantity Selector -->
                                    <div class="bg-gray-50 rounded-xl p-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Jumlah:
                                        </label>
                                        <div class="flex items-center justify-center space-x-3">
                                            <button type="button" onclick="decreaseQuantity({{ $sparepart->id }})" 
                                                    class="w-8 h-8 bg-white border border-gray-300 rounded-full flex items-center justify-center text-gray-600 hover:text-red-600 hover:border-red-300 transition-colors">
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>
                                            <input type="number" 
                                                   name="quantity" 
                                                   id="quantity_{{ $sparepart->id }}"
                                                   value="1" 
                                                   min="1" 
                                                   max="{{ $sparepart->stock }}"
                                                   class="w-16 h-10 text-center font-bold border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                            <button type="button" onclick="increaseQuantity({{ $sparepart->id }}, {{ $sparepart->stock }})" 
                                                    class="w-8 h-8 bg-white border border-gray-300 rounded-full flex items-center justify-center text-gray-600 hover:text-red-600 hover:border-red-300 transition-colors">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Order Button -->
                                    <button type="submit"
                                        class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-6 py-3 rounded-xl font-bold focus:outline-none focus:ring-4 focus:ring-red-300 transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Pesan Sekarang
                                    </button>
                                @else
                                    <button type="button" disabled
                                        class="w-full bg-gray-400 text-white px-6 py-3 rounded-xl font-bold cursor-not-allowed">
                                        <i class="fas fa-times-circle mr-2"></i>
                                        Stok Habis
                                    </button>
                                @endif
                            </form>
                        @else
                            <!-- LOGIN PROMPT - UNTUK GUEST -->
                            <div class="space-y-4">
                                @if($sparepart->stock > 0)
                                    <!-- Preview Price -->
                                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                                        <div class="text-center">
                                            <div class="text-sm text-blue-700 mb-2">Harga mulai dari:</div>
                                            <div class="text-2xl font-bold text-blue-800">
                                                Rp{{ number_format($sparepart->price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Login to Order Button -->
                                    <a href="{{ route('login') }}" 
                                       class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl font-bold focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl flex items-center justify-center">
                                        <i class="fas fa-sign-in-alt mr-2"></i>
                                        Login untuk Pesan
                                    </a>
                                @else
                                    <button type="button" disabled
                                        class="w-full bg-gray-400 text-white px-6 py-3 rounded-xl font-bold cursor-not-allowed">
                                        <i class="fas fa-times-circle mr-2"></i>
                                        Stok Habis
                                    </button>
                                @endif
                            </div>
                        @endauth

                        <!-- Guarantee Badge -->
                        <div class="pt-3 border-t border-gray-100">
                            <div class="flex items-center justify-center text-sm text-gray-500">
                                <i class="fas fa-shield-alt text-green-500 mr-2"></i>
                                <span>Original & Bergaransi</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full">
                    <div class="bg-white rounded-2xl shadow-lg p-16 text-center">
                        <div class="bg-gray-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-box-open text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Tidak Ada Sparepart</h3>
                        <p class="text-gray-600 mb-8">Maaf, saat ini tidak ada sparepart yang tersedia.</p>
                        <a href="{{ route('user.home') }}" 
                           class="inline-flex items-center gap-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-8 py-4 rounded-xl font-bold transition-all duration-300 shadow-lg hover:shadow-xl">
                            <i class="fas fa-arrow-left"></i>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Contact Section -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-red-600 to-red-800 rounded-2xl shadow-xl text-white p-12 text-center relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <circle cx="10" cy="10" r="2" fill="white"/>
                        </pattern>
                    </defs>
                    <rect width="100" height="100" fill="url(#pattern)"/>
                </svg>
            </div>
            
            <div class="relative z-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white bg-opacity-20 rounded-full mb-6">
                    <i class="fas fa-headset text-white text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold mb-4">Butuh Bantuan?</h3>
                <p class="text-lg mb-8 opacity-90 max-w-2xl mx-auto">
                    Tim customer service kami siap membantu Anda 24/7 untuk pertanyaan seputar sparepart dan pemesanan.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="https://wa.me/62123456789" 
                       class="inline-flex items-center gap-3 bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-xl font-bold transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fab fa-whatsapp text-xl"></i>
                        WhatsApp
                    </a>
                    <a href="tel:+62123456789" 
                       class="inline-flex items-center gap-3 bg-blue-500 hover:bg-blue-600 text-white px-8 py-4 rounded-xl font-bold transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-phone text-xl"></i>
                        Telepon
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
function decreaseQuantity(sparepartId) {
    const input = document.getElementById(`quantity_${sparepartId}`);
    if (input.value > 1) {
        input.value = parseInt(input.value) - 1;
        input.style.transform = 'scale(1.1)';
        setTimeout(() => {
            input.style.transform = 'scale(1)';
        }, 150);
    }
}

function increaseQuantity(sparepartId, maxStock) {
    const input = document.getElementById(`quantity_${sparepartId}`);
    if (parseInt(input.value) < maxStock) {
        input.value = parseInt(input.value) + 1;
        input.style.transform = 'scale(1.1)';
        setTimeout(() => {
            input.style.transform = 'scale(1)';
        }, 150);
    }
}

// Auto hide alerts
setTimeout(function() {
    const alerts = document.querySelectorAll('.bg-gradient-to-r');
    alerts.forEach(function(alert) {
        if (alert.classList.contains('border-l-4')) {
            alert.style.transition = 'all 0.8s ease-out';
            alert.style.transform = 'translateX(100%)';
            alert.style.opacity = '0';
            setTimeout(function() {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 800);
        }
    });
}, 6000);

// Loading animation for form submissions
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn && !submitBtn.disabled) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            submitBtn.disabled = true;
        }
    });
});

// Smooth scroll
document.documentElement.style.scrollBehavior = 'smooth';
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #dc2626, #b91c1c);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #b91c1c, #991b1b);
}
</style>
@endsection