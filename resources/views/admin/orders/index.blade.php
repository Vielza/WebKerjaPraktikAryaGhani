@extends('layouts.admin')

@section('title', 'Order Sparepart')

@section('content')
<div class="space-y-6">
    <!-- Alert Messages -->
    @if (session('success'))
        <div class="mb-6 bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 rounded-xl shadow-lg p-4 alert-message">
            <div class="flex items-center">
                <div class="bg-green-500 p-2 rounded-full mr-4">
                    <i class="fas fa-check text-white"></i>
                </div>
                <div>
                    <div class="font-semibold text-green-900">Berhasil!</div>
                    <div class="text-green-700">{{ session('success') }}</div>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-green-600 hover:text-green-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-xl shadow-lg p-4 alert-message">
            <div class="flex items-center">
                <div class="bg-red-500 p-2 rounded-full mr-4">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                </div>
                <div>
                    <div class="font-semibold text-red-900">Error!</div>
                    <div class="text-red-700">{{ session('error') }}</div>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-red-600 hover:text-red-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-red-600 via-red-700 to-red-800 px-4 sm:px-6 py-6 sm:py-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-4 sm:space-y-0">
                <div class="flex items-center space-x-4 text-white">
                    <div class="bg-white/20 p-2 sm:p-3 rounded-full backdrop-blur-sm">
                        <i class="fas fa-shopping-bag text-xl sm:text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold">Daftar Order Sparepart</h2>
                        <p class="text-red-100 mt-1 text-sm">Manajemen order sparepart dari pelanggan</p>
                    </div>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-xl px-3 sm:px-4 py-2">
                    <div class="text-white text-center">
                        <div class="text-xs sm:text-sm opacity-90">Order Hari Ini</div>
                        <div class="text-lg sm:text-xl font-bold">{{ $orders->where('created_at', '>=', today())->count() }}</div>
                    </div>
                </div>
            </div>
        </div>

        @if($orders->count() > 0)
            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <i class="fas fa-hashtag mr-2 text-red-500"></i>Order ID
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <i class="fas fa-user mr-2 text-red-500"></i>Customer
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <i class="fas fa-box mr-2 text-red-500"></i>Items
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <i class="fas fa-money-bill-wave mr-2 text-red-500"></i>Total
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <i class="fas fa-flag mr-2 text-red-500"></i>Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <i class="fas fa-calendar mr-2 text-red-500"></i>Tanggal
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <i class="fas fa-cogs mr-2 text-red-500"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <tr class="hover:bg-red-50">
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="bg-red-100 p-2 rounded-lg mr-3">
                                            <i class="fas fa-shopping-bag text-red-600"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900">#{{ $order->id }}</div>
                                            <div class="text-xs text-gray-500">{{ $order->orderDetails ? $order->orderDetails->count() : 0 }} item(s)</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <div class="h-12 w-12 rounded-full bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center shadow-lg">
                                                <span class="text-white font-bold text-lg">
                                                    {{ $order->user ? substr($order->user->name, 0, 1) : 'U' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $order->user->name ?? 'Unknown User' }}</div>
                                            <div class="text-xs text-gray-500">{{ $order->user->email ?? 'No email' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="max-w-xs">
                                        @if($order->orderDetails && $order->orderDetails->count() > 0)
                                            @foreach($order->orderDetails->take(2) as $detail)
                                                <div class="mb-2 bg-gray-50 rounded-lg p-2">
                                                    <div class="text-sm font-medium text-gray-900">{{ $detail->sparepart->name ?? 'Unknown Item' }}</div>
                                                    <div class="text-xs text-gray-500 flex items-center">
                                                        <i class="fas fa-cube mr-1"></i>
                                                        Qty: {{ $detail->quantity ?? 0 }}x
                                                        <span class="ml-2 text-red-600 font-medium">
                                                            Rp{{ number_format($detail->subtotal ?? 0, 0, ',', '.') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if($order->orderDetails->count() > 2)
                                                <div class="text-xs text-gray-500 bg-yellow-50 rounded-lg p-2 text-center">
                                                    <i class="fas fa-plus-circle mr-1"></i>
                                                    +{{ $order->orderDetails->count() - 2 }} item lainnya
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-xs text-gray-500">No items</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="bg-green-50 rounded-xl p-3 text-center border border-green-200">
                                        <div class="text-lg font-bold text-green-700">
                                            Rp{{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                                        </div>
                                        <div class="text-xs text-green-600">Total Bayar</div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['bg-yellow-100 border-yellow-200', 'text-yellow-800', 'fa-clock', 'Menunggu Bayar'],
                                            'paid' => ['bg-green-100 border-green-200', 'text-green-800', 'fa-money-bill', 'Sudah Dibayar'],
                                            'shipped' => ['bg-indigo-100 border-indigo-200', 'text-indigo-800', 'fa-truck', 'Dikirim'],
                                            'delivered' => ['bg-blue-100 border-blue-200', 'text-blue-800', 'fa-check-double', 'Selesai'],
                                            'canceled' => ['bg-red-100 border-red-200', 'text-red-800', 'fa-times-circle', 'Dibatalkan']
                                        ];
                                        $config = $statusConfig[$order->status ?? 'pending'] ?? ['bg-gray-100 border-gray-200', 'text-gray-800', 'fa-question', ucfirst($order->status ?? 'Unknown')];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-bold border {{ $config[0] }} {{ $config[1] }}">
                                        <i class="fas {{ $config[2] }} mr-2"></i>
                                        {{ $config[3] }}
                                    </span>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="text-center">
                                        <div class="text-sm font-medium text-gray-900">{{ $order->created_at ? $order->created_at->format('d M Y') : 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $order->created_at ? $order->created_at->format('H:i') : '' }} WIB</div>
                                        <div class="text-xs text-gray-400 mt-1">{{ $order->created_at ? $order->created_at->diffForHumans() : '' }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                                           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-medium shadow-lg">
                                            <i class="fas fa-eye mr-2"></i>Detail
                                        </a>
                                        @if(($order->status ?? 'pending') !== 'delivered' && ($order->status ?? 'pending') !== 'canceled')
                                            <button onclick="openUpdateStatusModal({{ $order->id }}, '{{ $order->status ?? 'pending' }}')" 
                                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-medium shadow-lg">
                                                <i class="fas fa-edit mr-2"></i>Update
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden">
                @foreach($orders as $order)
                    <div class="border-b border-gray-200 p-4 hover:bg-gray-50">
                        <!-- Header Card Mobile -->
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="bg-red-100 p-2 rounded-lg">
                                    <i class="fas fa-shopping-bag text-red-600"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900">#{{ $order->id }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->orderDetails ? $order->orderDetails->count() : 0 }} item(s)</div>
                                </div>
                            </div>
                            @php
                                $statusConfig = [
                                    'pending' => ['bg-yellow-100 border-yellow-200', 'text-yellow-800', 'fa-clock', 'Menunggu Bayar'],
                                    'paid' => ['bg-green-100 border-green-200', 'text-green-800', 'fa-money-bill', 'Sudah Dibayar'],
                                    'shipped' => ['bg-indigo-100 border-indigo-200', 'text-indigo-800', 'fa-truck', 'Dikirim'],
                                    'delivered' => ['bg-blue-100 border-blue-200', 'text-blue-800', 'fa-check-double', 'Selesai'],
                                    'canceled' => ['bg-red-100 border-red-200', 'text-red-800', 'fa-times-circle', 'Dibatalkan']
                                ];
                                $config = $statusConfig[$order->status ?? 'pending'] ?? ['bg-gray-100 border-gray-200', 'text-gray-800', 'fa-question', ucfirst($order->status ?? 'Unknown')];
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold border {{ $config[0] }} {{ $config[1] }}">
                                <i class="fas {{ $config[2] }} mr-1"></i>
                                {{ $config[3] }}
                            </span>
                        </div>

                        <!-- Customer Info -->
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-red-500 to-red-600 flex items-center justify-center shadow-lg">
                                    <span class="text-white font-bold text-sm">
                                        {{ $order->user ? substr($order->user->name, 0, 1) : 'U' }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-bold text-gray-900 truncate">{{ $order->user->name ?? 'Unknown User' }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ $order->user->email ?? 'No email' }}</div>
                            </div>
                        </div>

                        <!-- Items -->
                        <div class="mb-3">
                            <div class="text-xs font-medium text-gray-700 mb-2">Items:</div>
                            @if($order->orderDetails && $order->orderDetails->count() > 0)
                                @foreach($order->orderDetails->take(2) as $detail)
                                    <div class="mb-1 bg-gray-50 rounded-lg p-2">
                                        <div class="text-sm font-medium text-gray-900">{{ $detail->sparepart->name ?? 'Unknown Item' }}</div>
                                        <div class="text-xs text-gray-500 flex items-center justify-between">
                                            <span>
                                                <i class="fas fa-cube mr-1"></i>
                                                Qty: {{ $detail->quantity ?? 0 }}x
                                            </span>
                                            <span class="text-red-600 font-medium">
                                                Rp{{ number_format($detail->subtotal ?? 0, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                                @if($order->orderDetails->count() > 2)
                                    <div class="text-xs text-gray-500 bg-yellow-50 rounded-lg p-2 text-center">
                                        <i class="fas fa-plus-circle mr-1"></i>
                                        +{{ $order->orderDetails->count() - 2 }} item lainnya
                                    </div>
                                @endif
                            @else
                                <div class="text-xs text-gray-500">No items</div>
                            @endif
                        </div>

                        <!-- Total & Date -->
                        <div class="flex items-center justify-between mb-3">
                            <div class="bg-green-50 rounded-lg p-2 border border-green-200">
                                <div class="text-sm font-bold text-green-700">
                                    Rp{{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-green-600">Total Bayar</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-medium text-gray-900">{{ $order->created_at ? $order->created_at->format('d M Y') : 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $order->created_at ? $order->created_at->format('H:i') : '' }} WIB</div>
                            </div>
                        </div>

                        <!-- Action Buttons Mobile -->
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                               class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-medium text-center">
                                <i class="fas fa-eye mr-1"></i>Detail
                            </a>
                            @if(($order->status ?? 'pending') !== 'delivered' && ($order->status ?? 'pending') !== 'canceled')
                                <button onclick="openUpdateStatusModal({{ $order->id }}, '{{ $order->status ?? 'pending' }}')" 
                                        class="flex-1 bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg text-sm font-medium">
                                    <i class="fas fa-edit mr-1"></i>Update
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="bg-gray-50 px-4 sm:px-6 py-4 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-2 sm:space-y-0">
                        <div class="text-sm text-gray-700 text-center sm:text-left">
                            Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }} dari {{ $orders->total() }} order
                        </div>
                        <div class="flex justify-center">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-12 sm:py-20 px-4">
                <div class="relative">
                    <div class="bg-red-100 rounded-full p-8 sm:p-12 w-32 h-32 sm:w-40 sm:h-40 mx-auto mb-6 sm:mb-8 flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-red-400 text-4xl sm:text-6xl"></i>
                    </div>
                </div>
                <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">Belum Ada Order Sparepart</h3>
                <p class="text-gray-600 mb-6 sm:mb-8 max-w-md mx-auto text-sm sm:text-base">
                    Saat ini belum ada order sparepart dari pelanggan. Order baru akan muncul di sini ketika pelanggan melakukan pemesanan.
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('admin.spareparts.index') }}" 
                       class="bg-red-600 hover:bg-red-700 text-white px-4 sm:px-6 py-3 rounded-xl font-medium shadow-lg">
                        <i class="fas fa-cogs mr-2"></i>Kelola Sparepart
                    </a>
                    <button onclick="window.location.reload()" 
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 sm:px-6 py-3 rounded-xl font-medium shadow-lg">
                        <i class="fas fa-refresh mr-2"></i>Refresh
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal Update Status -->
<div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Update Status Order</h3>
                <button onclick="closeUpdateStatusModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="updateStatusForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                    <select id="statusSelect" name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option value="pending">
                            <i class="fas fa-clock"></i> Menunggu Pembayaran
                        </option>
                        <option value="paid">
                            <i class="fas fa-check-circle"></i> Sudah Dibayar
                        </option>
                        <option value="shipped">
                            <i class="fas fa-truck"></i> Dalam Pengiriman
                        </option>
                        <option value="delivered">
                            <i class="fas fa-check-double"></i> Selesai/Diterima
                        </option>
                        <option value="canceled">
                            <i class="fas fa-times-circle"></i> Dibatalkan
                        </option>
                    </select>
                    
                    <!-- Status Info -->
                    <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                        <div class="text-xs text-gray-600">
                            <div class="grid grid-cols-2 gap-2">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-yellow-300 rounded-full mr-2"></div>
                                    <span>Menunggu Pembayaran</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-400 rounded-full mr-2"></div>
                                    <span>Sudah Dibayar</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-indigo-400 rounded-full mr-2"></div>
                                    <span>Dalam Pengiriman</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-blue-400 rounded-full mr-2"></div>
                                    <span>Selesai</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-red-400 rounded-full mr-2"></div>
                                    <span>Dibatalkan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex space-x-4">
                    <button type="button" onclick="closeUpdateStatusModal()" 
                            class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openUpdateStatusModal(orderId, currentStatus) {
    document.getElementById('statusModal').classList.remove('hidden');
    document.getElementById('updateStatusForm').action = `/admin/orders/${orderId}/status`;
    document.getElementById('statusSelect').value = currentStatus;
}

function closeUpdateStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('statusModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeUpdateStatusModal();
    }
});
</script>

<style>
/* Mobile-first responsive styles */
@media (max-width: 1024px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}

.hover\:bg-red-50:hover {
    background-color: #fef2f2;
}

.hover\:bg-gray-50:hover {
    background-color: #f9fafb;
}

.bg-blue-500:hover { 
    background-color: #2563eb; 
}

.bg-green-500:hover { 
    background-color: #16a34a; 
}

.bg-red-600:hover { 
    background-color: #dc2626; 
}

.bg-gray-500:hover { 
    background-color: #6b7280; 
}

/* Responsive table scroll */
@media (max-width: 768px) {
    .overflow-x-auto {
        -webkit-overflow-scrolling: touch;
    }
}
</style>
@endsection