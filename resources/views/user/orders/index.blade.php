filepath: c:\laragon\www\wep_Kape\resources\views\user\orders\index.blade.php
@extends('layouts.user')

@section('title', 'Pesanan Saya')

@section('content')
<!-- Hero Section -->
<div class="pt-24 pb-12 bg-gradient-to-br from-blue-50 via-white to-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full mb-6 shadow-lg">
                <i class="fas fa-shopping-bag text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                Pesanan
                <span class="bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">Saya</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Lacak dan kelola semua pesanan sparepart Anda dengan mudah dan transparan.
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

        <!-- Navigation Tabs -->
        <div class="bg-white rounded-2xl shadow-lg p-2 mb-8 max-w-md mx-auto">
            <div class="flex space-x-2">
                <a href="{{ route('user.spareparts.index') }}" 
                   class="flex-1 px-6 py-3 text-gray-600 rounded-xl font-medium text-center hover:bg-gray-100 transition-colors">
                    <i class="fas fa-cog mr-2"></i>Catalog
                </a>
                <a href="{{ route('user.orders.index') }}" 
                   class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-xl font-medium text-center hover:bg-blue-700 transition-colors">
                    <i class="fas fa-shopping-bag mr-2"></i>Pesanan
                </a>
            </div>
        </div>

        <!-- Orders Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto mb-8">
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-center border border-gray-100">
                <div class="bg-gradient-to-br from-yellow-100 to-orange-200 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-clock text-yellow-600 text-lg"></i>
                </div>
                <div class="text-xl font-bold text-gray-900">{{ $orders->where('status', 'pending')->count() }}</div>
                <div class="text-sm text-gray-600">Menunggu</div>
            </div>
            
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-center border border-gray-100">
                <div class="bg-gradient-to-br from-green-100 to-emerald-200 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-money-bill text-green-600 text-lg"></i>
                </div>
                <div class="text-xl font-bold text-gray-900">{{ $orders->where('status', 'paid')->count() }}</div>
                <div class="text-sm text-gray-600">Dibayar</div>
            </div>
            
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-center border border-gray-100">
                <div class="bg-gradient-to-br from-purple-100 to-indigo-200 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-truck text-purple-600 text-lg"></i>
                </div>
                <div class="text-xl font-bold text-gray-900">{{ $orders->where('status', 'shipped')->count() }}</div>
                <div class="text-sm text-gray-600">Dikirim</div>
            </div>
            
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-center border border-gray-100">
                <div class="bg-gradient-to-br from-blue-100 to-sky-200 w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-check text-blue-600 text-lg"></i>
                </div>
                <div class="text-xl font-bold text-gray-900">{{ $orders->where('status', 'delivered')->count() }}</div>
                <div class="text-sm text-gray-600">Selesai</div>
            </div>
        </div>
    </div>
</div>

