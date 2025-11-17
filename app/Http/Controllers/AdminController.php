<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceBooking;
use App\Models\Order;
use App\Models\User;
use App\Models\Sparepart;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        // HITUNG SEMUA DATA UNTUK DASHBOARD
        $totalUsers = User::where('role', 'user')->count();
        $totalSpareparts = Sparepart::count();
        $totalBookings = ServiceBooking::count();
        $pendingBookings = ServiceBooking::where('status', 'pending')->count();
        
        // DATA UNTUK CARDS DASHBOARD
        $bookingCount = ServiceBooking::count();
        $orderCount = Order::count() ?? 0; // Jika tabel order belum ada, default 0
        
        // Gunakan try-catch untuk model yang mungkin belum ada
        try {
            $reviewCount = \App\Models\Review::count() ?? 0;
        } catch (\Exception $e) {
            $reviewCount = 0;
        }
        
        try {
            $invoiceCount = \App\Models\Invoice::count() ?? 0;
        } catch (\Exception $e) {
            $invoiceCount = 0;
        }
        
        // DATA AKTIVITAS TERBARU (5 booking terbaru)
        $recentBookings = ServiceBooking::with('user')
                                      ->orderBy('created_at', 'desc')
                                      ->limit(5)
                                      ->get();
        
        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalSpareparts', 
            'totalBookings', 
            'pendingBookings',
            'bookingCount',
            'orderCount', 
            'reviewCount', 
            'invoiceCount',
            'recentBookings'
        ));
    }

    public function bookings(Request $request)
    {
        try {
            // Filter berdasarkan search
            $query = ServiceBooking::with('user');
            
            if ($request->filled('search')) {
                $search = $request->get('search');
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
            
            // Filter berdasarkan status
            if ($request->filled('status') && $request->get('status') !== 'all') {
                $query->where('status', $request->get('status'));
            }
            
            // Filter berdasarkan tanggal
            if ($request->filled('date')) {
                $query->whereDate('booking_date', $request->get('date'));
            }
            
            $bookings = $query->orderBy('created_at', 'desc')->paginate(10);
            
            // Hitung statistik
            $stats = [
                'total' => ServiceBooking::count(),
                'pending' => ServiceBooking::where('status', 'pending')->count(),
                'confirmed' => ServiceBooking::where('status', 'confirmed')->count(),
                'in_progress' => ServiceBooking::where('status', 'in_progress')->count(),
                'completed' => ServiceBooking::where('status', 'completed')->count(),
                'cancelled' => ServiceBooking::where('status', 'cancelled')->count(),
            ];
            
            return view('admin.bookings', compact('bookings', 'stats'));
            
        } catch (\Exception $e) {
            // Jika tabel belum ada atau error lainnya
            $bookings = new LengthAwarePaginator(
                collect([]),
                0,
                10,
                $request->get('page', 1),
                ['path' => $request->url(), 'pageName' => 'page']
            );
            
            $stats = [
                'total' => 0,
                'pending' => 0,
                'confirmed' => 0,
                'in_progress' => 0,
                'completed' => 0,
                'cancelled' => 0,
            ];
            
            return view('admin.bookings', compact('bookings', 'stats'))
                   ->with('error', 'Gagal memuat data booking: ' . $e->getMessage());
        }
    }

    public function spareparts()
    {
        try {
            $spareparts = Sparepart::orderBy('created_at', 'desc')->paginate(10);
            return view('admin.spareparts.index', compact('spareparts'));
        } catch (\Exception $e) {
            $spareparts = new LengthAwarePaginator(
                collect([]),
                0,
                10,
                request()->get('page', 1),
                ['path' => request()->url(), 'pageName' => 'page']
            );
            return view('admin.spareparts.index', compact('spareparts'))
                   ->with('error', 'Gagal memuat data spareparts: ' . $e->getMessage());
        }
    }

    public function reviews()
    {
        try {
            // Jika ada model Review
            $reviews = collect([]); // Sementara kosong
            return view('admin.reviews.index', compact('reviews'));
        } catch (\Exception $e) {
            $reviews = collect([]);
            return view('admin.reviews.index', compact('reviews'))
                   ->with('error', 'Gagal memuat data reviews: ' . $e->getMessage());
        }
    }

    public function invoices()
    {
        try {
            // Logic untuk invoices
            $invoices = collect([]); // Sementara kosong
            return view('admin.invoice.index', compact('invoices'));
        } catch (\Exception $e) {
            $invoices = collect([]);
            return view('admin.invoice.index', compact('invoices'))
                   ->with('error', 'Gagal memuat data invoices: ' . $e->getMessage());
        }
    }
    
    public function storeSpareparpart(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $data = $request->only(['name', 'description', 'price', 'stock']);
            
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('spareparts', 'public');
            }

            Sparepart::create($data);

            return redirect()->route('admin.spareparts.index')
                           ->with('success', 'Sparepart berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menambahkan sparepart: ' . $e->getMessage());
        }
    }

    public function updateSparepart(Request $request, $id)
    {
        try {
            $sparepart = Sparepart::findOrFail($id);
            
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $data = $request->only(['name', 'description', 'price', 'stock']);
            
            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($sparepart->image) {
                    \Storage::disk('public')->delete($sparepart->image);
                }
                $data['image'] = $request->file('image')->store('spareparts', 'public');
            }

            $sparepart->update($data);

            return redirect()->route('admin.spareparts.index')
                           ->with('success', 'Sparepart berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal mengupdate sparepart: ' . $e->getMessage());
        }
    }

    public function destroySparepart($id)
    {
        try {
            $sparepart = Sparepart::findOrFail($id);
            
            // Hapus gambar jika ada
            if ($sparepart->image) {
                \Storage::disk('public')->delete($sparepart->image);
            }
            
            $sparepart->delete();

            return redirect()->route('admin.spareparts.index')
                           ->with('success', 'Sparepart berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menghapus sparepart: ' . $e->getMessage());
        }
    }
}
