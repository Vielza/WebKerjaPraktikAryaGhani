<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order #{{ $order->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            font-family: Arial, sans-serif; 
            font-size: 11px; 
            line-height: 1.4;
            color: #333;
            background: #fff;
        }
        
        .container {
            max-width: 100%;
            margin: 0;
            padding: 15px;
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            margin-bottom: 15px;
            border-radius: 8px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 12px;
            opacity: 0.9;
        }
        
        /* Company Info */
        .company-info {
            background: #f8f9fa;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            border-left: 4px solid #667eea;
        }
        
        .company-info h3 {
            color: #667eea;
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .company-info p {
            font-size: 10px;
            margin: 2px 0;
        }
        
        /* Flex Container */
        .flex-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            gap: 15px;
        }
        
        .info-card {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 12px;
            flex: 1;
        }
        
        .info-card h4 {
            color: #495057;
            font-size: 12px;
            margin-bottom: 8px;
            border-bottom: 1px solid #667eea;
            padding-bottom: 4px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
            font-size: 10px;
        }
        
        .info-label {
            font-weight: 600;
            color: #6c757d;
            min-width: 80px;
        }
        
        .info-value {
            color: #495057;
            font-weight: 500;
            text-align: right;
        }
        
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d4edda; color: #155724; }
        .status-processing { background: #d1ecf1; color: #0c5460; }
        .status-shipped { background: #e2e3e5; color: #383d41; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-canceled { background: #f8d7da; color: #721c24; }
        
        /* Items Table */
        .items-section {
            margin-top: 15px;
        }
        
        .section-title {
            background: #667eea;
            color: white;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 6px 6px 0 0;
            margin: 0;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 0 0 6px 6px;
            overflow: hidden;
            border: 1px solid #dee2e6;
        }
        
        .items-table th {
            background: #f8f9fa;
            color: #495057;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .items-table td {
            padding: 6px;
            border-bottom: 1px solid #f1f3f4;
            font-size: 10px;
        }
        
        .items-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .item-name {
            font-weight: 600;
            color: #495057;
            font-size: 10px;
        }
        
        .item-desc {
            font-size: 9px;
            color: #6c757d;
            margin-top: 2px;
        }
        
        .qty-badge {
            background: #17a2b8;
            color: white;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .price {
            font-weight: 600;
            color: #28a745;
            font-size: 10px;
        }
        
        .total-row {
            background: #667eea !important;
            color: white !important;
        }
        
        .total-row td {
            padding: 8px 6px !important;
            font-size: 11px !important;
            font-weight: bold !important;
        }
        
        .summary-row {
            background: #f8f9fa !important;
        }
        
        .summary-row td {
            font-weight: bold !important;
            color: #495057 !important;
            font-size: 10px !important;
        }
        
        /* Footer */
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
            padding-top: 10px;
        }
        
        .footer strong {
            color: #495057;
        }
        
        /* Remove animations and effects for PDF */
        .header::before {
            display: none;
        }
        
        @keyframes slide {
            0% { transform: translateX(0); }
            100% { transform: translateX(0); }
        }
        
        /* Compact spacing */
        h1, h2, h3, h4, h5, h6 {
            margin: 0;
        }
        
        p {
            margin: 2px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>INVOICE ORDER #{{ $order->id }}</h1>
            <p>{{ $order->created_at ? $order->created_at->format('d F Y, H:i') : 'N/A' }} WIB</p>
        </div>

        <!-- Company Info -->
        <div class="company-info">
            <h3>Harum Motor</h3>
            <p><strong>Alamat:</strong> Jl. Motor Racing No. 123, Jakarta Selatan</p>
            <p><strong>Telepon:</strong> (021) 1234-5678 | <strong>WhatsApp:</strong> +62 812-3456-7890</p>
            <p><strong>Email:</strong> info@wepkape.com | <strong>Website:</strong> www.wepkape.com</p>
        </div>

        <!-- Customer & Order Info -->
        <div class="flex-container">
            <div class="info-card">
                <h4>Informasi Customer</h4>
                <div class="info-row">
                    <span class="info-label">Nama:</span>
                    <span class="info-value">{{ $order->user->name ?? 'Unknown Customer' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $order->user->email ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Telepon:</span>
                    <span class="info-value">{{ $order->user->phone ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Customer ID:</span>
                    <span class="info-value">#{{ $order->user_id ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="info-card">
                <h4>Detail Pesanan</h4>
                <div class="info-row">
                    <span class="info-label">Order ID:</span>
                    <span class="info-value">#{{ $order->id }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal:</span>
                    <span class="info-value">{{ $order->created_at ? $order->created_at->format('d M Y') : 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        @php
                            $statusClass = 'status-' . ($order->status ?? 'pending');
                            $statusText = [
                                'pending' => 'Menunggu',
                                'confirmed' => 'Dikonfirmasi', 
                                'processing' => 'Diproses',
                                'shipped' => 'Dikirim',
                                'delivered' => 'Selesai',
                                'canceled' => 'Dibatalkan'
                            ][$order->status ?? 'pending'] ?? ucfirst($order->status ?? 'pending');
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total Item:</span>
                    <span class="info-value">{{ $order->orderDetails ? $order->orderDetails->count() : 0 }} jenis</span>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="items-section">
            <h3 class="section-title">Daftar Item Pesanan</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 45%">Nama Item</th>
                        <th style="width: 10%; text-align: center">Qty</th>
                        <th style="width: 20%; text-align: right">Harga Satuan</th>
                        <th style="width: 25%; text-align: right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @if($order->orderDetails && $order->orderDetails->count() > 0)
                        @foreach($order->orderDetails as $detail)
                        <tr>
                            <td>
                                <div class="item-name">{{ $detail->sparepart->name ?? 'Unknown Item' }}</div>
                                @if($detail->sparepart && $detail->sparepart->description)
                                    <div class="item-desc">{{ Str::limit($detail->sparepart->description, 50) }}</div>
                                @endif
                            </td>
                            <td style="text-align: center">
                                <span class="qty-badge">{{ $detail->quantity ?? 0 }}</span>
                            </td>
                            <td style="text-align: right" class="price">
                                Rp{{ number_format($detail->price ?? 0, 0, ',', '.') }}
                            </td>
                            <td style="text-align: right" class="price">
                                <strong>Rp{{ number_format($detail->subtotal ?? 0, 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                        @endforeach
                        
                        <!-- Summary Rows -->
                        <tr class="summary-row">
                            <td colspan="3" style="text-align: right;">
                                <strong>Total Quantity:</strong>
                            </td>
                            <td style="text-align: right;">
                                <strong>{{ $order->orderDetails->sum('quantity') }} pcs</strong>
                            </td>
                        </tr>
                        <tr class="summary-row">
                            <td colspan="3" style="text-align: right;">
                                <strong>Subtotal:</strong>
                            </td>
                            <td style="text-align: right;">
                                <strong>Rp{{ number_format($order->orderDetails->sum('subtotal'), 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="3" style="text-align: right;">
                                <strong>TOTAL PEMBAYARAN:</strong>
                            </td>
                            <td style="text-align: right;">
                                <strong>Rp{{ number_format($order->total_price ?? 0, 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 20px; color: #6c757d;">
                                <strong>Tidak ada item dalam pesanan ini</strong>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Terima kasih telah berbelanja di WEP KAPE!</strong></p>
            <p>Invoice ini digenerate secara otomatis pada {{ now()->format('d F Y, H:i') }} WIB</p>
            <p>Untuk pertanyaan, hubungi kami di <strong>(021) 1234-5678</strong> atau <strong>info@wepkape.com</strong></p>
            <p style="margin-top: 8px; font-style: italic;">
                "Sparepart Original, Kualitas Terjamin, Harga Terjangkau"
            </p>
        </div>
    </div>
</body>
</html>