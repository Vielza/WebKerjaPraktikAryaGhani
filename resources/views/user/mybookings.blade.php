@extends('layouts.user')

@section('title', 'My Bookings')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">My Bookings</h1>
                <p class="text-lg text-gray-600">Riwayat booking service Anda</p>
            </div>

            @if (session('success'))
                <div class="mb-6 bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 rounded-xl shadow-lg p-4">
                    <div class="flex items-center">
                        <div class="bg-green-500 p-2 rounded-full mr-4">
                            <i class="fas fa-check text-white"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-green-900">Berhasil!</div>
                            <div class="text-green-700">{{ session('success') }}</div>
                        </div>
                    </div>
                </div>
            @endif

            @if($bookings->count() > 0)
                <div class="space-y-4">
                    @foreach($bookings as $booking)
                        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">Booking #{{ $booking->id }}</h3>
                                        <p class="text-gray-600">{{ $booking->booking_date->format('d F Y') }}</p>
                                        <p class="text-sm text-gray-500">Dibuat: {{ \Carbon\Carbon::parse($booking->created_at)->format('d F Y, H:i') }}</p>
                                    </div>
                                    <div>
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'confirmed' => 'bg-blue-100 text-blue-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'canceled' => 'bg-red-100 text-red-800'
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <div class="bg-gray-100 rounded-full p-8 w-32 h-32 mx-auto mb-6 flex items-center justify-center">
                        <i class="fas fa-calendar-times text-gray-400 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Belum Ada Booking</h3>
                    <p class="text-gray-600 mb-8">Anda belum memiliki booking service</p>
                    <a href="{{ route('user.booking') }}" 
                       class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white py-3 px-8 rounded-xl font-bold transition-all duration-200">
                        <i class="fas fa-calendar-plus mr-2"></i>
                        Book Service
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection