<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;
use App\Models\ServiceBooking;
use App\Models\Order;         // TAMBAH INI
use App\Models\OrderDetail;   // TAMBAH INI
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function home()
    {
        try {
            // Data untuk homepage
            $data = [
                'sparepartsCount' => Sparepart::count(),
                'availableSpareparts' => Sparepart::where('stock', '>', 0)->count(),
                'featuredSpareparts' => Sparepart::where('stock', '>', 0)
                                                ->orderBy('id', 'desc')
                                                ->limit(6)
                                                ->get(),
            ];

            // Jika user sudah login, tambahkan data personal
            if (Auth::check()) {
                $data['userBookings'] = ServiceBooking::where('user_id', Auth::id())
                                                     ->orderBy('id', 'desc')
                                                     ->limit(3)
                                                     ->get();
                                                     
                $data['userOrders'] = Order::where('user_id', Auth::id())
                                          ->orderBy('id', 'desc')
                                          ->limit(3)
                                          ->get();
            }

            return view('user.index', $data);
            
        } catch (\Exception $e) {
            Log::error('Error loading home page: ' . $e->getMessage());
            
            // Jika ada error, tampilkan halaman dengan data minimal
            return view('user.index', [
                'sparepartsCount' => 0,
                'availableSpareparts' => 0,
                'featuredSpareparts' => collect(),
                'userBookings' => collect(),
                'userOrders' => collect(),
            ]);
        }
    }

    public function showBookingForm()
    {
        return view('user.booking');
    }

    public function submitBooking(Request $request)
    {
        Log::info('Booking submission started', [
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'request_data' => $request->all()
        ]);

        try {
            // Validasi input
            $validated = $request->validate([
                'booking_date' => 'required|date|after:today',
            ], [
                'booking_date.required' => 'Tanggal booking wajib diisi',
                'booking_date.date' => 'Format tanggal tidak valid',
                'booking_date.after' => 'Tanggal booking harus lebih dari hari ini',
            ]);

            Log::info('Validation passed', ['validated_data' => $validated]);

            // Cek apakah user sudah login
            if (!Auth::check()) {
                Log::error('User not authenticated');
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
            }

            // SESUAIKAN dengan struktur database - hapus total_price dan updated_at
            $booking = ServiceBooking::create([
                'user_id' => Auth::id(),
                'booking_date' => $validated['booking_date'],
                'status' => 'pending'
            ]);

            Log::info('Booking created successfully', [
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'booking_date' => $booking->booking_date
            ]);

            return redirect()->route('user.mybookings')->with('success', 'Booking berhasil dibuat! Admin akan menghubungi Anda untuk konfirmasi jadwal service.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in booking', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            Log::error('Booking creation error', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'Error detail: ' . $e->getMessage())->withInput();
        }
    }

    public function myBookings()
    {
        try {
            $bookings = ServiceBooking::where('user_id', Auth::id())
                                    ->orderBy('created_at', 'desc')
                                    ->get();
            return view('user.mybookings', compact('bookings'));
        } catch (\Exception $e) {
            Log::error('Error loading bookings: ' . $e->getMessage());
            return view('user.mybookings', ['bookings' => collect()])
                ->with('error', 'Gagal memuat data booking');
        }
    }

    public function showBooking($id)
    {
        try {
            $booking = ServiceBooking::where('user_id', Auth::id())
                                    ->findOrFail($id);
            return view('user.mybookings_show', compact('booking'));
        } catch (\Exception $e) {
            return redirect()->route('user.mybookings')
                ->with('error', 'Booking tidak ditemukan');
        }
    }

    public function spareparts()
    {
        try {
            $spareparts = Sparepart::orderBy('id', 'desc')->get();
            return view('user.spareparts.index', compact('spareparts'));
        } catch (\Exception $e) {
            Log::error('Error loading spareparts: ' . $e->getMessage());
            return view('user.spareparts.index', ['spareparts' => collect()])
                ->with('error', 'Gagal memuat data sparepart');
        }
    }

    public function orderSparepart(Request $request, $id)
    {
        try {
            // Validasi user harus login
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('error', 'Silakan login terlebih dahulu untuk memesan sparepart');
            }

            $sparepart = Sparepart::findOrFail($id);
            
            if ($sparepart->stock <= 0) {
                return redirect()->back()->with('error', 'Maaf, stok sparepart ini sudah habis.');
            }

            // Validasi quantity (default 1 jika tidak ada)
            $quantity = $request->input('quantity', 1);
            
            if ($quantity > $sparepart->stock) {
                return redirect()->back()
                    ->with('error', "Stok tidak mencukupi. Stok tersedia: {$sparepart->stock}");
            }

            if ($quantity < 1) {
                return redirect()->back()
                    ->with('error', 'Quantity minimal adalah 1');
            }

            // Gunakan DB transaction untuk memastikan data konsisten
            DB::beginTransaction();

            try {
                // Hitung subtotal
                $subtotal = $sparepart->price * $quantity;

                // 1. Buat Order dulu
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total_price' => $subtotal,
                    'status' => 'pending'
                ]);

                // 2. Buat Order Detail dengan struktur yang sesuai model
                $orderDetail = OrderDetail::create([
                    'order_id' => $order->id,           
                    'sparepart_id' => $sparepart->id,   
                    'quantity' => $quantity,             
                    'subtotal' => $subtotal              
                ]);

                // 3. Kurangi stok sparepart
                $sparepart->decrement('stock', $quantity);

                DB::commit();

                return redirect()->route('user.spareparts.index')
                    ->with('success', "Pesanan berhasil dibuat! Order ID: #{$order->id}. Total: Rp" . number_format($subtotal, 0, ',', '.') . ". Kami akan segera menghubungi Anda.");

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Order sparepart error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }
}


