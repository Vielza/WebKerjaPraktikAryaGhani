{{-- filepath: c:\laragon\www\wep_Kape\resources\views\admin\spareparts\index.blade.php --}}
@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.admin')

@section('title', 'Data Sparepart')

@section('content')
<div class="min-h-screen bg-theme-secondary py-8">
    <div class="container mx-auto px-4">
        
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-md">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if(isset($error))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-3"></i>
                    {{ $error }}
                </div>
            </div>
        @endif

        <!-- Header Section -->
        <div class="mb-8">
            <div class="bg-theme-primary rounded-2xl shadow-xl border border-theme p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div>
                        <h1 class="text-3xl font-bold text-theme-primary">Data Sparepart</h1>
                        <p class="text-theme-secondary mt-2">Kelola inventory sparepart motor</p>
                    </div>
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                        <div class="bg-purple-50 dark:bg-purple-900/20 px-4 py-2 rounded-xl border border-purple-200 dark:border-purple-800">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-cubes text-purple-600 dark:text-purple-400"></i>
                                <span class="text-sm font-medium text-purple-700 dark:text-purple-300">
                                    Total: {{ $spareparts->count() }} Item
                                </span>
                            </div>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900/20 px-4 py-2 rounded-xl border border-red-200 dark:border-red-800">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400"></i>
                                <span class="text-sm font-medium text-red-700 dark:text-red-300">
                                    Stok Rendah: {{ $spareparts->where('stock', '<=', 5)->count() }}
                                </span>
                            </div>
                        </div>
                        <button onclick="toggleModal()" class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-2 rounded-xl transition-all duration-200 hover:shadow-lg font-medium">
                            <i class="fas fa-plus mr-2"></i>Tambah Sparepart
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Filter Section -->
        <div class="mb-6">
            <div class="bg-theme-primary rounded-xl shadow-lg border border-theme p-4">
                <form method="GET" action="{{ route('admin.spareparts.index') }}" class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari sparepart..." 
                               class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent bg-theme-primary text-theme-primary">
                        
                        <select name="stock_filter" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent bg-theme-primary text-theme-primary">
                            <option value="" {{ !request('stock_filter') ? 'selected' : '' }}>Semua Stok</option>
                            <option value="safe" {{ request('stock_filter') == 'safe' ? 'selected' : '' }}>Stok Aman (>10)</option>
                            <option value="restock" {{ request('stock_filter') == 'restock' ? 'selected' : '' }}>Perlu Restock (6-10)</option>
                            <option value="low" {{ request('stock_filter') == 'low' ? 'selected' : '' }}>Stok Rendah (≤5)</option>
                        </select>
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                            <i class="fas fa-search mr-2"></i>Filter
                        </button>
                        <a href="{{ route('admin.spareparts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                            <i class="fas fa-refresh mr-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-theme-primary rounded-xl shadow-lg border border-theme overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-800 border-b border-theme">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-theme-secondary uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-theme-secondary uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-theme-secondary uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-theme-secondary uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-theme-secondary uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-theme-primary divide-y divide-theme">
                        @forelse ($spareparts as $sparepart)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @php
                                            $raw = $sparepart->image ?? null;
                                            $imgUrl = null;
                                            $exists = false;
                                            
                                            if ($raw) {
                                                // cek di disk public (storage/app/public)
                                                $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($raw);
                                                if ($exists) {
                                                    $imgUrl = \Illuminate\Support\Facades\Storage::url($raw);
                                                } else {
                                                    // fallback untuk full URL atau path yang sudah diawali "storage/"
                                                    if (\Illuminate\Support\Str::startsWith($raw, ['http://', 'https://', '/'])) {
                                                        $imgUrl = $raw;
                                                    } elseif (\Illuminate\Support\Str::startsWith($raw, 'storage/')) {
                                                        $imgUrl = asset($raw);
                                                    }
                                                }
                                            }
                                        @endphp

                                        @php $img = $sparepart->image_url ?? $imgUrl ?? null; @endphp

                                        @if($img)
                                            <img class="h-12 w-12 rounded-lg object-cover border border-gray-200"
                                                 src="{{ $img }}"
                                                 alt="{{ $sparepart->name }}"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="h-12 w-12 rounded-lg bg-gray-300 flex items-center justify-center border border-gray-200" style="display:none;">
                                                <i class="fas fa-image text-gray-500"></i>
                                            </div>
                                        @else
                                            <div class="h-12 w-12 rounded-lg bg-gray-300 flex items-center justify-center border border-gray-200">
                                                <i class="fas fa-exclamation-triangle text-gray-500"></i>
                                            </div>
                                        @endif

                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-theme-primary">{{ $sparepart->name }}</div>
                                            <div class="text-sm text-theme-secondary">{{ \Illuminate\Support\Str::limit($sparepart->description, 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-theme-primary">
                                        Rp{{ number_format($sparepart->price, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium {{ $sparepart->stock > 10 ? 'text-green-600' : ($sparepart->stock > 5 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $sparepart->stock }} unit
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($sparepart->stock > 10)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Stok Aman
                                        </span>
                                    @elseif($sparepart->stock > 5)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            Perlu Restock
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Stok Rendah
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <button onclick="openEditModal({{ $sparepart->id }}, '{{ addslashes($sparepart->name) }}', '{{ addslashes($sparepart->description) }}', {{ $sparepart->price }}, {{ $sparepart->stock }})" 
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-200 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="openDeleteModal({{ $sparepart->id }})" 
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200 transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-theme-secondary">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                                        <h3 class="text-lg font-medium mb-2">Tidak ada sparepart</h3>
                                        <p class="text-sm">Mulai tambahkan sparepart untuk ditampilkan di sini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Results Info -->
        @if($spareparts->isNotEmpty())
            <div class="mt-4 text-sm text-theme-secondary text-center">
                Menampilkan {{ $spareparts->count() }} sparepart
                @if(request('search') || request('stock_filter'))
                    dari hasil pencarian/filter
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Modal Create Sparepart -->
<div id="modalSparepart" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 transition-opacity duration-300">
    <div class="bg-theme-primary rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all duration-300 scale-95 opacity-0 modal-content">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-theme-primary">Tambah Sparepart</h3>
                <button onclick="toggleModal()" class="text-theme-secondary hover:text-theme-primary p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form action="{{ route('admin.spareparts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-theme-primary mb-2">Nama Sparepart</label>
                        <input type="text" name="name" required class="w-full px-4 py-3 border border-theme rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-theme-primary text-theme-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-theme-primary mb-2">Deskripsi</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-3 border border-theme rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-theme-primary text-theme-primary"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-theme-primary mb-2">Harga (Rp)</label>
                            <input type="number" name="price" required min="0" class="w-full px-4 py-3 border border-theme rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-theme-primary text-theme-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-theme-primary mb-2">Stok</label>
                            <input type="number" name="stock" required min="0" class="w-full px-4 py-3 border border-theme rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-theme-primary text-theme-primary">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-theme-primary mb-2">Gambar</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-4 py-3 border border-theme rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-theme-primary text-theme-primary">
                    </div>
                </div>
                
                <div class="flex space-x-4 mt-6">
                    <button type="button" onclick="toggleModal()" class="flex-1 px-4 py-3 border border-theme text-theme-primary rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Sparepart -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 transition-opacity duration-300">
    <div class="bg-theme-primary rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all duration-300 scale-95 opacity-0 modal-content">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-theme-primary">Edit Sparepart</h3>
                <button onclick="closeEditModal()" class="text-theme-secondary hover:text-theme-primary p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-theme-primary mb-2">Nama Sparepart</label>
                        <input type="text" id="editName" name="name" required class="w-full px-4 py-3 border border-theme rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-theme-primary text-theme-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-theme-primary mb-2">Deskripsi</label>
                        <textarea id="editDescription" name="description" rows="3" class="w-full px-4 py-3 border border-theme rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-theme-primary text-theme-primary"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-theme-primary mb-2">Harga (Rp)</label>
                            <input type="number" id="editPrice" name="price" required min="0" class="w-full px-4 py-3 border border-theme rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-theme-primary text-theme-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-theme-primary mb-2">Stok</label>
                            <input type="number" id="editStock" name="stock" required min="0" class="w-full px-4 py-3 border border-theme rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-theme-primary text-theme-primary">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-theme-primary mb-2">Gambar</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-4 py-3 border border-theme rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-theme-primary text-theme-primary">
                        <p class="text-xs text-theme-secondary mt-1">Kosongkan jika tidak ingin mengubah gambar</p>
                    </div>
                </div>
                
                <div class="flex space-x-4 mt-6">
                    <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-3 border border-theme text-theme-primary rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete Sparepart -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 transition-opacity duration-300">
    <div class="bg-theme-primary rounded-2xl shadow-2xl w-full max-w-md mx-4 transform transition-all duration-300 scale-95 opacity-0 modal-content">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-red-600">Hapus Sparepart</h3>
                <button onclick="closeDeleteModal()" class="text-theme-secondary hover:text-theme-primary p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="text-center mb-6">
                <div class="bg-red-100 dark:bg-red-900 p-4 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-2xl"></i>
                </div>
                <p class="text-theme-primary text-lg">Apakah Anda yakin ingin menghapus sparepart ini?</p>
                <p class="text-theme-secondary text-sm mt-2">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex space-x-4">
                    <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-3 border border-theme text-theme-primary rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModal() {
        const modal = document.getElementById('modalSparepart');
        const content = modal.querySelector('.modal-content');

        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        } else {
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }
    }

    function openEditModal(id, name, description, price, stock) {
        const modal = document.getElementById('editModal');
        const content = modal.querySelector('.modal-content');
        const form = document.getElementById('editForm');

        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);

        // Set form action
        form.action = '{{ route("admin.spareparts.index") }}/' + id;
        
        // Fill form data
        document.getElementById('editName').value = name || '';
        document.getElementById('editDescription').value = description || '';
        document.getElementById('editPrice').value = price || '';
        document.getElementById('editStock').value = stock || '';
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        const content = modal.querySelector('.modal-content');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function openDeleteModal(sparepartId) {
        const modal = document.getElementById('deleteModal');
        const content = modal.querySelector('.modal-content');
        const form = document.getElementById('deleteForm');

        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);

        form.action = '{{ route("admin.spareparts.index") }}/' + sparepartId;
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const content = modal.querySelector('.modal-content');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Close modals when clicking outside
    ['modalSparepart', 'editModal', 'deleteModal'].forEach(modalId => {
        document.getElementById(modalId)?.addEventListener('click', function(e) {
            if (e.target === this) {
                if (modalId === 'modalSparepart') toggleModal();
                else if (modalId === 'editModal') closeEditModal();
                else if (modalId === 'deleteModal') closeDeleteModal();
            }
        });
    });

    // Auto hide alerts
    setTimeout(function() {
        const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
        alerts.forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s ease-out';
            alert.style.opacity = '0';
            setTimeout(function() {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 500);
        });
    }, 5000);
</script>
@endsection
