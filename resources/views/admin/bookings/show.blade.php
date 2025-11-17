{{-- filepath: c:\laragon\www\wep_Kape\resources\views\admin\bookings\show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Booking')

@section('content')
<div class="min-h-screen bg-theme-secondary py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.bookings') }}" class="bg-gray-500 hover:bg-gray-600 text-white p-2 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-theme-primary">Detail Booking #{{ $booking->id }}</h1>
                    <p class="text-theme-secondary">Informasi lengkap booking servis</p>
                </div>
            </div>
        </div>

        <!-- Booking Detail -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Customer Info -->
            <div class="bg-theme-primary rounded-2xl shadow-xl border border-theme p-6">
                <h3 class="text-xl font-bold text-theme-primary mb-4 flex items-center">
                    <i class="fas fa-user mr-3 text-blue-600"></i>
                    Informasi Customer
                </h3>
                
                <div class="space-y-4">
                    @if($booking->user)
                        <div>
                            <label class="text-sm font-medium text-theme-secondary">Nama:</label>
                            <div class="text-lg font-bold text-theme-primary">{{ $booking->user->name }}</div>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-theme-secondary">Email:</label>
                            <div class="text-lg text-theme-primary">{{ $booking->user->email }}</div>
                        </div>
                        
                        @if($booking->user->phone)
                        <div>
                            <label class="text-sm font-medium text-theme-secondary">Telepon:</label>
                            <div class="text-lg text-theme-primary">{{ $booking->user->phone }}</div>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-user-slash text-gray-400 text-4xl mb-4"></i>
                            <p class="text-theme-secondary">Customer tidak ditemukan</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Booking Info -->
            <div class="bg-theme-primary rounded-2xl shadow-xl border border-theme p-6">
                <h3 class="text-xl font-bold text-theme-primary mb-4 flex items-center">
                    <i class="fas fa-calendar mr-3 text-green-600"></i>
                    Informasi Booking
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-theme-secondary">User ID:</label>
                        <div class="text-lg font-bold text-theme-primary">{{ $booking->user_id }}</div>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-theme-secondary">Tanggal Booking:</label>
                        <div class="text-lg text-theme-primary">
                            {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d F Y, H:i') : 'Tidak tersedia' }} WIB
                        </div>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-theme-secondary">Tanggal Dibuat:</label>
                        <div class="text-lg text-theme-primary">
                            {{ $booking->created_at ? \Carbon\Carbon::parse($booking->created_at)->format('d F Y, H:i') : 'Tidak tersedia' }} WIB
                        </div>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-theme-secondary">Status:</label>
                        <div class="mt-2">
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
                            <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full {{ $statusClasses[$booking->status ?? 'pending'] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusText[$booking->status ?? 'pending'] ?? 'Unknown' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        @if(($booking->status ?? 'pending') === 'pending')
        <div class="mt-8">
            <div class="bg-theme-primary rounded-2xl shadow-xl border border-theme p-6">
                <h3 class="text-xl font-bold text-theme-primary mb-4">Aksi Booking</h3>
                <div class="flex space-x-4">
                    <button onclick="updateStatus({{ $booking->id }}, 'confirmed')" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition-colors font-medium">
                        <i class="fas fa-check mr-2"></i>Konfirmasi Booking
                    </button>
                    <button onclick="updateStatus({{ $booking->id }}, 'cancelled')" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg transition-colors font-medium">
                        <i class="fas fa-times mr-2"></i>Batalkan Booking
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function updateStatus(bookingId, status) {
    if (confirm('Yakin ingin mengubah status booking ini?')) {
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
                alert('Status berhasil diupdate!');
                location.reload();
            } else {
                alert('Gagal mengubah status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection