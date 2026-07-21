<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $penyewaan->id }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 30px 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td {
            vertical-align: top;
        }
        .brand {
            font-size: 20px;
            font-weight: bold;
            color: #d97706;
        }
        .muted {
            color: #6b7280;
        }
        .invoice-title {
            font-size: 22px;
            font-weight: bold;
            text-align: right;
        }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 4px;
        }
        .divider {
            border-top: 1px solid #e5e7eb;
            margin: 20px 0;
        }
        .detail-table {
            margin-top: 15px;
            border: 1px solid #e5e7eb;
        }
        .detail-table th {
            background-color: #f3f4f6;
            text-align: left;
            padding: 8px 10px;
            font-size: 11px;
            text-transform: uppercase;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .text-right {
            text-align: right;
        }
        .total-row td {
            font-weight: bold;
            font-size: 14px;
            background-color: #fffbeb;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }
        .badge-lunas {
            background-color: #d1fae5;
            color: #065f46;
        }
        .badge-belum {
            background-color: #fef3c7;
            color: #92400e;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #9ca3af;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="container">

        <table class="header-table">
            <tr>
                <td width="50%">
                    <div class="brand">RentApp</div>
                    <div class="muted">Sistem Manajemen Penyewaan Kendaraan</div>
                </td>
                <td width="50%">
                    <div class="invoice-title">INVOICE</div>
                    <div class="muted text-right">No. INV-{{ str_pad($penyewaan->id, 5, '0', STR_PAD_LEFT) }}</div>
                    <div class="muted text-right">Tanggal: {{ now()->format('d M Y') }}</div>
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <table class="header-table">
            <tr>
                <td width="50%">
                    <div class="section-title">Ditagihkan Kepada</div>
                    <div><strong>{{ $penyewaan->user->name ?? '-' }}</strong></div>
                    <div class="muted">{{ $penyewaan->user->email ?? '-' }}</div>
                </td>
                <td width="50%">
                    <div class="section-title">Status Transaksi</div>
                    <div><strong>{{ $penyewaan->status }}</strong></div>
                    <div class="section-title" style="margin-top: 8px;">Status Pembayaran</div>
                    @if(($penyewaan->pembayaran->status ?? null) === 'Paid')
                        <span class="badge badge-lunas">LUNAS</span>
                    @else
                        <span class="badge badge-belum">{{ $penyewaan->pembayaran->status ?? 'BELUM DIBAYAR' }}</span>
                    @endif
                </td>
            </tr>
        </table>

        <table class="detail-table">
            <thead>
                <tr>
                    <th>Kendaraan</th>
                    <th>Tanggal Sewa</th>
                    <th>Lama Sewa</th>
                    <th class="text-right">Harga / Hari</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $penyewaan->kendaraan->nama ?? '-' }}</strong><br>
                        <span class="muted">{{ $penyewaan->kendaraan->merk ?? '-' }} &bull; {{ $penyewaan->kendaraan->plat_nomor ?? '-' }}</span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($penyewaan->tanggal_sewa)->format('d M Y') }}</td>
                    <td>{{ $penyewaan->lama_sewa }} hari</td>
                    <td class="text-right">Rp {{ number_format($penyewaan->kendaraan->harga_sewa ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($penyewaan->total_harga, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="4" class="text-right">TOTAL</td>
                    <td class="text-right">Rp {{ number_format($penyewaan->total_harga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        @if($penyewaan->pembayaran)
            <table class="header-table" style="margin-top: 20px;">
                <tr>
                    <td width="50%">
                        <div class="section-title">Metode Pembayaran</div>
                        <div>{{ $penyewaan->pembayaran->payment_method ?? '-' }}</div>
                    </td>
                    <td width="50%">
                        <div class="section-title">Dibayar Pada</div>
                        <div>{{ optional($penyewaan->pembayaran->paid_at)->format('d M Y, H:i') ?? '-' }}</div>
                    </td>
                </tr>
            </table>
        @endif

        <div class="footer">
            Invoice ini dibuat otomatis oleh sistem dan sah tanpa tanda tangan basah.<br>
            Terima kasih telah menggunakan layanan RentApp.
        </div>

    </div>
</body>
</html>