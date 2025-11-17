{{-- Di resources/views/user/spareparts/show.blade.php --}}
<h3 class="text-lg font-bold mt-8 mb-2">Review Pengguna</h3>
@forelse ($sparepart->reviews as $review)
    <div class="mb-4 border-b pb-2">
        <div class="font-semibold">{{ $review->user->name ?? 'User' }} - Rating: {{ $review->rating }}</div>
        <div class="text-gray-700">{{ $review->comment }}</div>
        <div class="text-xs text-gray-500">{{ $review->created_at->format('d-m-Y') }}</div>
    </div>
@empty
    <div class="text-gray-500">Belum ada review.</div>
@endforelse