<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            line-height: 1.6;
            color: #111;
            padding: 25px;
            background: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
            padding: 25px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 15px;
        }

        .header h1 {
            font-size: 32px;
            color: #000;
            margin-bottom: 8px;
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 20px;
            color: #374151;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .header p {
            font-size: 11px;
            color: #6b7280;
            font-weight: 500;
        }

        .summary {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            border-spacing: 15px 0;
        }

        .summary-item {
            display: table-cell;
            width: 33.33%;
            padding: 20px;
            background: white;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #e5e7eb;
            border-left: 4px solid #000;
        }

        .summary-item h3 {
            font-size: 10px;
            color: #4b5563;
            margin-bottom: 8px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .summary-item p {
            font-size: 24px;
            font-weight: 900;
            color: #000;
            letter-spacing: -0.5px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 900;
            color: #000;
            margin: 30px 0 20px 0;
            padding: 12px 18px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            display: flex;
            align-items: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        table thead {
            background: #000;
            color: white;
        }

        table th {
            padding: 14px 12px;
            text-align: left;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
            color: #1f2937;
        }

        table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            border: 1px solid #e5e7eb;
        }

        .badge-normal {
            background: #f3f4f6;
            color: #374151;
        }
        
        .badge-dark {
            background: #1f2937;
            color: #fff;
        }

        .footer {
            margin-top: 50px;
            padding-top: 25px;
            border-top: 3px solid #000;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
        }

        .footer p {
            margin: 3px 0;
        }

        .footer strong {
            color: #000;
            font-size: 13px;
        }

        .payment-methods {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            border-spacing: 15px 0;
        }

        .payment-method {
            display: table-cell;
            width: 25%;
            padding: 18px;
            background: white;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #e5e7eb;
            border-top: 3px solid #000;
        }

        .payment-method p {
            font-size: 9px;
            color: #6b7280;
            margin-bottom: 5px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .payment-method h4 {
            font-size: 22px;
            color: #000;
            font-weight: 900;
            margin-bottom: 3px;
        }

        .payment-method .amount {
            font-size: 10px;
            color: #374151;
            font-weight: 700;
        }

        .ranking {
            display: inline-block;
            width: 32px;
            height: 32px;
            background: #000;
            color: white;
            border-radius: 10px;
            text-align: center;
            line-height: 32px;
            font-weight: 900;
            font-size: 14px;
        }

        .highlight {
            font-weight: 900;
            color: #000;
        }

        tfoot {
            background: #f3f4f6;
            color: #000;
            font-weight: 900;
            border-top: 2px solid #000;
        }

        tfoot td {
            padding: 15px 12px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>🏪 KASIR MODERN</h1>
        <h2>{{ $judul }}</h2>
        <p>📅 Dicetak pada: {{ now()->format('d F Y, H:i:s') }}</p>
    </div>

    <!-- Summary -->
    <div class="summary">
        <div class="summary-item">
            <h3>💰 Total Penjualan</h3>
            <p>Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
        </div>
        <div class="summary-item">
            <h3>🛒 Total Transaksi</h3>
            <p>{{ $totalTransaksi }}</p>
        </div>
        <div class="summary-item">
            <h3>📊 Rata-rata</h3>
            <p>Rp {{ $totalTransaksi > 0 ? number_format($totalPenjualan / $totalTransaksi, 0, ',', '.') : 0 }}</p>
        </div>
    </div>

    <!-- Metode Pembayaran -->
    <h2 class="section-title">💳 Metode Pembayaran</h2>
    <div class="payment-methods">
        @foreach($metodePembayaran as $metode => $info)
            <div class="payment-method">
                <p>{{ ucfirst($metode) }}</p>
                <h4>{{ $info['jumlah'] }}</h4>
                <p class="amount">Rp {{ number_format($info['total'], 0, ',', '.') }}</p>
            </div>
        @endforeach
    </div>

    <!-- Menu Terlaris -->
    <h2 class="section-title">🔥 Menu Terlaris (Top 10)</h2>
    <table>
        <thead>
            <tr>
                <th width="8%">Rank</th>
                <th width="40%">Nama Menu</th>
                <th width="20%">Kategori</th>
                <th width="12%" class="text-center">Terjual</th>
                <th width="20%" class="text-right">Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menuTerlaris as $menu)
                <tr>
                    <td class="text-center">
                        <span class="ranking">{{ $loop->iteration }}</span>
                    </td>
                    <td><strong class="highlight">{{ $menu->nama_menu }}</strong></td>
                    <td>
                        <span class="badge badge-normal">{{ $menu->kategori }}</span>
                    </td>
                    <td class="text-center"><strong class="highlight">{{ $menu->total_terjual }}</strong> item</td>
                    <td class="text-right"><strong class="highlight">Rp {{ number_format($menu->total_pendapatan, 0, ',', '.') }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 30px;">
                        <strong>📭 Belum ada data</strong>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Daftar Transaksi -->
    <h2 class="section-title">📋 Daftar Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th width="10%">ID</th>
                <th width="20%">Tanggal</th>
                <th width="25%">Kasir</th>
                <th width="20%">Metode</th>
                <th width="25%" class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $transaksi)
                <tr>
                    <td><strong class="highlight">#{{ $transaksi->id_transaksi }}</strong></td>
                    <td>{{ $transaksi->tanggal->format('d/m/Y H:i') }}</td>
                    <td><strong>{{ $transaksi->kasir->nama_kasir }}</strong></td>
                    <td>
                        <span class="badge 
                            @if($transaksi->metode_pembayaran === 'tunai') badge-normal
                            @elseif($transaksi->metode_pembayaran === 'debit') badge-normal
                            @elseif($transaksi->metode_pembayaran === 'kredit') badge-dark
                            @else badge-dark
                            @endif">
                            {{ ucfirst($transaksi->metode_pembayaran) }}
                        </span>
                    </td>
                    <td class="text-right"><strong class="highlight">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 30px;">
                        <strong>📭 Belum ada transaksi</strong>
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if(count($transaksis) > 0)
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right" style="font-size: 13px;">💎 GRAND TOTAL:</td>
                    <td class="text-right" style="font-size: 15px;">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    <!-- Footer -->
    <div class="footer">
        <p><strong>KASIR MODERN</strong></p>
        <p>📍 Jl. Contoh No. 123, Surabaya, Jawa Timur</p>
        <p>📞 0812-3456-7890 | ✉️ info@kasirmodern.com</p>
        <p style="margin-top: 12px; color: #999;">Laporan ini digenerate secara otomatis oleh sistem</p>
    </div>
</body>
</html>