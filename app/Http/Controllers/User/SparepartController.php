<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SparepartController extends Controller
{
    // INDEX - PUBLIC (tidak perlu login)
    public function index()
    {
        try {
            // Ambil semua sparepart atau hanya yang ada stok
            $spareparts = Sparepart::orderBy('id', 'desc')->get();
            
            return view('user.spareparts.index', compact('spareparts'));
        } catch (\Exception $e) {
            return view('user.spareparts.index', ['spareparts' => collect()])
                ->with('error', 'Gagal memuat data sparepart: ' . $e->getMessage());
        }
    }

    // SHOW - PUBLIC (tidak perlu login)
    public function show(Sparepart $sparepart)
    {
        try {
            return view('user.spareparts.show', compact('sparepart'));
        } catch (\Exception $e) {
            return redirect()->route('user.spareparts.index')
                ->with('error', 'Sparepart tidak ditemukan');
        }
    }

    // ORDER - PRIVATE (harus login)
    public function order(Request $request, Sparepart $sparepart)
    {
        try {
            // Validasi user harus login - MIDDLEWARE SUDAH HANDLE INI
            // Tapi kita tetap double check
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('error', 'Silakan login terlebih dahulu untuk memesan sparepart');
            }

            // Validasi stok
            if ($sparepart->stock <= 0) {
                return redirect()->back()
                    ->with('error', 'Maaf, stok sparepart ini sudah habis');
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
            return redirect()->back()
                ->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }
}