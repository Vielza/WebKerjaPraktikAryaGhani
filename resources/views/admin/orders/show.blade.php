@extends('layouts.admin')

@section('title', 'Detail Order #' . $order->id)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-red-600 via-red-700 to-red-800 px-6 py-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4 text-white">
                    <div class="bg-white/20 p-3 rounded-full backdrop-blur-sm">
                        <i class="fas fa-receipt text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">Detail Order #{{ $order->id }}</h2>
                        <p class="text-red-100 mt-1">Informasi lengkap order sparepart</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.orders.index') }}" 
                       class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-xl font-medium backdrop-blur-sm transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <button onclick="printOrder()" 
                            class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-xl font-medium backdrop-blur-sm transition-colors">
                        <i class="fas fa-print mr-2"></i>Print
                    </button>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Customer Info -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-50 rounded-xl p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-user text-red-500 mr-2"></i>Informasi Customer
                        </h3>
                        <div class="flex items-center space-x-4">
                            <div class="h-16 w-16 rounded-full bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-xl">
                                    {{ $order->user ? substr($order->user->name, 0, 1) : 'U' }}
                                </span>
                            </div>
                            <div>
                                <div class="text-lg font-bold text-gray-900">{{ $order->user->name ?? 'Unknown User' }}</div>
                                <div class="text-gray-600">{{ $order->user->email ?? 'No email' }}</div>
                                <div class="text-sm text-gray-500">{{ $order->user->phone ?? 'No phone' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    
                </div>

                <!-- Order Summary -->
                <div class="space-y-6">
                    <!-- Status Display Only -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-flag text-red-500 mr-2"></i>Status Order
                        </h3>
                        @php
                            $statusConfig = [
                                'pending' => ['bg-yellow-100 border-yellow-200', 'text-yellow-800', 'fa-clock', 'Menunggu Pembayaran'],
                                'confirmed' => ['bg-blue-100 border-blue-200', 'text-blue-800', 'fa-check-circle', 'Dikonfirmasi'],
                                'processing' => ['bg-purple-100 border-purple-200', 'text-purple-800', 'fa-cog', 'Sedang Diproses'],
                                'shipped' => ['bg-indigo-100 border-indigo-200', 'text-indigo-800', 'fa-truck', 'Dalam Pengiriman'],
                                'delivered' => ['bg-green-100 border-green-200', 'text-green-800', 'fa-check-double', 'Selesai'],
                                'canceled' => ['bg-red-100 border-red-200', 'text-red-800', 'fa-times-circle', 'Dibatalkan']
                            ];
                            $config = $statusConfig[$order->status ?? 'pending'] ?? ['bg-gray-100 border-gray-200', 'text-gray-800', 'fa-question', ucfirst($order->status ?? 'Unknown')];
                        @endphp
                        <div class="text-center">
                            <span class="inline-flex items-center px-4 py-3 rounded-full text-lg font-bold border {{ $config[0] }} {{ $config[1] }}">
                                <i class="fas {{ $config[2] }} mr-2"></i>
                                {{ $config[3] }}
                            </span>
                        </div>
                        
                        <!-- Status Description -->
                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-600">
                                @switch($order->status ?? 'pending')
                                    @case('pending')
                                        Order menunggu konfirmasi pembayaran dari customer
                                        @break
                                    @case('confirmed')
                                        Order telah dikonfirmasi dan akan segera diproses
                                        @break
                                    @case('processing')
                                        Order sedang disiapkan untuk pengiriman
                                        @break
                                    @case('shipped')
                                        Paket sedang dalam perjalanan ke customer
                                        @break
                                    @case('delivered')
                                        Order telah selesai dan diterima customer
                                        @break
                                    @case('canceled')
                                        Order telah dibatalkan
                                        @break
                                    @default
                                        Status order tidak diketahui
                                @endswitch
                            </p>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-calculator text-red-500 mr-2"></i>Ringkasan Order
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-medium">Rp{{ number_format($order->orderDetails ? $order->orderDetails->sum('subtotal') : 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Items:</span>
                                <span class="font-medium">{{ $order->orderDetails ? $order->orderDetails->sum('quantity') : 0 }} pcs</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jenis Item:</span>
                                <span class="font-medium">{{ $order->orderDetails ? $order->orderDetails->count() : 0 }} item</span>
                            </div>
                            <hr class="border-gray-300">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total Pembayaran:</span>
                                <span class="text-red-600">Rp{{ number_format($order->total_price ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Info -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-red-500 mr-2"></i>Informasi Order
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order ID:</span>
                                <span class="font-medium font-mono">#{{ $order->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Order:</span>
                                <span class="font-medium">{{ $order->created_at ? $order->created_at->format('d M Y, H:i') : 'N/A' }} WIB</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Customer ID:</span>
                                <span class="font-medium">#{{ $order->user_id ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-tools text-red-500 mr-2"></i>Quick Actions
                        </h3>
                        <div class="space-y-3">
                            <button onclick="printOrder()" 
                                    class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded-xl font-medium transition-colors">
                                <i class="fas fa-print mr-2"></i>Print Order
                            </button>
                            
                            <button onclick="exportOrder()" 
                                    class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded-xl font-medium transition-colors">
                                <i class="fas fa-download mr-2"></i>Export PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
function printOrder() {
    window.print();
}

function exportOrder() {
    window.open(`/admin/orders/{{ $order->id }}/export`, '_blank');
}

function sendEmailToCustomer() {
    if (confirm('Kirim email notifikasi ke customer?')) {
        fetch(`/admin/orders/{{ $order->id }}/send-email`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Email berhasil dikirim ke customer!');
            } else {
                alert('Gagal mengirim email: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan: ' + error.message);
        });
    }
}

// Print styles
const style = document.createElement('style');
style.textContent = `
    @media print {
        .no-print, button, .bg-gradient-to-r {
            display: none !important;
        }
        
        body {
            background: white !important;
        }
        
        .bg-gray-50 {
            background: #f9f9f9 !important;
        }
        
        .text-red-600 {
            color: #dc2626 !important;
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection