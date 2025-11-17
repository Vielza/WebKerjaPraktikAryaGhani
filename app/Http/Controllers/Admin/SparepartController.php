<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SparepartController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Sparepart::query();

            // Search functionality
            if ($request->filled('search')) {
                $search = $request->get('search');
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
                });
            }

            // Stock filter
            if ($request->filled('stock_filter')) {
                switch ($request->get('stock_filter')) {
                    case 'low':
                        $query->where('stock', '<=', 5);
                        break;
                    case 'restock':
                        $query->whereBetween('stock', [6, 10]);
                        break;
                    case 'safe':
                        $query->where('stock', '>', 10);
                        break;
                }
            }

            $spareparts = $query->orderBy('created_at', 'desc')->get();

            // Debug info untuk setiap sparepart
            foreach($spareparts as $sparepart) {
                if($sparepart->image) {
                    $imagePath = public_path('storage/' . $sparepart->image);
                    \Log::info("Sparepart {$sparepart->name} image check", [
                        'image_field' => $sparepart->image,
                        'full_path' => $imagePath,
                        'file_exists' => file_exists($imagePath),
                        'storage_path' => storage_path('app/public/' . $sparepart->image),
                        'storage_exists' => file_exists(storage_path('app/public/' . $sparepart->image))
                    ]);
                }
            }

            return view('admin.spareparts.index', compact('spareparts'));
            
        } catch (\Exception $e) {
            \Log::error('Error in spareparts index: ' . $e->getMessage());
            return view('admin.spareparts.index', ['spareparts' => collect(), 'error' => 'Gagal memuat data sparepart']);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('spareparts', 'public');
                $validated['image'] = $imagePath;
            }

            Sparepart::create($validated);

            return redirect()->route('admin.spareparts.index')
                ->with('success', 'Sparepart berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan sparepart: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $sparepart = Sparepart::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($sparepart->image) {
                    Storage::disk('public')->delete($sparepart->image);
                }
                $imagePath = $request->file('image')->store('spareparts', 'public');
                $validated['image'] = $imagePath;
            }

            $sparepart->update($validated);

            return redirect()->route('admin.spareparts.index')
                ->with('success', 'Sparepart berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui sparepart: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $sparepart = Sparepart::findOrFail($id);

            // Delete image if exists
            if ($sparepart->image) {
                Storage::disk('public')->delete($sparepart->image);
            }

            $sparepart->delete();

            return redirect()->route('admin.spareparts.index')
                ->with('success', 'Sparepart berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus sparepart: ' . $e->getMessage());
        }
    }
}