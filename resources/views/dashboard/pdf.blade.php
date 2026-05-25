<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Inventaris - StockInfo</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            color: #333; 
        }
        .header { 
            border-bottom: 2px solid #1e40af; 
            padding-bottom: 15px; 
            margin-bottom: 25px; 
            text-align: center; 
        }
        .header h1 { 
            margin: 0; 
            color: #1e40af; 
            font-size: 24px; 
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p { 
            margin: 8px 0 0; 
            color: #64748b; 
            font-size: 12px; 
        }
        .summary { 
            margin-bottom: 30px; 
        }
        .summary-table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        .summary-table td { 
            padding: 15px; 
            border: 1px solid #e2e8f0; 
            width: 33.33%; 
            text-align: center; 
            background-color: #f8fafc;
        }
        .summary-table .title { 
            font-weight: bold; 
            font-size: 10px; 
            color: #64748b; 
            text-transform: uppercase; 
            letter-spacing: 1px;
        }
        .summary-table .value { 
            font-size: 20px; 
            font-weight: bold; 
            color: #1e40af; 
            margin-top: 8px; 
        }
        .data-table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        .data-table th, .data-table td { 
            border: 1px solid #e2e8f0; 
            padding: 10px; 
            text-align: left; 
        }
        .data-table th { 
            background-color: #1e40af; 
            color: white; 
            font-size: 10px; 
            text-transform: uppercase; 
            letter-spacing: 1px;
        }
        .data-table tr:nth-child(even) { 
            background-color: #f8fafc; 
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .low-stock { color: #ef4444; font-weight: bold; }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Inventaris</h1>
        <p>Sistem Informasi Manajemen Stok - Dicetak pada: {{ now()->locale('id')->isoFormat('D MMMM YYYY HH:mm') }}</p>
    </div>

    <div class="summary">
        <table class="summary-table">
            <tr>
                <td>
                    <div class="title">Total SKU Aktif</div>
                    <div class="value">{{ number_format($totalSKU, 0, ',', '.') }}</div>
                </td>
                <td>
                    <div class="title">Peringatan Stok Rendah</div>
                    <div class="value" style="color: #ef4444;">{{ number_format($stokRendahCount, 0, ',', '.') }} Produk</div>
                </td>
                <td>
                    <div class="title">Total Nilai Aset</div>
                    <div class="value">Rp {{ number_format($invValue, 0, ',', '.') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="15%">SKU</th>
                <th width="25%">Nama Produk</th>
                <th width="15%">Kategori</th>
                <th class="text-center" width="10%">Stok</th>
                <th class="text-right" width="15%">Harga Satuan</th>
                <th class="text-right" width="15%">Nilai Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produks as $index => $produk)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $produk->sku }}</td>
                <td>{{ $produk->nama }}</td>
                <td>{{ $produk->kategori ? $produk->kategori->nama : 'Umum' }}</td>
                <td class="text-center {{ $produk->stok <= $produk->stok_minimum ? 'low-stock' : '' }}">
                    {{ $produk->stok }}
                </td>
                <td class="text-right">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($produk->stok * $produk->harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini digenerate secara otomatis oleh sistem StockInfo.
    </div>
</body>
</html>
