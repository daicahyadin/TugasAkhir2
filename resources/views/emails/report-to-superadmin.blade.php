<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan dari Admin - PT. Makassar Raya Motor Cabang Kendari</title>
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
            background: linear-gradient(135deg, #dc2626, #b91c1c);
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
            background: #dc2626;
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
        <h1>Laporan dari Admin</h1>
        <p>PT. Makassar Raya Motor Cabang Kendari</p>
    </div>
    
    <div class="content">
        <h2>Halo {{ $superAdmin->name }},</h2>
        
        <p>Admin {{ $admin->name }} telah mengirimkan laporan kepada Anda:</p>
        
        <div class="info-box">
            <h3>Detail Laporan:</h3>
            <p><strong>Dari Admin:</strong> {{ $admin->name }} ({{ $admin->email }})</p>
            <p><strong>Jenis Laporan:</strong> 
                @if($type === 'testdrives')
                    Test Drive
                @elseif($type === 'purchases')
                    Pembelian
                @else
                    Semua Data
                @endif
            </p>
            @if($startDate && $endDate)
                <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
            @endif
            @if($notes)
                <p><strong>Catatan:</strong> {{ $notes }}</p>
            @endif
            <p><strong>Tanggal Kirim:</strong> {{ now()->format('d/m/Y H:i') }}</p>
        </div>
        
        <p>Laporan lengkap telah dilampirkan dalam format PDF. Silakan login ke dashboard super admin untuk melihat detail lebih lanjut:</p>
        
        <a href="{{ url('/superadmin/reports') }}" class="button">Lihat Dashboard</a>
        
        <p>Terima kasih,<br>
        <strong>Sistem PT. Makassar Raya Motor Cabang Kendari</strong></p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} PT. Makassar Raya Motor Cabang Kendari. All rights reserved.</p>
    </div>
</body>
</html> 