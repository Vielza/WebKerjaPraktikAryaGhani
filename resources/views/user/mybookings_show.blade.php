{{-- filepath: resources/views/user/mybookings_show.blade.php --}}
@extends('layouts.user')

@section('title', 'Detail Booking')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-8 mt-8">
    <h2 class="text-2xl font-bold mb-6">Detail Booking Servis</h2>
    <dl class="mb-4">
        <dt class="font-semibold">Tanggal Booking:</dt>
        <dd class="mb-2">{{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') : '-' }}</dd>
        <dt class="font-semibold">Status:</dt>
        <dd class="mb-2">{{ ucfirst($booking->status) }}</dd>
        <dt class="font-semibold">Total Harga:</dt>
        <dd class="mb-2">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</dd>
        <dt class="font-semibold">Review:</dt>
        <dd>
            @if($booking->review)
                <div class="mb-2">Rating: {{ $booking->review->rating }} / 5</div>
                <div>Komentar: {{ $booking->review->comment }}</div>
            @else
                <span class="text-gray-500">Belum ada review</span>
            @endif
        </dd>
    </dl>
    <a href="{{ route('user.mybookings') }}" class="inline-block bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Kembali</a>
</div>
@endsection