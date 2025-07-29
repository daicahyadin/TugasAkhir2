<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Status STNK</title>
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
            background-color: #1f2937;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 0 0 8px 8px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
        }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-processing { background-color: #dbeafe; color: #1e40af; }
        .status-completed { background-color: #d1fae5; color: #065f46; }
        .status-rejected { background-color: #fee2e2; color: #991b1b; }
        .info-box {
            background-color: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            margin: 15px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PT. Makassar Raya Motor Cabang Kendari</h1>
        <p>Update Status STNK</p>
    </div>
    
    <div class="content">
        <p>Halo <strong>{{ $stnk->purchase->user->name }}</strong>,</p>
        
        <p>Status STNK untuk pembelian mobil Anda telah diperbarui:</p>
        
        <div class="info-box">
            <h3>Detail Pembelian:</h3>
            <p><strong>Mobil:</strong> {{ $stnk->purchase->car->name }}</p>
            <p><strong>Status STNK:</strong> 
                <span class="status-badge status-{{ $stnk->status }}">
                    {{ $stnk->status_label }}
                </span>
            </p>
            @if($stnk->plate_number)
                <p><strong>Nomor Polisi:</strong> {{ $stnk->plate_number }}</p>
            @endif
            @if($stnk->estimated_completion)
                <p><strong>Estimasi Selesai:</strong> {{ date('d/m/Y', strtotime($stnk->estimated_completion)) }}</p>
            @endif
            @if($stnk->notes)
                <p><strong>Catatan:</strong> {{ $stnk->notes }}</p>
            @endif
        </div>
        
        <p>Tim kami akan terus memantau proses pembuatan STNK Anda. Jika ada pertanyaan, silakan hubungi kami.</p>
        
        <p>Terima kasih telah mempercayai PT. Makassar Raya Motor Cabang Kendari.</p>
        
        <p>Salam,<br>
        <strong>Tim PT. Makassar Raya Motor Cabang Kendari</strong></p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim otomatis. Mohon tidak membalas email ini.</p>
        <p>© {{ date('Y') }} PT. Makassar Raya Motor Cabang Kendari. All rights reserved.</p>
    </div>
</body>
</html> 