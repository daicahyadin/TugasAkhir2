<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status Pembelian - PT. Makassar Raya Motor Cabang Kendari</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .status-box {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .status-approved {
            background: #f0fdf4;
            border-color: #bbf7d0;
        }
        .status-completed {
            background: #f0f9ff;
            border-color: #bae6fd;
        }
        .status-cancelled {
            background: #fef2f2;
            border-color: #fecaca;
        }
        .price-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
        }
        .button {
            display: inline-block;
            background: #10b981;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Update Status Pembelian</h1>
        <p>PT. Makassar Raya Motor Cabang Kendari</p>
    </div>
    
    <div class="content">
        <h2>Halo {{ $purchase->user->name }},</h2>
        
        <p>Status pembelian mobil Anda telah diperbarui:</p>
        
        <div class="status-box status-{{ $purchase->status }}">
            <h3>Detail Pembelian:</h3>
            <p><strong>Kode Tiket:</strong> {{ $purchase->ticket_code }}</p>
            <p><strong>Mobil:</strong> {{ $purchase->car->name }}</p>
            <p><strong>Tim:</strong> {{ $purchase->team }}</p>
            <p><strong>Metode Pembayaran:</strong> {{ ucfirst($purchase->payment_method) }}</p>
            <p><strong>Status:</strong> 
                @if($purchase->status === 'approved')
                    <span style="color: #059669; font-weight: bold;">DISETUJUI</span>
                @elseif($purchase->status === 'completed')
                    <span style="color: #0284c7; font-weight: bold;">SELESAI</span>
                @elseif($purchase->status === 'cancelled')
                    <span style="color: #dc2626; font-weight: bold;">DIBATALKAN</span>
                @else
                    <span style="color: #d97706; font-weight: bold;">PENDING</span>
                @endif
            </p>
            @if($purchase->admin_notes)
                <p><strong>Catatan Admin:</strong> {{ $purchase->admin_notes }}</p>
            @endif
        </div>
        
        <div class="price-box">
            <h3>Informasi Harga:</h3>
            <p><strong>Harga Asli:</strong> Rp {{ number_format($purchase->original_price, 0, ',', '.') }}</p>
            @if($purchase->discount_amount > 0)
                <p><strong>Diskon:</strong> Rp {{ number_format($purchase->discount_amount, 0, ',', '.') }}</p>
            @endif
            <p><strong>Total Bayar:</strong> Rp {{ number_format($purchase->total_price, 0, ',', '.') }}</p>
        </div>
        
        @if($purchase->status === 'approved')
            <p>Pembelian Anda telah disetujui! Tim kami akan menghubungi Anda segera untuk proses selanjutnya.</p>
        @elseif($purchase->status === 'completed')
            <p>Pembelian Anda telah selesai! Mobil akan segera diserahkan kepada Anda.</p>
        @elseif($purchase->status === 'cancelled')
            <p>Pembelian Anda telah dibatalkan. Jika Anda memiliki pertanyaan, silakan hubungi tim kami.</p>
        @endif
        
        <p>Silakan login ke akun Anda untuk melihat detail lengkap:</p>
        
        <a href="{{ url('/dashboard') }}" class="button">Lihat Dashboard</a>
        
        <p>Terima kasih,<br>
        <strong>Tim PT. Makassar Raya Motor Cabang Kendari</strong></p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} PT. Makassar Raya Motor Cabang Kendari. All rights reserved.</p>
    </div>
</body>
</html> 