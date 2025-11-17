<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = ServiceBooking::with('user');

            // Filter berdasarkan status
            if ($request->filled('status') && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            // Filter berdasarkan tanggal
            if ($request->filled('date')) {
                $query->whereDate('booking_date', $request->date);
            }

            // Search berdasarkan nama user
            if ($request->filled('search')) {
                $query->whereHas('user', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%');
                });
            }

            // Ambil data bookings
            $bookings = $query->orderBy('created_at', 'desc')->get();

            // Hitung statistik dari SEMUA booking (bukan dari hasil filter)
            $allBookings = ServiceBooking::all();
            
            $stats = [
                'total' => $allBookings->count(),
                'pending' => $allBookings->where('status', 'pending')->count(),
                'confirmed' => $allBookings->where('status', 'confirmed')->count(),
                'in_progress' => $allBookings->where('status', 'in_progress')->count(),
                'completed' => $allBookings->where('status', 'completed')->count(),
                'cancelled' => $allBookings->where('status', 'cancelled')->count(),
            ];

            return view('admin.bookings.index', compact('bookings', 'stats'));
            
        } catch (\Exception $e) {
            // Jika ada error, kirim data kosong dengan stats default
            $bookings = collect();
            $stats = [
                'total' => 0,
                'pending' => 0,
                'confirmed' => 0,
                'in_progress' => 0,
                'completed' => 0,
                'cancelled' => 0,
            ];
            
            return view('admin.bookings.index', compact('bookings', 'stats'))
                ->with('error', 'Terjadi kesalahan saat memuat data booking: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $booking = ServiceBooking::with('user')->findOrFail($id);
            return view('admin.bookings.show', compact('booking'));
        } catch (\Exception $e) {
            return redirect()->route('admin.bookings')->with('error', 'Booking tidak ditemukan');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled'
            ]);

            $booking = ServiceBooking::findOrFail($id);
            $booking->update(['status' => $request->status]);

            return response()->json([
                'success' => true, 
                'message' => 'Status berhasil diupdate',
                'new_status' => $request->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate status: ' . $e->getMessage()
            ], 500);
        }
    }
}