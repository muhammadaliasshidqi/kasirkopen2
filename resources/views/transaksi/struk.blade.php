<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $transaksi->id_transaksi }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.5;
            padding: 20px;
            max-width: 320px;
            margin: 0 auto;
            background: #1f2937;
            min-height: 100vh;
        }

        .receipt-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px dashed #000003;
        }

        .header h1 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #000003;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .header p {
            font-size: 10px;
            margin: 3px 0;
            color: #666;
        }

        .section {
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            padding: 5px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .info-row span:first-child {
            color: #666;
            font-weight: 600;
        }

        .info-row span:last-child {
            font-weight: bold;
            color: #333;
        }

        .divider {
            border-top: 1px dashed #ddd;
            margin: 15px 0;
        }

        .divider-double {
            border-top: 2px solid #000003;
            margin: 15px 0;
        }

        .items {
            margin: 15px 0;
        }

        .item {
            margin: 8px 0;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 3px solid #000003;
        }

        .item-name {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .item-detail {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #666;
        }

        .item-detail span:last-child {
            font-weight: bold;
            color: #000003;
        }

        .total-section {
            margin-top: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 15px;
            border-radius: 10px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            font-size: 13px;
        }

        .total-row.grand {
            font-size: 18px;
            font-weight: bold;
            padding-top: 10px;
            margin-top: 10px;
            border-top: 2px solid #000003;
            color: #000003;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 2px dashed #000003;
        }

        .footer .thank-you {
            font-size: 16px;
            font-weight: bold;
            color: #000003;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer p {
            font-size: 10px;
            color: #666;
            margin: 5px 0;
        }

        .footer .note {
            margin-top: 15px;
            padding: 10px;
            background: #fff3cd;
            border-radius: 5px;
            border: 1px dashed #ffc107;
            font-size: 9px;
            color: #856404;
        }

        @media print {
            body {
                padding: 0;
                background: white;
            }
            
            .receipt-container {
                box-shadow: none;
            }
            
            .no-print {
                display: none !important;
            }
        }

        .print-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, #000003 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 18px 35px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
        }

        .print-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(102, 126, 234, 0.5);
        }

        .print-button:active {
            transform: translateY(-1px);
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-tunai { background: #d4edda; color: #155724; }
        .badge-qris { background: #e7d4f7; color: #6f42c1; }
    </style>
</head>
<body>
    <!-- Print Button -->
    <button onclick="window.print()" class="print-button no-print">
        🖨️ Print Struk
    </button>

    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <h1>🏪 Kasir Kopen</h1>
            <p>Jl. Raya PUK Balen, suwaloh, kec Balen</p>
            <p>📞 Telp: 0812-3456-7890</p>
            <p>📧 Email: info@kasirkopen.com</p>
        </div>

        <!-- Transaction Info -->
        <div class="section">
            <div class="info-row">
                <span>No. Transaksi</span>
                <span>#{{ $transaksi->id_transaksi }}</span>
            </div>
            <div class="info-row">
                <span>📅 Tanggal</span>
                <span>{{ $transaksi->tanggal->format('d/m/Y') }}</span>
            </div>
            <div class="info-row">
                <span>🕐 Waktu</span>
                <span>{{ $transaksi->created_at->format('H:i:s') }}</span>
            </div>
            <div class="info-row">
                <span>👤 Kasir</span>
                <span>{{ $transaksi->kasir->nama_kasir }}</span>
            </div>
            <div class="info-row">
                <span>💳 Pembayaran</span>
                <span class="badge badge-{{ $transaksi->metode_pembayaran }}">
                    {{ strtoupper($transaksi->metode_pembayaran) }}
                </span>
            </div>
        </div>

        <div class="divider-double"></div>

        <!-- Items -->
        <div class="items">
            @foreach($transaksi->detailTransaksi as $detail)
                <div class="item">
                    <div class="item-name">{{ $detail->menu->nama_menu }}</div>
                    <div class="item-detail">
                        <span>{{ $detail->jumlah }} x Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</span>
                        <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="divider-double"></div>

        <!-- Totals -->
        <div class="total-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span><strong>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</strong></span>
            </div>
            <div class="total-row grand">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
            </div>
            <div class="divider"></div>
            <div class="total-row">
                <span>💵 Bayar:</span>
                <span><strong>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</strong></span>
            </div>
            <div class="total-row" style="color: #28a745; font-weight: bold;">
                <span>💰 Kembalian:</span>
                <span>Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="thank-you">✨ Terima Kasih ✨</p>
            <p style="font-weight: 600;">Atas kunjungan Anda</p>
            <p style="margin-top: 10px;">Semoga hari Anda menyenangkan!</p>
            
            <div class="note">
                ⚠️ Barang yang sudah dibeli tidak dapat ditukar/dikembalikan
            </div>
            
            <p style="margin-top: 15px; font-size: 9px; color: #999;">
                Dicetak: {{ now()->format('d/m/Y H:i:s') }}
            </p>
        </div>
    </div>

    <script>
        // Optional: Auto print on load
        // window.onload = function() {
        //     window.print();
        // }
    </script>
</body>
</html>