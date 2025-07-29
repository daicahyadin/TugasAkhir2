<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Drive Baru - PT. Makassar Raya Motor Cabang Kendari</title>
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
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
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
        .button {
            display: inline-block;
            background: #3b82f6;
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
        <h1>Test Drive Baru</h1>
        <p>PT. Makassar Raya Motor Cabang Kendari</p>
    </div>
    
    <div class="content">
        <h2>Ada test drive baru yang perlu ditinjau</h2>
        
        <div class="info-box">
            <h3>Detail Test Drive:</h3>
            <p><strong>Kode Tiket:</strong> {{ $testDrive->ticket_code }}</p>
            <p><strong>Pelanggan:</strong> {{ $testDrive->user->name }}</p>
            <p><strong>Email:</strong> {{ $testDrive->user->email }}</p>
            <p><strong>Telepon:</strong> {{ $testDrive->phone }}</p>
            <p><strong>Mobil:</strong> {{ $testDrive->car->name }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($testDrive->preferred_date)->format('d/m/Y') }}</p>
            <p><strong>Waktu:</strong> {{ $testDrive->preferred_time }}</p>
            <p><strong>Telepon:</strong> {{ $testDrive->phone }}</p>
            @if($testDrive->notes)
                <p><strong>Catatan:</strong> {{ $testDrive->notes }}</p>
            @endif
        </div>
        
        <p>Silakan login ke dashboard admin untuk meninjau dan memproses test drive ini:</p>
        
        <a href="{{ url('/admin/testdrives') }}" class="button">Lihat Dashboard</a>
        
        <p>Terima kasih,<br>
        <strong>Sistem PT. Makassar Raya Motor Cabang Kendari</strong></p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} PT. Makassar Raya Motor Cabang Kendari. All rights reserved.</p>
    </div>
</body>
</html> 