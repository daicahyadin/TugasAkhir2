<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status Test Drive - PT. Makassar Raya Motor Cabang Kendari</title>
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
        .status-rejected {
            background: #fef2f2;
            border-color: #fecaca;
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
        <h1>Update Status Test Drive</h1>
        <p>PT. Makassar Raya Motor Cabang Kendari</p>
    </div>
    
    <div class="content">
        <h2>Halo {{ $testDrive->user->name }},</h2>
        
        <p>Status test drive Anda telah diperbarui:</p>
        
        <div class="status-box status-{{ $testDrive->status }}">
            <h3>Detail Test Drive:</h3>
            <p><strong>Kode Tiket:</strong> {{ $testDrive->ticket_code }}</p>
            <p><strong>Mobil:</strong> {{ $testDrive->car->name }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($testDrive->preferred_date)->format('d/m/Y') }}</p>
            <p><strong>Waktu:</strong> {{ $testDrive->preferred_time }}</p>
            <p><strong>Status:</strong> 
                @if($testDrive->status === 'approved')
                    <span style="color: #059669; font-weight: bold;">DISETUJUI</span>
                @elseif($testDrive->status === 'completed')
                    <span style="color: #0284c7; font-weight: bold;">SELESAI</span>
                @elseif($testDrive->status === 'rejected')
                    <span style="color: #dc2626; font-weight: bold;">DITOLAK</span>
                @else
                    <span style="color: #d97706; font-weight: bold;">PENDING</span>
                @endif
            </p>
            @if($testDrive->admin_notes)
                <p><strong>Catatan Admin:</strong> {{ $testDrive->admin_notes }}</p>
            @endif
        </div>
        
        @if($testDrive->status === 'approved')
            <p>Test drive Anda telah disetujui! Tim kami akan menghubungi Anda segera untuk mengatur jadwal test drive.</p>
        @elseif($testDrive->status === 'completed')
            <p>Test drive Anda telah selesai. Terima kasih telah menggunakan layanan kami!</p>
        @elseif($testDrive->status === 'rejected')
            <p>Test drive Anda telah ditolak. Jika Anda memiliki pertanyaan, silakan hubungi tim kami.</p>
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