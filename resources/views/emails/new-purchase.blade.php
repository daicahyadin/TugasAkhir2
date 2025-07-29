<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Baru - PT. Makassar Raya Motor Cabang Kendari</title>
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
        .info-box {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
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
        <h1>Pembelian Baru</h1>
        <p>PT. Makassar Raya Motor Cabang Kendari</p>
    </div>
    
    <div class="content">
        <h2>Ada pembelian baru yang perlu ditinjau</h2>
        
        <div class="info-box">
            <h3>Detail Pembelian:</h3>
            <p><strong>Kode Tiket:</strong> {{ $purchase->ticket_code }}</p>
            <p><strong>Pelanggan:</strong> {{ $purchase->user->name }}</p>
            <p><strong>Email:</strong> {{ $purchase->user->email }}</p>
            <p><strong>WhatsApp:</strong> {{ $purchase->whatsapp_number }}</p>
            <p><strong>Mobil:</strong> {{ $purchase->car->name }}</p>
            <p><strong>Tim:</strong> {{ $purchase->team }}</p>
            <p><strong>Metode Pembayaran:</strong> {{ ucfirst($purchase->payment_method) }}</p>
            @if($purchase->down_payment)
                <p><strong>DP:</strong> Rp {{ number_format($purchase->down_payment, 0, ',', '.') }}</p>
            @endif
            @if($purchase->loan_term)
                <p><strong>Tenor:</strong> {{ $purchase->loan_term }} bulan</p>
            @endif
            @if($purchase->notes)
                <p><strong>Catatan:</strong> {{ $purchase->notes }}</p>
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
        
        <p>Silakan login ke dashboard admin untuk meninjau dan memproses pembelian ini:</p>
        
        <a href="{{ url('/admin/purchases') }}" class="button">Lihat Dashboard</a>
        
        <p>Terima kasih,<br>
        <strong>Sistem PT. Makassar Raya Motor Cabang Kendari</strong></p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} PT. Makassar Raya Motor Cabang Kendari. All rights reserved.</p>
    </div>
</body>
</html> 