<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\SparepartController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AdminController;
use App\Models\Order; 
use App\Http\Controllers\Admin\OrderController as AdminOrderController; 
use App\Http\Controllers\Admin\BookingController as AdminBookingController;

// =========================
// ROUTE DEFAULT UNTUK URL ROOT (Halaman utama untuk semua)
// =========================
Route::get('/', [UserController::class, 'home'])->name('user.index');

// =========================
// ROUTE UNTUK LOGIN & REGISTER
// =========================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// =========================
// ROUTE UNTUK ADMIN
// =========================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard & Main Pages
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // BOOKINGS ROUTES - LENGKAP DENGAN SHOW
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings');
    Route::get('/bookings/{id}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::put('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    
    // SPAREPARTS ROUTES - CRUD LENGKAP
    Route::get('/spareparts', [AdminController::class, 'spareparts'])->name('spareparts.index');
    Route::post('/spareparts', [AdminController::class, 'storeSpareparpart'])->name('spareparts.store');
    Route::put('/spareparts/{id}', [AdminController::class, 'updateSparepart'])->name('spareparts.update');
    Route::delete('/spareparts/{id}', [AdminController::class, 'destroySparepart'])->name('spareparts.destroy');
    
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews.index');
    Route::get('/invoices', [AdminController::class, 'invoices'])->name('invoices.index');
    
    // ORDERS ROUTES
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{id}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/{id}/export', [AdminOrderController::class, 'exportPdf'])->name('orders.exportPdf');
    
    // Invoice routes
    Route::get('/invoices', [App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{id}', [App\Http\Controllers\Admin\InvoiceController::class, 'show'])->name('invoices.show');
    Route::post('/invoices/{id}/status', [App\Http\Controllers\Admin\InvoiceController::class, 'updateStatus']);
    Route::get('/invoices/{id}/print', [App\Http\Controllers\Admin\InvoiceController::class, 'print']);
    Route::post('/invoices/{id}/send', [App\Http\Controllers\Admin\InvoiceController::class, 'send']);
    Route::post('/invoices/{id}/duplicate', [App\Http\Controllers\Admin\InvoiceController::class, 'duplicate']);
    Route::get('/invoices/export', [App\Http\Controllers\Admin\InvoiceController::class, 'export']);
});

// =========================
// ROUTE UNTUK USER 
// =========================
Route::middleware(['auth'])->group(function () {
    // Home/Dashboard
    Route::get('/home', [UserController::class, 'home'])->name('user.home');
    Route::get('/dashboard', [UserController::class, 'home'])->name('user.dashboard');
    
    // Booking routes - PASTIKAN ADA GET dan POST
    Route::get('/booking', [UserController::class, 'showBookingForm'])->name('user.booking');
    Route::post('/booking', [UserController::class, 'submitBooking'])->name('user.booking.store');
    Route::get('/my-bookings', [UserController::class, 'myBookings'])->name('user.mybookings');
    Route::get('/my-bookings/{id}', [UserController::class, 'showBooking'])->name('user.mybookings.show');
    
    // ORDER SPAREPART - HARUS LOGIN
    Route::post('/spareparts/{sparepart}/order', [UserController::class, 'orderSparepart'])->name('spareparts.order');
    
    // User Orders routes
    Route::get('/my-orders', [OrderController::class, 'index'])->name('user.orders.index');
    Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('user.orders.show');
    Route::post('/my-orders/{id}/cancel', [OrderController::class, 'cancel'])->name('user.orders.cancel');
    Route::post('/my-orders/{id}/review', [App\Http\Controllers\User\OrderController::class, 'submitReview'])->name('user.orders.review');
    
    // Profile routes
    Route::get('/profile', function() {
        return view('user.profile');
    })->name('user.profile');
    
    // Review routes
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('user.reviews.store');
    
    // Invoice routes
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('user.invoices.index');
    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('user.invoices.show');
});

// =========================
// PUBLIC ROUTES (BISA DIAKSES TANPA LOGIN)
// =========================
// Public Spareparts - Bisa dilihat tanpa login
Route::get('/spareparts', [SparepartController::class, 'index'])->name('user.spareparts.index');
Route::get('/spareparts/{sparepart}', [SparepartController::class, 'show'])->name('spareparts.show');

// Public Pages
Route::get('/about', function() {
    return view('public.about');
})->name('about');

Route::get('/contact', function() {
    return view('public.contact');
})->name('contact');

Route::get('/services', function() {
    return view('public.services');
})->name('services');

// API Routes untuk AJAX (jika diperlukan)
Route::prefix('api')->name('api.')->group(function() {
    Route::get('/spareparts/search', [SparepartController::class, 'search'])->name('spareparts.search');
    Route::get('/orders/status/{id}', function($id) {
        $order = Order::find($id);
        return response()->json(['status' => $order ? $order->status : 'not_found']);
    })->name('orders.status');
});

// Fallback route untuk 404
Route::fallback(function() {
    return view('errors.404');
});

// Tambahkan route test ini sementara
Route::get('/test-review/{id}', function($id) {
    $order = \App\Models\Order::findOrFail($id);
    return response()->json([
        'order' => $order,
        'user' => auth()->user(),
        'status' => $order->status
    ]);
});

// Tambahkan route debug ini sementara
Route::get('/debug-reviews', function() {
    $reviews = \App\Models\Review::with(['user', 'sparepart', 'serviceBooking'])->get();
    
    return response()->json([
        'total_reviews' => $reviews->count(),
        'reviews' => $reviews->map(function($review) {
            return [
                'id' => $review->id,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'user_name' => $review->user ? $review->user->name : 'No user',
                'sparepart_name' => $review->sparepart ? $review->sparepart->name : 'No sparepart',
                'service_booking' => $review->serviceBooking ? $review->serviceBooking->id : 'No service',
                'user_id' => $review->user_id,
                'sparepart_id' => $review->sparepart_id,
                'service_id' => $review->service_id,
            ];
        })
    ]);
});

// Route untuk debug data reviews
Route::get('/check-reviews', function() {
    try {
        // Cek data mentah dari database
        $rawReviews = DB::table('reviews')->get();
        
        // Cek data dengan relationship
        $reviewsWithRelations = \App\Models\Review::with(['user', 'sparepart', 'serviceBooking'])->get();
        
        return response()->json([
            'raw_count' => $rawReviews->count(),
            'raw_data' => $rawReviews,
            'with_relations_count' => $reviewsWithRelations->count(),
            'with_relations_data' => $reviewsWithRelations->map(function($review) {
                return [
                    'id' => $review->id,
                    'user_id' => $review->user_id,
                    'user_name' => $review->user ? $review->user->name : null,
                    'sparepart_id' => $review->sparepart_id,
                    'sparepart_name' => $review->sparepart ? $review->sparepart->name : null,
                    'service_id' => $review->service_id,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                ];
            })
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
});

// Debug route untuk cek gambar
Route::get('/debug-images', function() {
    $spareparts = \App\Models\Sparepart::whereNotNull('image')->get();
    
    $debug = [];
    foreach($spareparts as $sparepart) {
        $debug[] = [
            'name' => $sparepart->name,
            'image_field' => $sparepart->image,
            'full_url' => asset('storage/' . $sparepart->image),
            'file_exists' => file_exists(public_path('storage/' . $sparepart->image))
        ];
    }
    
    return response()->json([
        'storage_link_exists' => is_link(public_path('storage')),
        'spareparts' => $debug
    ]);
});

// Tambahkan route ini untuk mencari gambar yang hilang
Route::get('/find-lost-images', function() {
    $spareparts = \App\Models\Sparepart::whereNotNull('image')->get();
    $found = [];
    $notFound = [];
    
    foreach($spareparts as $sparepart) {
        $imageName = basename($sparepart->image);
        
        // Cari di berbagai lokasi
        $searchPaths = [
            public_path('uploads/'),
            public_path('images/'),
            public_path('storage/spareparts/'),
            storage_path('app/'),
            public_path(),
        ];
        
        $foundPath = null;
        foreach($searchPaths as $searchPath) {
            if(is_dir($searchPath)) {
                $files = glob($searchPath . '*' . $imageName);
                if(!empty($files)) {
                    $foundPath = $files[0];
                    break;
                }
                
                // Cari file dengan nama mirip
                $files = glob($searchPath . '*' . substr($imageName, 0, 10) . '*');
                if(!empty($files)) {
                    $foundPath = $files[0];
                    break;
                }
            }
        }
        
        if($foundPath) {
            $found[] = [
                'sparepart' => $sparepart->name,
                'db_path' => $sparepart->image,
                'found_at' => $foundPath
            ];
        } else {
            $notFound[] = [
                'sparepart' => $sparepart->name,
                'db_path' => $sparepart->image
            ];
        }
    }
    
    return response()->json([
        'found' => $found,
        'not_found' => $notFound
    ]);
});

// Route untuk membuat storage link
Route::get('/create-storage-link', function() {
    try {
        $linkPath = public_path('storage');
        $targetPath = storage_path('app/public');
        
        // Hapus link lama jika ada
        if(file_exists($linkPath)) {
            if(is_dir($linkPath) && !is_link($linkPath)) {
                // Jika folder biasa, backup dulu
                rename($linkPath, $linkPath . '_backup_' . time());
            } else {
                // Hapus symbolic link atau file
                unlink($linkPath);
            }
        }
        
        // Buat symbolic link baru
        $success = symlink($targetPath, $linkPath);
        
        return response()->json([
            'success' => $success,
            'link_path' => $linkPath,
            'target_path' => $targetPath,
            'link_created' => is_link($linkPath),
            'target_exists' => is_dir($targetPath),
            'message' => $success ? 'Storage link created successfully!' : 'Failed to create storage link'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'suggestion' => 'Try running: php artisan storage:link in terminal'
        ]);
    }
});

// Route untuk copy files manual jika symlink tidak bisa
Route::get('/copy-storage-manual', function() {
    $sourceDir = storage_path('app/public');
    $targetDir = public_path('storage');
    
    // Fungsi untuk copy direktori
    function copyDir($src, $dst) {
        $dir = opendir($src);
        if(!is_dir($dst)) {
            mkdir($dst, 0755, true);
        }
        
        $copied = 0;
        while(($file = readdir($dir)) !== false) {
            if($file != '.' && $file != '..') {
                $srcPath = $src . '/' . $file;
                $dstPath = $dst . '/' . $file;
                
                if(is_dir($srcPath)) {
                    $copied += copyDir($srcPath, $dstPath);
                } else {
                    if(copy($srcPath, $dstPath)) {
                        $copied++;
                    }
                }
            }
        }
        closedir($dir);
        return $copied;
    }
    
    $totalCopied = copyDir($sourceDir, $targetDir);
    
    return response()->json([
        'success' => true,
        'files_copied' => $totalCopied,
        'source' => $sourceDir,
        'target' => $targetDir,
        'message' => "Copied $totalCopied files manually"
    ]);
});

// Route untuk fix sparepart images yang sudah ada
Route::get('/fix-sparepart-paths', function() {
    $spareparts = \App\Models\Sparepart::whereNotNull('image')->get();
    $fixed = 0;
    
    foreach($spareparts as $sparepart) {
        $currentPath = $sparepart->image;
        $sourcePath = storage_path('app/public/' . $currentPath);
        
        // Cek apakah file ada di storage/app/public/
        if(file_exists($sourcePath)) {
            // File sudah ada di tempat yang benar, pastikan path di DB benar
            if(!str_starts_with($currentPath, 'spareparts/')) {
                // Update path di database jika perlu
                $newPath = 'spareparts/' . basename($currentPath);
                $newSourcePath = storage_path('app/public/' . $newPath);
                
                // Pastikan direktori spareparts ada
                $sparepartsDir = storage_path('app/public/spareparts');
                if(!is_dir($sparepartsDir)) {
                    mkdir($sparepartsDir, 0755, true);
                }
                
                // Pindahkan file ke direktori spareparts
                if(rename($sourcePath, $newSourcePath)) {
                    $sparepart->update(['image' => $newPath]);
                    $fixed++;
                }
            }
        } else {
            // Cari file di lokasi lain
            $fileName = basename($currentPath);
            $searchPaths = [
                storage_path('app/public/'),
                public_path('uploads/'),
                public_path('storage/'),
                public_path(),
            ];
            
            foreach($searchPaths as $searchPath) {
                $foundFile = $searchPath . $fileName;
                if(file_exists($foundFile)) {
                    // Copy ke lokasi yang benar
                    $targetPath = storage_path('app/public/spareparts/' . $fileName);
                    $targetDir = dirname($targetPath);
                    
                    if(!is_dir($targetDir)) {
                        mkdir($targetDir, 0755, true);
                    }
                    
                    if(copy($foundFile, $targetPath)) {
                        $sparepart->update(['image' => 'spareparts/' . $fileName]);
                        $fixed++;
                        break;
                    }
                }
            }
        }
    }
    
    return response()->json([
        'fixed' => $fixed,
        'total_spareparts' => $spareparts->count(),
        'message' => "Fixed $fixed sparepart image paths"
    ]);
});

// Route untuk test apakah gambar bisa diakses
Route::get('/test-images', function() {
    $spareparts = \App\Models\Sparepart::whereNotNull('image')->take(5)->get();
    $results = [];
    
    foreach($spareparts as $sparepart) {
        $imagePath = $sparepart->image;
        $storageExists = file_exists(storage_path('app/public/' . $imagePath));
        $publicExists = file_exists(public_path('storage/' . $imagePath));
        $url = asset('storage/' . $imagePath);
        
        $results[] = [
            'sparepart' => $sparepart->name,
            'image_path' => $imagePath,
            'storage_exists' => $storageExists,
            'public_exists' => $publicExists,
            'url' => $url,
            'can_access' => $publicExists || $storageExists
        ];
    }
    
    return response()->json([
        'storage_link_exists' => is_link(public_path('storage')),
        'results' => $results
    ]);
});

// Route untuk admin mengelola reviews
    Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
    Route::delete('/admin/reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');});




