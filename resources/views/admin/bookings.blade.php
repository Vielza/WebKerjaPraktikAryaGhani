{{-- filepath: c:\laragon\www\wep_Kape\resources\views\admin\bookings\index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Data Booking')

@section('content')
<div class="min-h-screen bg-theme-secondary py-8">
    <div class="container mx-auto px-4">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="bg-theme-primary rounded-2xl shadow-xl border border-theme p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div>
                        <h1 class="text-3xl font-bold text-theme-primary">Data Booking Servis</h1>
                        <p class="text-theme-secondary mt-2">Kelola semua booking servis pelanggan</p>
                    </div>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 px-4 py-2 rounded-xl border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-calendar-check text-blue-600 dark:text-blue-400"></i>
                                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">
                                    Total: {{ $stats['total'] }} Booking
                                </span>
                            </div>
                        </div>
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 px-4 py-2 rounded-xl border border-yellow-200 dark:border-yellow-800">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                                <span class="text-sm font-medium text-yellow-700 dark:text-yellow-300">
                                    Pending: {{ $stats['pending'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="mb-6">
            <div class="bg-theme-primary rounded-xl shadow-lg border border-theme p-4">
                <form method="GET" action="{{ route('admin.bookings') }}" class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari nama atau email customer..." 
                               class="form-input rounded-lg border-theme text-sm bg-theme-primary text-theme-primary">
                        
                        <select name="status" class="form-input rounded-lg border-theme text-sm bg-theme-primary text-theme-primary">
                            <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        
                        <input type="date" 
                               name="date" 
                               value="{{ request('date') }}"
                               class="form-input rounded-lg border-theme text-sm bg-theme-primary text-theme-primary">
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                        <a href="{{ route('admin.bookings') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-sm font-medium">
                            <i class="fas fa-refresh mr-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats Cards for Mobile -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 lg:hidden">
            <div class="bg-theme-primary rounded-xl p-4 border border-theme">
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
                    <div class="text-xs text-theme-secondary">Pending</div>
                </div>
            </div>
            <div class="bg-theme-primary rounded-xl p-4 border border-theme">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['confirmed'] }}</div>
                    <div class="text-xs text-theme-secondary">Confirmed</div>
                </div>
            </div>
            <div class="bg-theme-primary rounded-xl p-4 border border-theme">
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $stats['in_progress'] }}</div>
                    <div class="text-xs text-theme-secondary">Progress</div>
                </div>
            </div>
            <div class="bg-theme-primary rounded-xl p-4 border border-theme">
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</div>
                    <div class="text-xs text-theme-secondary">Completed</div>
                </div>
            </div>
        </div>

        <!-- Cards for Mobile -->
        <div class="space-y-4 mb-8 lg:hidden">
            @forelse ($bookings as $index => $booking)
                <div class="bg-theme-primary rounded-xl shadow-lg border border-theme overflow-hidden booking-card" data-index="{{ $index }}">
                    <div class="p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center">
                                <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg mr-3">
                                    <i class="fas fa-user text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-theme-primary">
                                        {{ $booking->user ? $booking->user->name : 'Customer tidak ditemukan' }}
                                    </h3>
                                    <p class="text-xs text-theme-secondary">
                                        {{ $booking->user ? $booking->user->email : 'Email tidak tersedia' }}
                                    </p>
                                </div>
                            </div>
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                    'confirmed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                    'in_progress' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
                                    'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                    'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                ];
                                $statusText = [
                                    'pending' => 'Menunggu',
                                    'confirmed' => 'Dikonfirmasi',
                                    'in_progress' => 'Sedang Dikerjakan',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan'
                                ];
                            @endphp
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$booking->status ?? 'pending'] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusText[$booking->status ?? 'pending'] ?? 'Unknown' }}
                            </span>
                        </div>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between">
                                <span class="text-xs text-theme-secondary">User ID:</span>
                                <span class="text-xs font-medium text-theme-primary">{{ $booking->user_id ?? 'Tidak tersedia' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-xs text-theme-secondary">Tanggal Booking:</span>
                                <span class="text-xs font-medium text-theme-primary">
                                    {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d M Y H:i') : 'Tidak tersedia' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-xs text-theme-secondary">Tanggal Dibuat:</span>
                                <span class="text-xs font-medium text-theme-primary">
                                    {{ $booking->created_at ? \Carbon\Carbon::parse($booking->created_at)->format('d M Y H:i') : 'Tidak tersedia' }}
                                </span>
                            </div>
                            @if($booking->user && $booking->user->phone)
                            <div class="flex justify-between">
                                <span class="text-xs text-theme-secondary">Telepon:</span>
                                <span class="text-xs font-medium text-theme-primary">{{ $booking->user->phone }}</span>
                            </div>
                            @endif
                        </div>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-lg transition-colors text-sm font-medium text-center">
                                <i class="fas fa-eye mr-1"></i>Detail
                            </a>
                            @if(($booking->status ?? 'pending') === 'pending')
                                <button onclick="updateStatus({{ $booking->id }}, 'confirmed')" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded-lg transition-colors text-sm font-medium">
                                    <i class="fas fa-check mr-1"></i>Konfirmasi
                                </button>
                                <button onclick="updateStatus({{ $booking->id }}, 'cancelled')" class="bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded-lg transition-colors text-sm font-medium">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-theme-primary rounded-xl shadow-lg border border-theme p-12 text-center">
                    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-full mb-4 w-16 h-16 mx-auto flex items-center justify-center">
                        <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-theme-primary mb-2">Tidak ada booking</h3>
                    <p class="text-theme-secondary">Belum ada booking servis yang masuk.</p>
                </div>
            @endforelse
        </div>

        <!-- Table for Desktop -->
        <div class="hidden lg:block bg-theme-primary rounded-2xl shadow-xl border border-theme overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full" id="bookingsTable">
                    <thead class="bg-gray-50 dark:bg-gray-800 border-b border-theme">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-theme-secondary uppercase tracking-wider">
                                #
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-theme-secondary uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-theme-secondary uppercase tracking-wider">
                                User ID
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-theme-secondary uppercase tracking-wider">
                                Tanggal Booking
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-theme-secondary uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-theme-secondary uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($bookings as $index => $booking)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200 booking-row" data-index="{{ $index }}">
                                <!-- Number -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-theme-primary">{{ $index + 1 }}</div>
                                </td>

                                <!-- Customer Info -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg mr-3">
                                            <i class="fas fa-user text-blue-600 dark:text-blue-400"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-theme-primary">
                                                {{ $booking->user ? $booking->user->name : 'Customer tidak ditemukan' }}
                                            </div>
                                            <div class="text-xs text-theme-secondary">
                                                {{ $booking->user ? $booking->user->email : 'Email tidak tersedia' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- User ID -->
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-theme-primary">
                                        {{ $booking->user_id ?? 'N/A' }}
                                    </div>
                                </td>

                                <!-- Booking Date -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-theme-primary">
                                        {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') : 'Tidak tersedia' }}
                                    </div>
                                    <div class="text-xs text-theme-secondary">
                                        {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('H:i') : '' }} WIB
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                            'confirmed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                            'in_progress' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
                                            'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                        ];
                                        $statusText = [
                                            'pending' => 'Menunggu',
                                            'confirmed' => 'Dikonfirmasi',
                                            'in_progress' => 'Sedang Dikerjakan',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan'
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$booking->status ?? 'pending'] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusText[$booking->status ?? 'pending'] ?? 'Unknown' }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" 
                                           class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-2 rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-105 group"
                                           title="Lihat Detail">
                                            <i class="fas fa-eye group-hover:scale-110 transition-transform"></i>
                                        </a>
                                        @if(($booking->status ?? 'pending') === 'pending')
                                            <button onclick="updateStatus({{ $booking->id }}, 'confirmed')" 
                                                    class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-2 rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-105 group"
                                                    title="Konfirmasi">
                                                <i class="fas fa-check group-hover:scale-110 transition-transform"></i>
                                            </button>
                                            <button onclick="updateStatus({{ $booking->id }}, 'cancelled')" 
                                                    class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white p-2 rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-105 group"
                                                    title="Batalkan">
                                                <i class="fas fa-times group-hover:scale-110 transition-transform"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-full mb-4">
                                            <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-theme-primary mb-2">Tidak ada booking</h3>
                                        <p class="text-theme-secondary">Belum ada booking servis yang masuk.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function updateStatus(bookingId, status) {
    if (confirm('Yakin ingin mengubah status booking ini?')) {
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        fetch(`/admin/bookings/${bookingId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Status booking berhasil diupdate!', 'success');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showToast('Gagal mengubah status booking', 'error');
                button.disabled = false;
                button.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan saat mengubah status', 'error');
            button.disabled = false;
            button.innerHTML = originalText;
        });
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
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 300);
    }, 3000);
}
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
