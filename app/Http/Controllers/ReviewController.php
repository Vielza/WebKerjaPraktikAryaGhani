<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ServiceBooking;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        // Ambil semua data review dengan relasi user
        $reviews = Review::with('user')->get();

        // Debug data untuk memastikan hasil query
        if ($reviews->isEmpty()) {
            \Log::info('No reviews found in database.');
        } else {
            \Log::info('Reviews found:', ['data' => $reviews->toArray()]);
        }

        return view('admin.reviews.index', compact('reviews'));
    }

    public function create($bookingId)
    {
        $booking = ServiceBooking::with('review')->findOrFail($bookingId);

        // Jika sudah ada review, redirect atau tampilkan pesan error
        if ($booking->review) {
            return redirect()->route('user.mybookings')->with('error', 'Booking ini sudah direview.');
        }

        return view('user.reviews.create', compact('booking'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'nullable|exists:service_bookings,id',
            'order_id' => 'nullable|exists:orders,id', // Tambahan untuk review sparepart
            'rating' => 'required|in:1,2,3,4,5',
            'comment' => 'required|string',
        ]);

        // Review untuk service booking
        if ($validated['booking_id']) {
            $booking = ServiceBooking::with('review')->findOrFail($validated['booking_id']);

            // Cegah double review
            if ($booking->review) {
                return redirect()->route('user.mybookings')->with('error', 'Booking ini sudah direview.');
            }

            Review::create([
                'user_id' => auth()->id(),
                'service_id' => $booking->id,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
            ]);

            return redirect()->route('user.mybookings')->with('success', 'Review berhasil dikirim!');
        }

        // Review untuk sparepart (dari order)
        if ($validated['order_id']) {
            return $this->storeOrderReview($request, $validated['order_id']);
        }

        return back()->with('error', 'Data tidak valid.');
    }

    /**
     * Store review untuk sparepart dari order
     */
    public function storeOrderReview(Request $request, $orderId)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000'
        ]);

        try {
            $order = Order::with('orderDetails.sparepart')
                ->where('user_id', Auth::id())
                ->where('id', $orderId)
                ->where('status', 'delivered')
                ->firstOrFail();

            // Get the first sparepart from order details
            $firstOrderDetail = $order->orderDetails->first();
            if (!$firstOrderDetail || !$firstOrderDetail->sparepart) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sparepart tidak ditemukan dalam pesanan ini.'
                ], 404);
            }

            $sparepartId = $firstOrderDetail->sparepart->id;

            // Check if review already exists for this sparepart by this user
            $existingReview = Review::where('user_id', Auth::id())
                ->where('sparepart_id', $sparepartId)
                ->first();

            if ($existingReview) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah memberikan ulasan untuk sparepart ini.'
                ]);
            }

            // Create review
            Review::create([
                'user_id' => Auth::id(),
                'sparepart_id' => $sparepartId,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ulasan berhasil dikirim. Terima kasih!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error submitting review', [
                'error' => $e->getMessage(),
                'order_id' => $orderId,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim ulasan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show review detail (for admin)
     */
    public function show($id)
    {
        $review = Review::with(['user', 'sparepart', 'serviceBooking'])->findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Delete review (for admin)
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        
        return redirect()->route('admin.reviews.index')
                        ->with('success', 'Review berhasil dihapus');
    }
}
