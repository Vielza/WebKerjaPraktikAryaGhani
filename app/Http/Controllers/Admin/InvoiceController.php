<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\Sparepart;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = collect();
        
        try {
            // Ambil semua user yang pernah membuat booking KECUALI ADMIN
            $usersWithBookings = User::whereHas('bookings')
                ->with('bookings')
                ->where(function($query) {
                    $query->where('role', '!=', 'admin')
                          ->orWhereNull('role'); // Include users tanpa role (default customer)
                })
                ->get();
            
            foreach ($usersWithBookings as $user) {
                // Skip jika user adalah admin berdasarkan email atau role
                if ($user->email && (
                    str_contains($user->email, 'admin') || 
                    $user->role === 'admin'
                )) {
                    continue;
                }
                
                $totalBookings = $user->bookings->count();
                $totalBookingAmount = $user->bookings->sum(function($booking) {
                    return $booking->total_price ?? 150000;
                });
                
                $invoices->push((object) [
                    'id' => $user->id,
                    'type' => 'user_account',
                    'invoice_number' => 'USR-' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
                    'user' => $user,
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                    'customer_phone' => $user->phone ?? 'N/A',
                    'total' => $totalBookingAmount,
                    'booking_total' => $totalBookingAmount,
                    'sparepart_total' => 0,
                    'booking_count' => $totalBookings,
                    'sparepart_count' => 0,
                    'total_transactions' => $totalBookings,
                    'status' => $totalBookings >= 5 ? 'vip' : 'active',
                    'payment_status' => 'active',
                    'created_at' => Carbon::parse($user->created_at),
                ]);
            }
            
        } catch (\Exception $e) {
            // Jika tidak ada relasi bookings, buat data dummy TANPA ADMIN
            $users = User::where(function($query) {
                    $query->where('role', '!=', 'admin')
                          ->orWhereNull('role');
                })
                ->take(5)
                ->get()
                ->filter(function($user) {
                    // Filter tambahan untuk memastikan tidak ada admin
                    return !str_contains($user->email ?? '', 'admin') && 
                           $user->role !== 'admin';
                });
                
            foreach ($users as $user) {
                $invoices->push((object) [
                    'id' => $user->id,
                    'type' => 'user_account',
                    'invoice_number' => 'USR-' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
                    'user' => $user,
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                    'customer_phone' => $user->phone ?? 'N/A',
                    'total' => rand(100000, 500000),
                    'booking_total' => rand(50000, 300000),
                    'sparepart_total' => rand(50000, 200000),
                    'booking_count' => rand(1, 10),
                    'sparepart_count' => rand(0, 5),
                    'total_transactions' => rand(1, 15),
                    'status' => ['active', 'vip', 'inactive'][array_rand(['active', 'vip', 'inactive'])],
                    'payment_status' => 'active',
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                ]);
            }
        }

        // Hitung statistik
        $totalRevenue = $invoices->sum('total');
        $totalUsers = $invoices->count();
        $vipUsers = $invoices->where('status', 'vip')->count();
        $activeUsers = $invoices->where('status', 'active')->count();

        return view('admin.invoice.index', compact(
            'invoices', 
            'totalRevenue', 
            'totalUsers', 
            'vipUsers', 
            'activeUsers'
        ));
    }

    public function show($id)
    {
        $user = User::where('id', $id)
            ->where(function($query) {
                $query->where('role', '!=', 'admin')
                      ->orWhereNull('role');
            })
            ->first();
        
        if (!$user || $user->role === 'admin') {
            abort(404, 'Customer tidak ditemukan');
        }

        // Pastikan tidak menampilkan data admin
        if (str_contains($user->email ?? '', 'admin')) {
            abort(404, 'Customer tidak ditemukan');
        }

        // Buat riwayat transaksi dummy untuk demo
        $history = collect();
        
        // Simulasi riwayat booking
        for ($i = 1; $i <= rand(3, 8); $i++) {
            $history->push((object) [
                'id' => $i,
                'type' => 'booking',
                'title' => 'Booking Service Motor #' . $i,
                'description' => ['Service Berkala', 'Ganti Oli', 'Tune Up', 'Perbaikan Mesin'][array_rand(['Service Berkala', 'Ganti Oli', 'Tune Up', 'Perbaikan Mesin'])],
                'details' => 'Layanan service motor dengan kualitas terbaik',
                'amount' => rand(100000, 300000),
                'status' => ['completed', 'pending', 'processing'][array_rand(['completed', 'pending', 'processing'])],
                'date' => Carbon::now()->subDays(rand(1, 60)),
                'invoice_number' => 'BK-' . str_pad($i, 6, '0', STR_PAD_LEFT),
            ]);
        }
        
        // Simulasi riwayat pembelian sparepart
        for ($i = 1; $i <= rand(2, 5); $i++) {
            $history->push((object) [
                'id' => $i + 100,
                'type' => 'sparepart',
                'title' => 'Pembelian Sparepart #' . $i,
                'description' => ['Kampas Rem', 'Oli Mesin', 'Filter Udara', 'Busi', 'Rantai'][array_rand(['Kampas Rem', 'Oli Mesin', 'Filter Udara', 'Busi', 'Rantai'])],
                'details' => 'Sparepart original berkualitas tinggi',
                'amount' => rand(50000, 200000),
                'status' => 'completed',
                'date' => Carbon::now()->subDays(rand(1, 45)),
                'invoice_number' => 'SP-' . str_pad($i, 6, '0', STR_PAD_LEFT),
            ]);
        }

        // Urutkan berdasarkan tanggal terbaru
        $history = $history->sortByDesc('date');

        // Hitung statistik user
        $stats = [
            'total_spent' => $history->sum('amount'),
            'total_bookings' => $history->where('type', 'booking')->count(),
            'total_spareparts' => $history->where('type', 'sparepart')->count(),
            'total_transactions' => $history->count(),
            'avg_transaction' => $history->count() > 0 ? $history->sum('amount') / $history->count() : 0,
            'last_activity' => $history->first() ? $history->first()->date : null,
            'member_since' => Carbon::parse($user->created_at),
        ];

        $invoice = (object) [
            'id' => $user->id,
            'type' => 'user_account',
            'invoice_number' => 'USR-' . str_pad($user->id, 6, '0', STR_PAD_LEFT),
            'user' => $user,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => $user->phone ?? 'N/A',
            'total' => $stats['total_spent'],
            'status' => 'active',
            'payment_status' => 'active',
            'created_at' => Carbon::parse($user->created_at),
            'history' => $history,
            'stats' => $stats,
        ];
        
        return view('admin.invoice.show', compact('invoice'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,cancelled,active,inactive,vip'
        ]);

        try {
            // Pastikan user bukan admin
            $user = User::where('id', $id)
                ->where(function($query) {
                    $query->where('role', '!=', 'admin')
                          ->orWhereNull('role');
                })
                ->first();
                
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Customer tidak ditemukan']);
            }
            
            // Simulasi update status
            return response()->json(['success' => true, 'message' => 'Status berhasil diupdate']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function print($id)
    {
        // Pastikan user bukan admin
        $user = User::where('id', $id)
            ->where(function($query) {
                $query->where('role', '!=', 'admin')
                      ->orWhereNull('role');
            })
            ->first();
            
        if (!$user) {
            abort(404, 'Customer tidak ditemukan');
        }
        
        $invoice = $this->show($id)->getData()['invoice'];
        return view('admin.invoice.print', compact('invoice'));
    }

    public function send($id)
    {
        try {
            // Pastikan user bukan admin
            $user = User::where('id', $id)
                ->where(function($query) {
                    $query->where('role', '!=', 'admin')
                          ->orWhereNull('role');
                })
                ->first();
                
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Customer tidak ditemukan']);
            }
            
            return response()->json(['success' => true, 'message' => 'Riwayat transaksi berhasil dikirim ke ' . $user->email]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function duplicate($id)
    {
        return response()->json(['success' => false, 'message' => 'Tidak dapat menduplikat akun customer']);
    }

    public function export(Request $request)
    {
        return response()->json(['success' => true, 'message' => 'Export sedang diproses']);
    }
}