<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .text-center { text-align: center; }
        .header { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Transaksi Masuk & Keluar</h2>
        <p>Tipe: {{ $tipe == 'all' ? 'Semua' : ucfirst($tipe) }}</p>
        <p>Periode: {{ $tanggal_mulai ? \Carbon\Carbon::parse($tanggal_mulai)->format('d/m/Y') : '-' }} s/d {{ $tanggal_selesai ? \Carbon\Carbon::parse($tanggal_selesai)->format('d/m/Y') : '-' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No Referensi</th>
                <th>Tipe</th>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksiItems as $item)
            <tr>
                <td>{{ $item->transaksi->tanggal ? $item->transaksi->tanggal->format('d/m/Y') : '-' }}</td>
                <td>{{ $item->transaksi->kode }}</td>
                <td>{{ ucfirst($item->transaksi->tipe) }}</td>
                <td>{{ $item->produk->nama ?? '-' }}</td>
                <td>{{ $item->qty }}</td>
                <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                <td>{{ $item->transaksi->keterangan }}</td>
            </tr>
            @endforeach
            @if($transaksiItems->isEmpty())
            <tr>
                <td colspan="8" class="text-center">Tidak ada data transaksi.</td>
            </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
