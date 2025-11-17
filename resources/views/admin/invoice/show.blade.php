
@extends('layouts.admin')

@section('title', 'Detail Riwayat Customer')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.invoices.index') }}" class="text-white hover:text-blue-200">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold">Riwayat Customer</h1>
                    <p class="text-blue-100">{{ $invoice->customer_name }} - {{ $invoice->invoice_number }}</p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-xl font-bold">Rp{{ number_format($invoice->total, 0, ',', '.') }}</div>
                <div class="text-blue-100">Total Pembelian</div>
            </div>
        </div>
    </div>

    <!-- Customer Info -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Customer Details -->
            <div class="flex items-center space-x-4">
                <div class="h-16 w-16 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold text-2xl">
                    {{ strtoupper(substr($invoice->customer_name, 0, 1)) }}
                </div>
                <div>
                    <h3 class="font-bold text-lg">{{ $invoice->customer_name }}</h3>
                    <p class="text-gray-600">{{ $invoice->customer_email }}</p>
                    @if($invoice->customer_phone !== 'N/A')
                        <p class="text-gray-600">📞 {{ $invoice->customer_phone }}</p>
                    @endif
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-blue-50 rounded-lg p-4">
                <div class="text-blue-600 font-medium">Total Transaksi</div>
                <div class="text-2xl font-bold text-blue-800">{{ $invoice->stats['total_transactions'] }}</div>
            </div>

            <div class="bg-green-50 rounded-lg p-4">
                <div class="text-green-600 font-medium">Total Booking</div>
                <div class="text-2xl font-bold text-green-800">{{ $invoice->stats['total_bookings'] }}</div>
            </div>

            <div class="bg-purple-50 rounded-lg p-4">
                <div class="text-purple-600 font-medium">Total Sparepart</div>
                <div class="text-2xl font-bold text-purple-800">{{ $invoice->stats['total_spareparts'] }}</div>
            </div>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold">Riwayat Transaksi</h2>
            <div class="flex space-x-2">
                <button onclick="printHistory()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-print mr-2"></i>Print
                </button>
                <button onclick="exportHistory()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-download mr-2"></i>Export
                </button>
            </div>
        </div>

        <div class="space-y-4">
            @forelse ($invoice->history as $transaction)
                <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="h-12 w-12 rounded-full {{ $transaction->type === 'booking' ? 'bg-blue-100' : 'bg-purple-100' }} flex items-center justify-center">
                                <i class="fas {{ $transaction->type === 'booking' ? 'fa-wrench text-blue-600' : 'fa-cog text-purple-600' }}"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">{{ $transaction->title }}</h4>
                                <p class="text-gray-600">{{ $transaction->description }}</p>
                                <p class="text-sm text-gray-500">{{ $transaction->details }}</p>
                                <div class="flex items-center space-x-4 mt-1">
                                    <span class="text-xs text-gray-500">{{ $transaction->invoice_number }}</span>
                                    <span class="text-xs text-gray-500">{{ $transaction->date->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-lg">Rp{{ number_format($transaction->amount, 0, ',', '.') }}</div>
                            @php
                                $statusConfig = [
                                    'completed' => ['class' => 'bg-green-100 text-green-800', 'text' => 'Selesai'],
                                    'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'text' => 'Pending'],
                                    'processing' => ['class' => 'bg-blue-100 text-blue-800', 'text' => 'Diproses'],
                                ];
                                $config = $statusConfig[$transaction->status] ?? $statusConfig['completed'];
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $config['class'] }}">
                                {{ $config['text'] }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <i class="fas fa-file-invoice text-gray-300 text-4xl mb-4"></i>
                    <p class="text-gray-500">Belum ada riwayat transaksi</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
function printHistory() {
    window.print();
}

function exportHistory() {
    alert('Export riwayat transaksi sedang diproses...');
}
</script>
@endsection