@extends('layouts.user')

@section('title', 'Review Servis')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-8 mt-8">
    <h2 class="text-xl font-bold mb-4 text-center">Review Servis</h2>

    {{-- Notifikasi sukses --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('user.reviews.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
        <div>
            <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
            <select name="rating" id="rating" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">Pilih rating</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div>
            <label for="comment" class="block text-sm font-medium text-gray-700">Komentar</label>
            <textarea name="comment" id="comment" rows="3" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
        </div>
        <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 font-semibold">
            Kirim Review
        </button>
    </form>
</div>
@endsection