@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    {{-- Header Section --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                Selamat Datang, <span class="text-red-600">Admin!</span>
            </h1>
            <p class="text-gray-600">Berikut adalah ringkasan aktivitas sistem Harum Motor</p>
        </div>
        <div class="hidden md:block">
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 rounded-xl shadow-lg">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="font-medium">{{ now()->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Booking Card --}}
        <div class="group bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border-l-4 border-blue-500 overflow-hidden">
            <div class="p-6 relative">
                <div class="absolute top-0 right-0 w-16 h-16 bg-blue-50 rounded-bl-full"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-1">Total Booking</h3>
                        <p class="text-3xl font-bold text-blue-600 group-hover:scale-110 transition-transform">
                            {{ $bookingCount ?? 0 }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">Booking servis</p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-4 rounded-2xl group-hover:rotate-12 transition-transform">
                        <i class="fas fa-calendar-check text-white text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Order Card --}}
        <div class="group bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border-l-4 border-green-500 overflow-hidden">
            <div class="p-6 relative">
                <div class="absolute top-0 right-0 w-16 h-16 bg-green-50 rounded-bl-full"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-1">Total Order</h3>
                        <p class="text-3xl font-bold text-green-600 group-hover:scale-110 transition-transform">
                            {{ $orderCount ?? 0 }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">Order sparepart</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-500 to-green-600 p-4 rounded-2xl group-hover:rotate-12 transition-transform">
                        <i class="fas fa-shopping-cart text-white text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Review Card --}}
        <div class="group bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border-l-4 border-yellow-500 overflow-hidden">
            <div class="p-6 relative">
                <div class="absolute top-0 right-0 w-16 h-16 bg-yellow-50 rounded-bl-full"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-1">Total Review</h3>
                        <p class="text-3xl font-bold text-yellow-600 group-hover:scale-110 transition-transform">
                            {{ $reviewCount ?? 0 }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">Ulasan pelanggan</p>
                    </div>
                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 p-4 rounded-2xl group-hover:rotate-12 transition-transform">
                        <i class="fas fa-star text-white text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Invoice Card --}}
        <div class="group bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 border-l-4 border-purple-500 overflow-hidden">
            <div class="p-6 relative">
                <div class="absolute top-0 right-0 w-16 h-16 bg-purple-50 rounded-bl-full"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-1">Total Invoice</h3>
                        <p class="text-3xl font-bold text-purple-600 group-hover:scale-110 transition-transform">
                            {{ $invoiceCount ?? 0 }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">Invoice tagihan</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-4 rounded-2xl group-hover:rotate-12 transition-transform">
                        <i class="fas fa-file-invoice text-white text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Activity Section --}}
    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-clock text-red-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Aktivitas Terbaru</h2>
                    <p class="text-gray-600">Booking terbaru dari pelanggan</p>
                </div>
            </div>
            <div class="hidden sm:flex items-center space-x-2 bg-gray-100 px-4 py-2 rounded-full">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-sm font-medium text-gray-700">Live Updates</span>
            </div>
        </div>

        @if(isset($recentBookings) && $recentBookings->count() > 0)
            <div class="space-y-4">
                @foreach ($recentBookings as $index => $booking)
                    <div class="group flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all duration-200 border border-gray-200 hover:border-gray-300">
                        <div class="flex items-center space-x-4">
                            <div class="bg-gradient-to-br from-red-500 to-red-600 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="bg-blue-100 p-2 rounded-lg group-hover:bg-blue-200 transition-colors">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">
                                        {{ $booking->user->name ?? 'Tidak Diketahui' }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Booking untuk tanggal {{ $booking->booking_date ? $booking->booking_date->format('d M Y') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-medium text-gray-700">
                                {{ $booking->created_at ? \Carbon\Carbon::parse($booking->created_at)->format('d M Y') : '-' }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $booking->created_at ? \Carbon\Carbon::parse($booking->created_at)->format('H:i') : '-' }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-12">
                <div class="bg-gray-100 rounded-full p-6 w-24 h-24 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Aktivitas</h3>
                <p class="text-gray-600">Aktivitas booking terbaru akan muncul di sini</p>
            </div>
        @endif
    </div>
</div>

{{-- Custom Styles --}}
<style>
    /* Enhanced hover effects */
    .group:hover .group-hover\:scale-110 {
        transform: scale(1.1);
    }
    
    .group:hover .group-hover\:rotate-12 {
        transform: rotate(12deg);
    }
</style>
@endsection