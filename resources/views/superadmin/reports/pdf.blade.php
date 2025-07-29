<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #dc2626;
            padding-bottom: 20px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 5px;
        }
        .company-subtitle {
            font-size: 14px;
            color: #666;
        }
        .report-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            color: #333;
        }
        .report-info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .report-info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #dc2626;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }
        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }
        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }
        .status-processing {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }
        .status-completed {
            background-color: #d1fae5;
            color: #065f46;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">PT. Makassar Raya Motor</div>
        <div class="company-subtitle">Cabang Kendari</div>
    </div>

    <div class="report-title">{{ $title }}</div>

    <div class="report-info">
        <p><strong>Tanggal Laporan:</strong> {{ date('d/m/Y H:i') }}</p>
        @if($startDate && $endDate)
        <p><strong>Periode:</strong> {{ date('d/m/Y', strtotime($startDate)) }} - {{ date('d/m/Y', strtotime($endDate)) }}</p>
        @endif
        <p><strong>Dibuat oleh:</strong> Super Admin MRM</p>
    </div>

    @if($type === 'all' || $type === 'customers')
    <h3>Data Customer</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Status Verifikasi</th>
                <th>Tanggal Registrasi</th>
            </tr>
        </thead>
        <tbody>
            @if($type === 'all')
                @foreach($data['customers'] as $index => $customer)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>
                        <span class="status-{{ $customer->email_verified_at ? 'approved' : 'pending' }}">
                            {{ $customer->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi' }}
                        </span>
                    </td>
                    <td>{{ date('d/m/Y H:i', strtotime($customer->created_at)) }}</td>
                </tr>
                @endforeach
            @else
                @foreach($data as $index => $customer)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>
                        <span class="status-{{ $customer->email_verified_at ? 'approved' : 'pending' }}">
                            {{ $customer->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi' }}
                        </span>
                    </td>
                    <td>{{ date('d/m/Y H:i', strtotime($customer->created_at)) }}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    @endif

    @if($type === 'all' || $type === 'testdrives')
    @if($type === 'all')
        <div class="page-break"></div>
    @endif
    <h3>Data Test Drive</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Mobil</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Kode Tiket</th>
            </tr>
        </thead>
        <tbody>
            @if($type === 'all')
                @foreach($data['testDrives'] as $index => $testDrive)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $testDrive->user->name }}</td>
                    <td>{{ $testDrive->user->email }}</td>
                    <td>{{ $testDrive->car->name }}</td>
                    <td>{{ date('d/m/Y', strtotime($testDrive->date)) }}</td>
                    <td>{{ $testDrive->time }}</td>
                    <td>
                        <span class="status-{{ $testDrive->status }}">
                            {{ ucfirst($testDrive->status) }}
                        </span>
                    </td>
                    <td>{{ $testDrive->ticket_code }}</td>
                </tr>
                @endforeach
            @else
                @foreach($data as $index => $testDrive)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $testDrive->user->name }}</td>
                    <td>{{ $testDrive->user->email }}</td>
                    <td>{{ $testDrive->car->name }}</td>
                    <td>{{ date('d/m/Y', strtotime($testDrive->date)) }}</td>
                    <td>{{ $testDrive->time }}</td>
                    <td>
                        <span class="status-{{ $testDrive->status }}">
                            {{ ucfirst($testDrive->status) }}
                        </span>
                    </td>
                    <td>{{ $testDrive->ticket_code }}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    @endif

    @if($type === 'all' || $type === 'purchases')
    @if($type === 'all')
        <div class="page-break"></div>
    @endif
    <h3>Data Pembelian</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Mobil</th>
                <th>Metode Pembayaran</th>
                <th>Tim</th>
                <th>WhatsApp</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @if($type === 'all')
                @foreach($data['purchases'] as $index => $purchase)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $purchase->user->name }}</td>
                    <td>{{ $purchase->user->email }}</td>
                    <td>{{ $purchase->car->name }}</td>
                    <td>{{ ucfirst($purchase->payment_method) }}</td>
                    <td>{{ $purchase->team }}</td>
                    <td>{{ $purchase->whatsapp_number }}</td>
                    <td>
                        <span class="status-{{ $purchase->status }}">
                            {{ ucfirst($purchase->status) }}
                        </span>
                    </td>
                    <td>{{ date('d/m/Y H:i', strtotime($purchase->created_at)) }}</td>
                </tr>
                @endforeach
            @else
                @foreach($data as $index => $purchase)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $purchase->user->name }}</td>
                    <td>{{ $purchase->user->email }}</td>
                    <td>{{ $purchase->car->name }}</td>
                    <td>{{ ucfirst($purchase->payment_method) }}</td>
                    <td>{{ $purchase->team }}</td>
                    <td>{{ $purchase->whatsapp_number }}</td>
                    <td>
                        <span class="status-{{ $purchase->status }}">
                            {{ ucfirst($purchase->status) }}
                        </span>
                    </td>
                    <td>{{ date('d/m/Y H:i', strtotime($purchase->created_at)) }}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    @endif

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem PT. Makassar Raya Motor Cabang Kendari</p>
        <p>© {{ date('Y') }} PT. Makassar Raya Motor. All rights reserved.</p>
    </div>
</body>
</html> 