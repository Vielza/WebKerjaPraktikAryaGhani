@extends('layouts.admin')

@section('title', 'Review Pelanggan')

@section('content')
<div class="space-y-6">
    <!-- Debug Info -->
    

    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Review Pelanggan</h1>
            <p class="text-gray-600 mt-1">Kelola dan pantau ulasan dari pelanggan</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-4">
            <div class="flex items-center space-x-3">
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-star text-yellow-600 text-xl"></i>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Total Review</div>
                    <div class="font-bold text-2xl text-gray-900">{{ isset($reviews) ? $reviews->count() : '0' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Content -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4 text-white">
                    <div class="bg-white/20 p-3 rounded-full">
                        <i class="fas fa-comments text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">Daftar Review</h2>
                        <p class="text-yellow-100">Ulasan dan rating dari pelanggan</p>
                    </div>
                </div>
                @if(isset($reviews) && $reviews->count() > 0)
                    <div class="text-right text-white">
                        @php
                            $avgRating = $reviews->avg('rating');
                        @endphp
                        <div class="text-3xl font-bold">{{ number_format($avgRating, 1) }}</div>
                        <div class="text-yellow-100 text-sm">Rating Rata-rata</div>
                        <div class="flex text-yellow-200 mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $avgRating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if(isset($reviews) && $reviews->count() > 0)
            <div class="p-6">
                <!-- Review Cards -->
                <div class="space-y-4">
                    @foreach($reviews as $index => $review)
                        <div class="group bg-gray-50 hover:bg-yellow-50 rounded-xl p-6 border border-gray-200 hover:border-yellow-300 transition-all duration-200">
                            <!-- Debug per review -->
                            <div class="mb-3 p-3 bg-gray-100 rounded text-xs">
                                <strong>Debug Review #{{ $index + 1 }}:</strong><br>
                                ID: {{ $review->id ?? 'null' }}<br>
                                User ID: {{ $review->user_id ?? 'null' }} 
                                @if(isset($review->user))
                                    ({{ $review->user->name }})
                                @else
                                    (User not found)
                                @endif<br>
                                Sparepart ID: {{ $review->sparepart_id ?? 'null' }}
                                @if(isset($review->sparepart))
                                    ({{ $review->sparepart->name }})
                                @endif<br>
                                Service ID: {{ $review->service_id ?? 'null' }}<br>
                                Rating: {{ $review->rating ?? 'null' }}<br>
                                Comment: {{ Str::limit($review->comment ?? 'null', 50) }}
                            </div>

                            <div class="flex items-start justify-between">
                                <!-- User Info -->
                                <div class="flex items-start space-x-4 flex-1">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                            {{ substr($review->user->name ?? 'A', 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="font-bold text-gray-900 text-lg">
                                                {{ $review->user->name ?? 'User #' . ($review->user_id ?? 'Unknown') }}
                                            </h3>
                                            <div class="text-sm text-gray-500">
                                                {{ now()->format('d M Y, H:i') }}
                                            </div>
                                        </div>
                                        
                                        <!-- Rating Stars -->
                                        <div class="flex items-center mb-3">
                                            <div class="flex text-yellow-500 mr-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= ($review->rating ?? 0))
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-medium">
                                                {{ $review->rating ?? 0 }}/5
                                            </span>
                                        </div>

                                        <!-- Sparepart Info -->
                                        @if($review->sparepart_id)
                                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-3">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center text-blue-700 text-sm">
                                                        <i class="fas fa-cog mr-2"></i>
                                                        <span class="font-medium">Sparepart:</span>
                                                        <span class="ml-2 font-semibold">
                                                            {{ $review->sparepart->name ?? 'Sparepart #' . $review->sparepart_id }}
                                                        </span>
                                                    </div>
                                                    @if(isset($review->sparepart) && $review->sparepart->price)
                                                        <div class="text-xs text-blue-600">
                                                            <span class="bg-blue-100 px-2 py-1 rounded-full">
                                                                Rp{{ number_format($review->sparepart->price, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Service Info -->
                                        @if($review->service_id)
                                            <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                                                <div class="flex items-center text-green-700 text-sm">
                                                    <i class="fas fa-wrench mr-2"></i>
                                                    <span class="font-medium">Service:</span>
                                                    <span class="ml-2">
                                                        @if(isset($review->serviceBooking))
                                                            Service #{{ $review->service_id }}
                                                        @else
                                                            Service #{{ $review->service_id }} (Data tidak ditemukan)
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Review Comment -->
                                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                                            <p class="text-gray-700 leading-relaxed">
                                                {{ $review->comment ?? 'Tidak ada komentar' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex-shrink-0 ml-4">
                                    <div class="flex space-x-2">
                                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus review ini?')"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm transition-colors duration-200"
                                                    title="Hapus Review">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Statistics -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-cog text-blue-600"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Review Sparepart</div>
                                <div class="font-bold text-xl text-gray-900">
                                    {{ $reviews->whereNotNull('sparepart_id')->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <div class="bg-green-100 p-3 rounded-full mr-4">
                                <i class="fas fa-wrench text-green-600"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Review Service</div>
                                <div class="font-bold text-xl text-gray-900">
                                    {{ $reviews->whereNotNull('service_id')->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white border border-gray-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <div class="bg-yellow-100 p-3 rounded-full mr-4">
                                <i class="fas fa-star text-yellow-600"></i>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Rating Tinggi (4-5)</div>
                                <div class="font-bold text-xl text-gray-900">
                                    {{ $reviews->where('rating', '>=', 4)->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="bg-gray-100 rounded-full p-8 w-32 h-32 mx-auto mb-6 flex items-center justify-center">
                    <i class="fas fa-star text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Belum Ada Review</h3>
                <p class="text-gray-600 mb-8">Review dari pelanggan akan muncul di sini setelah ada data</p>
                
                <!-- Debug Links -->
                
            </div>
        @endif
    </div>

    @if(isset($reviews) && $reviews->count() > 0)
    @endif
</div>
@endsection