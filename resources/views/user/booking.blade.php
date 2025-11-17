{{-- filepath: resources/views/user/booking.blade.php --}}
@extends('layouts.user')

@section('title', 'Booking Service')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Booking Service</h1>
                <p class="text-lg text-gray-600">Jadwalkan service kendaraan Anda</p>
            </div>

            <!-- Alert Messages -->
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

            @if (session('error'))
                <div class="mb-6 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-xl shadow-lg p-4">
                    <div class="flex items-center">
                        <div class="bg-red-500 p-2 rounded-full mr-4">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-red-900">Error!</div>
                            <div class="text-red-700">{{ session('error') }}</div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-xl shadow-lg p-4">
                    <div class="flex items-center mb-2">
                        <div class="bg-red-500 p-2 rounded-full mr-4">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                        <div class="font-semibold text-red-900">Validation Error!</div>
                    </div>
                    <ul class="text-red-700 ml-12">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Booking Form -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                <div class="p-8">
                    <!-- PASTIKAN ACTION DAN METHOD BENAR -->
                    <form action="{{ route('user.booking.store') }}" method="POST">
                        @csrf
                        
                        <!-- Booking Date -->
                        <div class="mb-6">
                            <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar mr-2 text-red-500"></i>
                                Tanggal Booking
                            </label>
                            <input type="date" 
                                   id="booking_date" 
                                   name="booking_date" 
                                   value="{{ old('booking_date') }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent @error('booking_date') border-red-500 @enderror"
                                   required>
                            @error('booking_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes (Optional) -->
                        <div class="mb-8">
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-sticky-note mr-2 text-red-500"></i>
                                Catatan (Opsional)
                            </label>
                            <textarea id="notes" 
                                      name="notes" 
                                      rows="4" 
                                      placeholder="Deskripsikan keluhan atau kebutuhan service Anda..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button type="submit" 
                                    class="flex-1 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white py-4 px-8 rounded-xl font-bold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                                <i class="fas fa-calendar-check mr-2"></i>
                                Submit Booking
                            </button>
                            <a href="{{ route('user.mybookings') }}" 
                               class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-4 px-8 rounded-xl font-bold transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl text-center">
                                <i class="fas fa-list mr-2"></i>
                                Lihat Booking
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Section -->
            <div class="mt-8 bg-blue-50 rounded-2xl p-6 border border-blue-200">
                <div class="flex items-start">
                    <div class="bg-blue-500 p-2 rounded-full mr-4 mt-1">
                        <i class="fas fa-info text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-blue-900 mb-2">Informasi Penting:</h3>
                        <ul class="text-blue-800 space-y-1">
                            <li>• Booking minimal H+1 dari hari ini</li>
                            <li>• Admin akan menghubungi Anda untuk konfirmasi jadwal</li>
                            <li>• Estimasi waktu service: 1-3 jam tergantung jenis service</li>
                            <li>• Bawa dokumen kendaraan saat datang service</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Set minimum date to tomorrow
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    const dateInput = document.getElementById('booking_date');
    dateInput.min = tomorrow.toISOString().split('T')[0];
});

// Form submission loading
document.querySelector('form').addEventListener('submit', function(e) {
    const submitBtn = document.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
    submitBtn.disabled = true;
});
</script>
@endsection