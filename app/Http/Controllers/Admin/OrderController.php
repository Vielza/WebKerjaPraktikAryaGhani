<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'orderDetails.sparepart'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'orderDetails.sparepart'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            // Validasi dengan status yang sesuai dengan form
            $request->validate([
                'status' => 'required|in:pending,confirmed,processing,shipped,delivered,canceled'
            ]);

            $order = Order::findOrFail($id);
            
            // Update status
            $order->update([
                'status' => $request->status
            ]);

            // Log aktivitas (optional)
            \Log::info("Order {$id} status updated to {$request->status} by " . auth()->user()->name);

            return redirect()->route('admin.orders.index')
                ->with('success', 'Status order berhasil diupdate menjadi ' . $this->getStatusLabel($request->status));

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->with('error', 'Status yang dipilih tidak valid. Silakan pilih status yang tersedia.');
        } catch (\Exception $e) {
            \Log::error("Error updating order status: " . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal mengupdate status order: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            
            // Hanya bisa delete order dengan status canceled atau pending
            if (!in_array($order->status, ['canceled', 'pending'])) {
                return redirect()->back()
                    ->with('error', 'Hanya order dengan status pending atau canceled yang dapat dihapus.');
            }

            $order->delete();

            return redirect()->route('admin.orders.index')
                ->with('success', 'Order berhasil dihapus');

        } catch (\Exception $e) {
            \Log::error("Error deleting order: " . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus order: ' . $e->getMessage());
        }
    }

    public function exportPdf($id)
    {
        $order = Order::with(['orderDetails.sparepart', 'user'])->findOrFail($id);
        
        $pdf = PDF::loadView('admin.orders.pdf', compact('order'));
        
        return $pdf->download('order-' . $order->id . '.pdf');
    }

    private function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Sedang Diproses',
            'shipped' => 'Dalam Pengiriman',
            'delivered' => 'Selesai/Diterima',
            'canceled' => 'Dibatalkan'
        ];

        return $labels[$status] ?? ucfirst($status);
    }
}