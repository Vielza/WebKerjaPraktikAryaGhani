<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::with(['user', 'orderDetails.sparepart'])
                          ->where('user_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->get();
            
            Log::info('Orders loaded: ' . $orders->count() . ' orders for user ' . Auth::id());
            
            return view('user.orders.index', compact('orders'));
        } catch (\Exception $e) {
            Log::error('Error loading user orders: ' . $e->getMessage());
            return view('user.orders.index')->with('orders', collect())->with('error', 'Gagal memuat pesanan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $order = Order::with(['user', 'orderDetails.sparepart'])
                         ->where('user_id', Auth::id())
                         ->findOrFail($id);
            
            return view('user.orders.show', compact('order'));
        } catch (\Exception $e) {
            Log::error('Error loading order detail: ' . $e->getMessage());
            return redirect()->route('user.orders.index')
                           ->with('error', 'Pesanan tidak ditemukan: ' . $e->getMessage());
        }
    }

    public function cancel(Request $request, $id)
    {
        try {
            $order = Order::where('user_id', Auth::id())
                         ->where('status', 'pending')
                         ->findOrFail($id);
            
            $order->update([
                'status' => 'canceled',
                'updated_at' => now()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibatalkan'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error canceling order: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membatalkan pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function submitReview(Request $request, $id)
    {
        // Add logging for debugging
        \Log::info('Review submission attempt', [
            'order_id' => $id,
            'user_id' => Auth::id(),
            'request_data' => $request->all()
        ]);

        try {
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'required|string|max:1000'
            ]);

            $order = Order::with('orderDetails.sparepart')
                ->where('user_id', Auth::id())
                ->where('id', $id)
                ->where('status', 'delivered')
                ->firstOrFail();

            \Log::info('Order found', ['order' => $order->toArray()]);

            // Get the first sparepart from order details (or you can create review for each sparepart)
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
                \Log::warning('Review already exists for sparepart', [
                    'user_id' => Auth::id(),
                    'sparepart_id' => $sparepartId
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah memberikan ulasan untuk sparepart ini.'
                ]);
            }

            // Create review using the existing model structure
            $review = Review::create([
                'user_id' => Auth::id(),
                'sparepart_id' => $sparepartId,
                'rating' => $request->rating,
                'comment' => $request->review, // Use 'comment' field instead of 'review'
            ]);

            \Log::info('Review created successfully', ['review_id' => $review->id]);

            return response()->json([
                'success' => true,
                'message' => 'Ulasan berhasil dikirim. Terima kasih!'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in review submission', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . implode(', ', array_flatten($e->errors()))
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error submitting review', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim ulasan: ' . $e->getMessage()
            ], 500);
        }
    }
}