<!-- Orders List Section -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Riwayat Pesanan
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full mx-auto"></div>
        </div>

        <div class="max-w-6xl mx-auto">
            @forelse($orders as $order)
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 mb-8 overflow-hidden border border-gray-100">
                    <!-- Order Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-5 border-b border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                            <div class="flex items-center space-x-4">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-lg">
                                    <i class="fas fa-receipt mr-2"></i>
                                    Order #{{ $order->id }}
                                </div>
                                <div class="text-sm text-gray-600 bg-white px-3 py-1 rounded-lg border">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    @if($order->created_at)
                                        {{ $order->created_at->format('d M Y, H:i') }}
                                    @else
                                        Tanggal tidak tersedia
                                    @endif
                                </div>
                            </div>
                            <div>
                                @php
                                    $statusConfig = [
                                        'pending' => ['bg-gradient-to-r from-yellow-100 to-orange-100 text-yellow-800 border-yellow-200', 'Menunggu Pembayaran', 'fas fa-clock'],
                                        'paid' => ['bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border-green-200', 'Sudah Dibayar', 'fas fa-money-bill'],
                                        'shipped' => ['bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-800 border-indigo-200', 'Dikirim', 'fas fa-truck'],
                                        'delivered' => ['bg-gradient-to-r from-blue-100 to-sky-100 text-blue-800 border-blue-200', 'Selesai', 'fas fa-check-double'],
                                        'canceled' => ['bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border-red-200', 'Dibatalkan', 'fas fa-times-circle']
                                    ];
                                    $config = $statusConfig[$order->status] ?? ['bg-gray-100 text-gray-800 border-gray-200', 'Unknown', 'fas fa-question'];
                                @endphp
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold border {{ $config[0] }} shadow-sm">
                                    <i class="{{ $config[2] }} mr-2"></i>
                                    {{ $config[1] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($order->orderDetails as $detail)
                                <div class="flex items-center space-x-4 p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border border-gray-200 hover:shadow-md transition-all duration-200">
                                    <div class="flex-shrink-0">
                                        @if($detail->sparepart && $detail->sparepart->image)
                                            <img src="{{ asset('storage/' . $detail->sparepart->image) }}" 
                                                 alt="{{ $detail->sparepart->name }}" 
                                                 class="w-16 h-16 object-cover rounded-xl border-2 border-white shadow-md">
                                        @else
                                            <div class="w-16 h-16 bg-gradient-to-br from-gray-200 to-gray-300 rounded-xl flex items-center justify-center border-2 border-white shadow-md">
                                                <i class="fas fa-cog text-gray-500 text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-bold text-gray-900 mb-1">{{ $detail->sparepart->name ?? 'Unknown Item' }}</h4>
                                        <p class="text-gray-600 text-sm mb-2">{{ Str::limit($detail->sparepart->description ?? 'No description', 80) }}</p>
                                        <div class="flex items-center space-x-4">
                                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-lg text-sm font-medium">
                                                <i class="fas fa-box mr-1"></i>{{ $detail->quantity }} pcs
                                            </span>
                                            <span class="text-sm text-gray-500">×</span>
                                            <span class="text-sm font-medium text-gray-700">Rp{{ number_format($detail->price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xl font-bold text-blue-600">
                                            Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </div>
                                        <div class="text-xs text-gray-500">Subtotal</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Total -->
                        <div class="mt-6 pt-6 border-t-2 border-gray-200">
                            <div class="flex justify-between items-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                                <div class="text-xl font-bold text-gray-900">
                                    <i class="fas fa-calculator mr-2 text-blue-600"></i>
                                    Total Pesanan:
                                </div>
                                <div class="text-2xl font-extrabold text-blue-600">
                                    Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        <!-- Order Actions -->
                        <div class="mt-6 flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('user.orders.show', $order->id) }}" 
                               class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-bold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                <i class="fas fa-eye mr-2"></i>
                                Detail Pesanan
                            </a>
                            
                            @if($order->status === 'delivered')
                                @php
                                    // Check if user has reviewed any sparepart from this order
                                    $hasReview = false;
                                    if($order->orderDetails->count() > 0) {
                                        $firstSparepartId = $order->orderDetails->first()->sparepart_id ?? null;
                                        if($firstSparepartId) {
                                            $hasReview = \App\Models\Review::where('user_id', Auth::id())
                                                ->where('sparepart_id', $firstSparepartId)
                                                ->exists();
                                        }
                                    }
                                @endphp
                                
                                @if($hasReview)
                                    <button class="inline-flex items-center justify-center px-6 py-3 bg-gray-400 text-white rounded-xl font-bold cursor-not-allowed" disabled>
                                        <i class="fas fa-check mr-2"></i>
                                        Sudah Diulas
                                    </button>
                                @else
                                    <button onclick="openReviewModal({{ $order->id }})" 
                                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-700 hover:from-green-700 hover:to-emerald-800 text-white rounded-xl font-bold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                        <i class="fas fa-star mr-2"></i>
                                        Beri Ulasan
                                    </button>
                                @endif
                            @endif

                            @if($order->status === 'pending')
                                <button onclick="cancelOrder({{ $order->id }})" 
                                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-xl font-bold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                    <i class="fas fa-times mr-2"></i>
                                    Batalkan Pesanan
                                </button>
                            @endif

                            @if($order->status === 'shipped')
                                <button class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-700 hover:from-purple-700 hover:to-indigo-800 text-white rounded-xl font-bold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    Lacak Pengiriman
                                </button>
                            @endif

                            <!-- @if($order->status === 'delivered')
                                <button onclick="completeOrder({{ $order->id }})" 
                                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl font-bold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                    <i class="fas fa-check mr-2"></i>
                                    Selesai
                                </button>
                            @endif -->
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="text-center py-20">
                    <div class="bg-gradient-to-br from-gray-100 to-gray-200 rounded-full p-12 w-32 h-32 mx-auto mb-8 flex items-center justify-center shadow-lg">
                        <i class="fas fa-shopping-bag text-gray-400 text-5xl"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Belum Ada Pesanan</h3>
                    <p class="text-gray-600 mb-8 text-lg max-w-md mx-auto">
                        Anda belum memiliki pesanan sparepart. Mulai belanja untuk melihat pesanan di sini.
                    </p>
                    <a href="{{ route('user.spareparts.index') }}" 
                       class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-8 py-4 rounded-2xl font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        Belanja Sparepart
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Contact Section -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-blue-600 to-indigo-800 rounded-2xl shadow-xl text-white p-12 text-center relative overflow-hidden">
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
                <h3 class="text-3xl font-bold mb-4">Butuh Bantuan dengan Pesanan?</h3>
                <p class="text-lg mb-8 opacity-90 max-w-2xl mx-auto">
                    Tim customer service kami siap membantu Anda 24/7 untuk pertanyaan seputar pesanan dan status pengiriman.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="https://wa.me/62123456789" 
                       class="inline-flex items-center gap-3 bg-green-500 hover:bg-green-600 text-white px-8 py-4 rounded-xl font-bold transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fab fa-whatsapp text-xl"></i>
                        WhatsApp
                    </a>
                    <a href="tel:+62123456789" 
                       class="inline-flex items-center gap-3 bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-xl font-bold transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-phone text-xl"></i>
                        Telepon
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Review Modal -->
<div id="reviewModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="bg-gradient-to-r from-green-600 to-emerald-700 text-white p-6 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold">
                    <i class="fas fa-star mr-2"></i>
                    Beri Ulasan Pesanan
                </h3>
                <button onclick="closeReviewModal()" class="text-white hover:text-gray-200 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <form id="reviewForm" class="p-6">
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-star text-yellow-500 mr-1"></i>
                    Rating Pesanan
                </label>
                <div class="flex space-x-2 mb-4">
                    <div class="star-rating flex space-x-1">
                        <button type="button" onclick="setRating(1)" class="star text-3xl text-gray-300 hover:text-yellow-500 transition-colors" data-rating="1">★</button>
                        <button type="button" onclick="setRating(2)" class="star text-3xl text-gray-300 hover:text-yellow-500 transition-colors" data-rating="2">★</button>
                        <button type="button" onclick="setRating(3)" class="star text-3xl text-gray-300 hover:text-yellow-500 transition-colors" data-rating="3">★</button>
                        <button type="button" onclick="setRating(4)" class="star text-3xl text-gray-300 hover:text-yellow-500 transition-colors" data-rating="4">★</button>
                        <button type="button" onclick="setRating(5)" class="star text-3xl text-gray-300 hover:text-yellow-500 transition-colors" data-rating="5">★</button>
                    </div>
                </div>
                <input type="hidden" id="rating" name="rating" value="0">
                <p class="text-sm text-gray-600">Klik bintang untuk memberikan rating</p>
            </div>
            
            <div class="mb-6">
                <label for="review" class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fas fa-comment-alt text-blue-500 mr-1"></i>
                    Ulasan Anda
                </label>
                <textarea id="review" name="review" rows="4" 
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none"
                          placeholder="Bagikan pengalaman Anda dengan pesanan ini..."></textarea>
            </div>
            
            <div class="flex space-x-3">
                <button type="button" onclick="closeReviewModal()" 
                        class="flex-1 px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl font-bold transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-700 hover:from-green-700 hover:to-emerald-800 text-white rounded-xl font-bold transition-all">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Kirim Ulasan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript -->
<script>
function cancelOrder(orderId) {
    if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan.')) {
        const button = event.target;
        const originalContent = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Membatalkan...';
        button.disabled = true;

        fetch(`/my-orders/${orderId}/cancel`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal membatalkan pesanan: ' + (data.message || 'Unknown error'));
                button.innerHTML = originalContent;
                button.disabled = false;
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan: ' + error.message);
            button.innerHTML = originalContent;
            button.disabled = false;
        });
    }
}

// Review modal functions
let currentOrderId = null;
let currentRating = 0;

function openReviewModal(orderId) {
    console.log('Opening review modal for order:', orderId); // Debug
    currentOrderId = orderId;
    document.getElementById('reviewModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    resetForm();
}

function closeReviewModal() {
    console.log('Closing review modal'); // Debug
    document.getElementById('reviewModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    resetForm();
}

function resetForm() {
    currentRating = 0;
    document.getElementById('rating').value = '0';
    document.getElementById('review').value = '';
    updateStarDisplay();
}

function setRating(rating) {
    console.log('Setting rating:', rating); // Debug
    currentRating = rating;
    document.getElementById('rating').value = rating;
    updateStarDisplay();
}

function updateStarDisplay() {
    const stars = document.querySelectorAll('.star');
    stars.forEach((star, index) => {
        if (index < currentRating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-500');
        } else {
            star.classList.remove('text-yellow-500');
            star.classList.add('text-gray-300');
        }
    });
}

// Form submit handler
document.addEventListener('DOMContentLoaded', function() {
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Review form submitted'); // Debug
            
            if (currentRating === 0) {
                alert('Silakan berikan rating terlebih dahulu!');
                return;
            }
            
            const review = document.getElementById('review').value.trim();
            if (review === '') {
                alert('Silakan tulis ulasan Anda!');
                return;
            }
            
            const submitButton = e.target.querySelector('button[type="submit"]');
            const originalContent = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
            submitButton.disabled = true;
            
            console.log('Sending review data:', {
                orderId: currentOrderId,
                rating: currentRating,
                review: review
            }); // Debug
            
            fetch(`/my-orders/${currentOrderId}/review`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    rating: currentRating,
                    review: review
                })
            })
            .then(response => {
                console.log('Response status:', response.status); // Debug
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data); // Debug
                if (data.success) {
                    closeReviewModal();
                    alert('Terima kasih! Ulasan Anda berhasil dikirim.');
                    location.reload();
                } else {
                    alert('Gagal mengirim ulasan: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error); // Debug
                alert('Terjadi kesalahan: ' + error.message);
            })
            .finally(() => {
                submitButton.innerHTML = originalContent;
                submitButton.disabled = false;
            });
        });
    }
});

// Close modal when clicking outside
document.getElementById('reviewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReviewModal();
    }
});

// Auto hide alerts
setTimeout(function() {
    const alerts = document.querySelectorAll('.border-l-4');
    alerts.forEach(function(alert) {
        alert.style.transition = 'all 0.8s ease-out';
        alert.style.transform = 'translateX(100%)';
        alert.style.opacity = '0';
        setTimeout(function() {
            if (alert.parentNode) {
                alert.parentNode.removeChild(alert);
            }
        }, 800);
    });
}, 6000);
</script>

<style>
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #3b82f6, #2563eb);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #2563eb, #1d4ed8);
}
</style>
@endsection