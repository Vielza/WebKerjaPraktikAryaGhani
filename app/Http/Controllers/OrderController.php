<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Ambil semua order dari user dengan relasi
            $orders = Order::with(['user', 'orderDetails.sparepart'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
            
            return view('admin.orders.index', compact('orders'));
            
        } catch (\Exception $e) {
            // Jika tabel belum ada atau error lainnya
            $orders = new LengthAwarePaginator(
                collect([]),
                0,
                10,
                $request->get('page', 1),
                ['path' => $request->url(), 'pageName' => 'page']
            );
            
            return view('admin.orders.index', compact('orders'))
                   ->with('error', 'Gagal memuat data order: ' . $e->getMessage());
        }
    }
    
    public function show($id)
    {
        try {
            $order = Order::with(['user', 'orderDetails.sparepart'])
                         ->findOrFail($id);
            
            return view('admin.orders.show', compact('order'));
            
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')
                           ->with('error', 'Order tidak ditemukan!');
        }
    }
    
    public function updateStatus(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);
            
            $request->validate([
                'status' => 'required|in:pending,paid,shipped,delivered,canceled'
            ]);
            
            $order->status = $request->status;
            $order->save();
            
            return redirect()->back()
                           ->with('success', 'Status order berhasil diupdate menjadi ' . $request->status);
            
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal update status order: ' . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $orderNumber = $order->id;
            
            $order->delete();
            
            return redirect()->route('admin.orders.index')
                           ->with('success', "Order #$orderNumber berhasil dihapus!");
            
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menghapus order: ' . $e->getMessage());
        }
    }
}

