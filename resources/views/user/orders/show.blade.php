
@extends('layouts.user')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<!-- Hero Section -->
<div class="pt-24 pb-12 bg-gradient-to-br from-blue-50 via-white to-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-8">
            <a href="{{ route('user.home') }}" class="hover:text-blue-600 transition-colors">
                <i class="fas fa-home"></i> Beranda
            </a>
            <i class="fas fa-chevron-right text-gray-400"></i>
            <a href="{{ route('user.orders.index') }}" class="hover:text-blue-600 transition-colors">
                Pesanan Saya
            </a>
            <i class="fas fa-chevron-right text-gray-400"></i>
            <span class="text-blue-600 font-medium">Detail Pesanan #{{ $order->id }}</span>
        </nav>

        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full mb-6 shadow-lg">
                <i class="fas fa-receipt text-white text-2xl"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 leading-tight">
                Detail
                <span class="bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">Pesanan</span>
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Informasi lengkap mengenai pesanan Anda dan status terkini.
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
    </div>
</div>

<!-- Order Details Section -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Order Information Card -->
            <div class="bg-white rounded-2xl shadow-xl mb-8 overflow-hidden border border-gray-100">
                <!-- Order Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-6 text-white">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                        <div>
                            <h2 class="text-2xl font-bold mb-2">
                                <i class="fas fa-receipt mr-3"></i>
                                Order #{{ $order->id }}
                            </h2>
                            <p class="text-blue-100">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                Dipesan pada 
                                @if($order->created_at)
                                    {{ $order->created_at->format('d F Y, H:i') }} WIB
                                @else
                                    {{ now()->format('d F Y, H:i') }} WIB
                                @endif
                            </p>
                        </div>
                        <div class="text-right">
                            @php
                                $statusConfig = [
                                    'pending' => ['bg-yellow-500 text-white', 'Menunggu Pembayaran', 'fas fa-clock'],
                                    'confirmed' => ['bg-blue-500 text-white', 'Dikonfirmasi', 'fas fa-check-circle'],
                                    'processing' => ['bg-purple-500 text-white', 'Sedang Diproses', 'fas fa-cog'],
                                    'shipped' => ['bg-indigo-500 text-white', 'Dalam Pengiriman', 'fas fa-truck'],
                                    'delivered' => ['bg-green-500 text-white', 'Selesai', 'fas fa-check-double'],
                                    'canceled' => ['bg-red-500 text-white', 'Dibatalkan', 'fas fa-times-circle']
                                ];
                                $config = $statusConfig[$order->status ?? 'pending'] ?? ['bg-gray-500 text-white', 'Unknown', 'fas fa-question'];
                            @endphp
                            <div class="inline-flex items-center px-4 py-2 rounded-xl text-lg font-bold {{ $config[0] }} shadow-lg">
                                <i class="{{ $config[2] }} mr-2"></i>
                                {{ $config[1] }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="p-8">
                    <!-- Customer Information -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">
                                <i class="fas fa-user text-blue-600 mr-2"></i>
                                Informasi Customer
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <span class="text-gray-600 w-20">Nama:</span>
                                    <span class="font-medium text-gray-900">{{ $order->user->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-600 w-20">Email:</span>
                                    <span class="font-medium text-gray-900">{{ $order->user->email ?? 'N/A' }}</span>
                                </div>
                                @if(isset($order->user->phone) && $order->user->phone)
                                    <div class="flex items-center">
                                        <span class="text-gray-600 w-20">Telepon:</span>
                                        <span class="font-medium text-gray-900">{{ $order->user->phone }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">
                                <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                                Informasi Pesanan
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <span class="text-gray-600 w-24">ID Pesanan:</span>
                                    <span class="font-medium text-gray-900">#{{ $order->id }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-600 w-24">Total Item:</span>
                                    <span class="font-medium text-gray-900">{{ $order->orderDetails ? $order->orderDetails->count() : 0 }} item</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-600 w-24">Total Harga:</span>
                                    <span class="font-bold text-blue-600 text-lg">Rp{{ number_format($order->total_price ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Timeline -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">
                            <i class="fas fa-history text-blue-600 mr-2"></i>
                            Status Timeline
                        </h3>
                        <div class="relative">
                            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                            
                            @php
                                $timeline = [
                                    ['status' => 'pending', 'title' => 'Pesanan Dibuat', 'desc' => 'Pesanan berhasil dibuat dan menunggu konfirmasi'],
                                    ['status' => 'confirmed', 'title' => 'Pesanan Dikonfirmasi', 'desc' => 'Pesanan telah dikonfirmasi oleh admin'],
                                    ['status' => 'processing', 'title' => 'Sedang Diproses', 'desc' => 'Pesanan sedang disiapkan'],
                                    ['status' => 'shipped', 'title' => 'Dalam Pengiriman', 'desc' => 'Pesanan sedang dalam perjalanan'],
                                    ['status' => 'delivered', 'title' => 'Selesai', 'desc' => 'Pesanan telah diterima customer']
                                ];
                                
                                $currentStatusIndex = array_search($order->status ?? 'pending', array_column($timeline, 'status'));
                                if ($currentStatusIndex === false) $currentStatusIndex = 0;
                            @endphp

                            @foreach($timeline as $index => $step)
                                <div class="relative flex items-start mb-6">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center {{ $index <= $currentStatusIndex ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600' }} relative z-10">
                                        @if($index <= $currentStatusIndex)
                                            <i class="fas fa-check text-sm"></i>
                                        @else
                                            <div class="w-2 h-2 bg-current rounded-full"></div>
                                        @endif
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h4 class="font-bold {{ $index <= $currentStatusIndex ? 'text-blue-600' : 'text-gray-500' }}">
                                            {{ $step['title'] }}
                                        </h4>
                                        <p class="text-sm text-gray-600 mt-1">{{ $step['desc'] }}</p>
                                        @if($index === $currentStatusIndex)
                                            <p class="text-xs text-blue-600 mt-2 font-medium">
                                                <i class="fas fa-clock mr-1"></i>
                                                Terakhir diupdate: 
                                                @if($order->updated_at)
                                                    {{ $order->updated_at->format('d M Y, H:i') }}
                                                @else
                                                    {{ now()->format('d M Y, H:i') }}
                                                @endif
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">
                            <i class="fas fa-shopping-cart text-blue-600 mr-2"></i>
                            Item Pesanan
                        </h3>
                        <div class="space-y-4">
                            @if($order->orderDetails && $order->orderDetails->count() > 0)
                                @foreach($order->orderDetails as $detail)
                                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center space-x-6">
                                            <!-- Product Image -->
                                            <div class="flex-shrink-0">
                                                @if($detail->sparepart && $detail->sparepart->image)
                                                    <img src="{{ asset('storage/' . $detail->sparepart->image) }}" 
                                                         alt="{{ $detail->sparepart->name }}" 
                                                         class="w-20 h-20 object-cover rounded-xl border-2 border-white shadow-lg">
                                                @else
                                                    <div class="w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-300 rounded-xl flex items-center justify-center border-2 border-white shadow-lg">
                                                        <i class="fas fa-cog text-gray-500 text-2xl"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Product Info -->
                                            <div class="flex-1">
                                                <h4 class="text-xl font-bold text-gray-900 mb-2">
                                                    {{ $detail->sparepart->name ?? 'Unknown Item' }}
                                                </h4>
                                                <p class="text-gray-600 mb-3">
                                                    {{ Str::limit($detail->sparepart->description ?? 'No description', 100) }}
                                                </p>
                                                <div class="flex items-center space-x-4">
                                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-lg text-sm font-medium">
                                                        <i class="fas fa-box mr-1"></i>{{ $detail->quantity ?? 1 }} pcs
                                                    </span>
                                                    <span class="text-gray-500">×</span>
                                                    <span class="text-lg font-medium text-gray-700">
                                                        Rp{{ number_format($detail->price ?? 0, 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Price -->
                                            <div class="text-right">
                                                <div class="text-2xl font-bold text-blue-600">
                                                    Rp{{ number_format($detail->subtotal ?? ($detail->price ?? 0) * ($detail->quantity ?? 1), 0, ',', '.') }}
                                                </div>
                                                <div class="text-sm text-gray-500">Subtotal</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-12">
                                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                                        <i class="fas fa-shopping-cart text-gray-400 text-2xl"></i>
                                    </div>
                                    <h4 class="text-lg font-medium text-gray-900 mb-2">Tidak ada item</h4>
                                    <p class="text-gray-500">Pesanan ini tidak memiliki item yang tercatat.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border-2 border-blue-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">
                                    <i class="fas fa-calculator text-blue-600 mr-2"></i>
                                    Total Pesanan
                                </h3>
                                <p class="text-gray-600">{{ $order->orderDetails ? $order->orderDetails->count() : 0 }} item(s)</p>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-extrabold text-blue-600">
                                    Rp{{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                                </div>
                                <div class="text-sm text-gray-600">Total Pembayaran</div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('user.orders.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl font-bold transition-all duration-300 transform hover:scale-[1.02] shadow-lg">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Pesanan
                        </a>

                        @if(($order->status ?? 'pending') === 'pending')
                            <button onclick="cancelOrder({{ $order->id }})" 
                                    class="inline-flex items-center justify-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold transition-all duration-300 transform hover:scale-[1.02] shadow-lg">
                                <i class="fas fa-times mr-2"></i>
                                Batalkan Pesanan
                            </button>
                        @endif

                        @if(($order->status ?? 'pending') === 'delivered')
                            <button class="inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold transition-all duration-300 transform hover:scale-[1.02] shadow-lg">
                                <i class="fas fa-star mr-2"></i>
                                Beri Ulasan
                            </button>
                        @endif

                        <!-- @if(($order->status ?? 'pending') === 'shipped')
                            <button class="inline-flex items-center justify-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-bold transition-all duration-300 transform hover:scale-[1.02] shadow-lg">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                Lacak Pengiriman
                            </button>
                        @endif -->

                        <button onclick="printOrder()" 
                                class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold transition-all duration-300 transform hover:scale-[1.02] shadow-lg">
                            <i class="fas fa-print mr-2"></i>
                            Print Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Section -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-blue-600 to-indigo-800 rounded-2xl shadow-xl text-white p-12 text-center relative overflow-hidden">
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
                    Tim customer service kami siap membantu Anda dengan pertanyaan seputar pesanan ini.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="https://wa.me/62123456789?text=Halo,%20saya%20butuh%20bantuan%20dengan%20pesanan%20%23{{ $order->id }}" 
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
                window.location.href = '{{ route("user.orders.index") }}';
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

function printOrder() {
    window.print();
}

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
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .bg-gradient-to-br,
    .bg-gradient-to-r {
        background: white !important;
        color: black !important;
    }
}

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