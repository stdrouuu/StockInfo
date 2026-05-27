<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok Opname</title>
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
        <h2>Laporan Stok Opname</h2>
        <p>Periode: {{ $periode ? $periode->tanggal_mulai->format('d/m/Y') . ' - ' . $periode->tanggal_selesai->format('d/m/Y') : '-' }}</p>
        <p>Keterangan: {{ $periode->keterangan ?? '-' }}</p>
        <p>Status: {{ $periode ? ucfirst(str_replace('_', ' ', $periode->status_pelaporan)) : '-' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Stok Sistem</th>
                <th>Stok Fisik</th>
                <th>Selisih</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->produk->sku ?? '-' }}</td>
                <td>{{ $item->produk->nama ?? '-' }}</td>
                <td>{{ $item->produk->kategori->nama ?? '-' }}</td>
                <td>{{ $item->stok_sistem }}</td>
                <td>{{ $item->stok_fisik }}</td>
                <td>
                    @if($item->selisih > 0)
                        <span style="color: green;">+{{ $item->selisih }}</span>
                    @elseif($item->selisih < 0)
                        <span style="color: red;">{{ $item->selisih }}</span>
                    @else
                        0
                    @endif
                </td>
                <td>{{ $item->catatan }}</td>
            </tr>
            @endforeach
            @if($items->isEmpty())
            <tr>
                <td colspan="7" class="text-center">Tidak ada data item stok opname.</td>
            </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
