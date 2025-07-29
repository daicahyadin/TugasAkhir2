<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di PT. Makassar Raya Motor Cabang Kendari</title>
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
        <h1>Selamat Datang!</h1>
        <p>PT. Makassar Raya Motor Cabang Kendari</p>
    </div>
    
    <div class="content">
        <h2>Halo {{ $user->name }},</h2>
        
        <p>Terima kasih telah mendaftar di sistem penjualan mobil PT. Makassar Raya Motor Cabang Kendari. Akun Anda telah berhasil dibuat dan diverifikasi.</p>
        
        <h3>Apa yang bisa Anda lakukan?</h3>
        <ul>
            <li>Melihat katalog mobil yang tersedia</li>
            <li>Mengajukan test drive</li>
            <li>Melakukan pembelian mobil</li>
            <li>Melihat status pembelian dan STNK</li>
        </ul>
        
        <p>Silakan login ke akun Anda untuk mulai menjelajahi layanan kami:</p>
        
        <a href="{{ url('/login') }}" class="button">Login Sekarang</a>
        
        <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi tim kami.</p>
        
        <p>Salam,<br>
        <strong>Tim PT. Makassar Raya Motor Cabang Kendari</strong></p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
        <p>&copy; {{ date('Y') }} PT. Makassar Raya Motor Cabang Kendari. All rights reserved.</p>
    </div>
</body>
</html> 