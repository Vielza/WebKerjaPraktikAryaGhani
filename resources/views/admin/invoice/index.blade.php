@extends('layouts.admin')

@section('title', 'Customer Management')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">👥 Customer Management</h1>
                <p class="text-blue-100">Kelola data customer dan riwayat aktivitas mereka</p>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold">{{ $invoices->count() }}</div>
                <div class="text-blue-100">Total Customer</div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex flex-col lg:flex-row gap-4 items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Daftar Customer</h2>
            
            <!-- Filters -->
            <div class="flex flex-wrap gap-3">
                <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="active">Active</option>
                    <option value="vip">VIP Member</option>
                    <option value="inactive">Inactive</option>
                </select>
                
                <input type="text" id="searchInput" placeholder="Cari customer..." 
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                
                <button onclick="exportCustomers()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-download mr-2"></i>Export
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg p-4 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">Total Customer</p>
                        <p class="text-2xl font-bold">{{ $totalUsers ?? 0 }}</p>
                    </div>
                    <i class="fas fa-users text-3xl text-blue-200"></i>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-purple-400 to-purple-600 rounded-lg p-4 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm">VIP Members</p>
                        <p class="text-2xl font-bold">{{ $vipUsers ?? 0 }}</p>
                    </div>
                    <i class="fas fa-crown text-3xl text-purple-200"></i>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-green-400 to-green-600 rounded-lg p-4 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">Active Users</p>
                        <p class="text-2xl font-bold">{{ $activeUsers ?? 0 }}</p>
                    </div>
                    <i class="fas fa-user-check text-3xl text-green-200"></i>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-orange-400 to-orange-600 rounded-lg p-4 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm">Total Transaksi</p>
                        <p class="text-2xl font-bold">{{ $invoices->sum('total_transactions') ?? 0 }}</p>
                    </div>
                    <i class="fas fa-chart-line text-3xl text-orange-200"></i>
                </div>
            </div>
        </div>

        <!-- Customer Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Customer
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact Info
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Member Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Activity Summary
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Last Activity
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="customerTableBody">
                    @forelse ($invoices as $customer)
                        <tr class="hover:bg-gray-50 transition-colors customer-row" 
                            data-status="{{ $customer->status ?? 'active' }}">
                            
                            <!-- Customer Info -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <div class="h-12 w-12 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold text-lg">
                                            {{ strtoupper(substr($customer->customer_name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">
                                            {{ $customer->customer_name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            ID: {{ $customer->invoice_number ?? 'USR-' . str_pad($customer->id, 6, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            Member sejak {{ $customer->created_at->format('M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Contact Info -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <div class="flex items-center mb-1">
                                        <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                        {{ $customer->customer_email }}
                                    </div>
                                    @if($customer->customer_phone !== 'N/A')
                                        <div class="flex items-center">
                                            <i class="fas fa-phone text-gray-400 mr-2"></i>
                                            {{ $customer->customer_phone }}
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Member Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col space-y-1">
                                    @php
                                        $statusConfig = [
                                            'active' => ['class' => 'bg-green-100 text-green-800', 'icon' => 'fa-check-circle', 'text' => 'Active Member'],
                                            'inactive' => ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'fa-pause-circle', 'text' => 'Inactive'],
                                            'vip' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fa-crown', 'text' => 'VIP Member'],
                                        ];
                                        $config = $statusConfig[$customer->status] ?? $statusConfig['active'];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['class'] }}">
                                        <i class="fas {{ $config['icon'] }} mr-1"></i>
                                        {{ $config['text'] }}
                                    </span>
                                    
                                    @if(isset($customer->total_transactions) && $customer->total_transactions >= 10)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-star mr-1"></i>
                                            Loyal Customer
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Activity Summary -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    <div class="font-medium mb-1">
                                        {{ $customer->total_transactions ?? 0 }} Total Aktivitas
                                    </div>
                                    
                                    @if(isset($customer->booking_count) && $customer->booking_count > 0)
                                        <div class="flex items-center text-blue-600 text-xs mb-1">
                                            <i class="fas fa-wrench mr-1"></i>
                                            {{ $customer->booking_count }} Service Booking
                                        </div>
                                    @endif
                                    
                                    @if(isset($customer->sparepart_count) && $customer->sparepart_count > 0)
                                        <div class="flex items-center text-purple-600 text-xs">
                                            <i class="fas fa-cog mr-1"></i>
                                            {{ $customer->sparepart_count }} Pembelian Sparepart
                                        </div>
                                    @endif
                                    
                                    @if((!isset($customer->booking_count) || $customer->booking_count == 0) && (!isset($customer->sparepart_count) || $customer->sparepart_count == 0))
                                        <div class="text-xs text-gray-400">
                                            <i class="fas fa-clock mr-1"></i>
                                            Belum ada aktivitas
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Last Activity -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                    <div>
                                        <div>{{ $customer->created_at->format('d M Y') }}</div>
                                        <div class="text-xs">{{ $customer->created_at->format('H:i') }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.invoices.show', $customer->id) }}" 
                                       class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded-lg text-xs transition-colors"
                                       title="Lihat Detail & Riwayat">
                                        <i class="fas fa-eye mr-1"></i>
                                        Detail
                                    </a>
                                    
                                    <button onclick="sendNotification({{ $customer->id }})" 
                                            class="bg-purple-100 hover:bg-purple-200 text-purple-700 px-3 py-1 rounded-lg text-xs transition-colors"
                                            title="Kirim Notifikasi">
                                        <i class="fas fa-bell"></i>
                                    </button>
                                    
                                    <div class="relative group">
                                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-lg text-xs transition-colors">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 hidden group-hover:block">
                                            <div class="py-1">
                                                <button onclick="printCustomerReport({{ $customer->id }})" 
                                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="fas fa-print mr-2"></i>Print Report
                                                </button>
                                                <button onclick="exportCustomerData({{ $customer->id }})" 
                                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="fas fa-download mr-2"></i>Export Data
                                                </button>
                                                <button onclick="updateCustomerStatus({{ $customer->id }})" 
                                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="fas fa-edit mr-2"></i>Update Status
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada customer</h3>
                                    <p class="text-gray-500">Customer akan muncul di sini setelah mereka melakukan registrasi dan aktivitas.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(method_exists($invoices, 'hasPages') && $invoices->hasPages())
            <div class="mt-6">
                {{ $invoices->links() }}
            </div>
        @endif
    </div>
</div>

<script>
// Filter Functions
document.getElementById('statusFilter').addEventListener('change', filterCustomers);
document.getElementById('searchInput').addEventListener('input', filterCustomers);

function filterCustomers() {
    const statusFilter = document.getElementById('statusFilter').value;
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('.customer-row');

    rows.forEach(row => {
        const status = row.dataset.status;
        const text = row.textContent.toLowerCase();

        const matchesStatus = !statusFilter || status === statusFilter;
        const matchesSearch = !searchTerm || text.includes(searchTerm);

        row.style.display = matchesStatus && matchesSearch ? '' : 'none';
    });
}

// Action Functions
function sendNotification(customerId) {
    if (confirm('Kirim notifikasi ke customer ini?')) {
        fetch(`/admin/invoices/${customerId}/send`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.success ? 'Notifikasi berhasil dikirim!' : 'Gagal mengirim notifikasi: ' + data.message);
        });
    }
}

function printCustomerReport(customerId) {
    window.open(`/admin/invoices/${customerId}/print`, '_blank');
}

function exportCustomerData(customerId) {
    window.location.href = `/admin/invoices/export?customer=${customerId}`;
}

function updateCustomerStatus(customerId) {
    // Implementasi update status customer
    alert('Fitur update status customer akan segera tersedia');
}

function exportCustomers() {
    const statusFilter = document.getElementById('statusFilter').value;
    const params = new URLSearchParams();
    
    if (statusFilter) params.append('status', statusFilter);
    
    window.location.href = `/admin/invoices/export?${params.toString()}`;
}
</script>

<style>
.group:hover .group-hover\:block {
    display: block !important;
}

.relative .group-hover\:block {
    display: none;
}

.group:hover .group-hover\:block {
    display: block !important;
}
</style>
@endsection