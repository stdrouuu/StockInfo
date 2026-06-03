<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Jalan - {{ $transaksi->kode }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000000;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 10px;
        }
        .header-table {
            width: 100%;
            margin-bottom: 5px;
        }
        .company-name {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .company-address {
            font-size: 9px;
            color: #333;
        }
        .document-title {
            font-size: 22px;
            font-weight: bold;
            text-align: right;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-bottom: 2px;
        }
        .title-underline {
            border-bottom: 2px solid #000000;
            margin-bottom: 15px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        .meta-table td {
            vertical-align: top;
            padding: 2px;
        }
        .label {
            font-weight: bold;
            width: 100px;
        }
        .value {
            width: 200px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .items-table th {
            border: 1px solid #000000;
            padding: 6px;
            font-weight: bold;
            font-size: 10px;
            text-align: center;
        }
        .items-table td {
            border: 1px solid #000000;
            padding: 6px;
            font-size: 10px;
            vertical-align: top;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .note-box {
            width: 100%;
            border: 1px solid #000000;
            margin-bottom: 20px;
        }
        .note-box td {
            padding: 8px;
            vertical-align: top;
            font-size: 9px;
        }
        .attention-list {
            margin: 0;
            padding-left: 15px;
        }
        .sign-header {
            font-size: 9px;
            font-style: italic;
            margin-bottom: 40px;
        }
        .signature-table {
            width: 100%;
            margin-top: 20px;
        }
        .signature-table td {
            text-align: center;
            font-size: 10px;
            width: 33.3%;
        }
        .signature-space {
            height: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <table class="header-table">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div class="company-name">STOCKINFO</div>
                    <div class="company-address">Jl. Industri Pergudangan Utama No. 42, Jakarta</div>
                </td>
                <td style="width: 50%; vertical-align: bottom;">
                    <div class="document-title">SURAT JALAN</div>
                </td>
            </tr>
        </table>
        
        <div class="title-underline"></div>

        <!-- Meta Info -->
        <table class="meta-table">
            <tr>
                <!-- Left Column (Recipient) -->
                <td style="width: 55%;">
                    <table style="width: 100%;">
                        <tr>
                            <td class="label" style="width: 80px;">Kepada Yth.</td>
                            <td>:</td>
                            <td class="value" style="font-weight: bold;">{{ $transaksi->tujuan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Alamat</td>
                            <td>:</td>
                            <td class="value">{{ $transaksi->alamat ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
                <!-- Right Column (DO Info) -->
                <td style="width: 45%;">
                    <table style="width: 100%;">
                        <tr>
                            <td class="label" style="width: 110px;">No. Surat Jalan</td>
                            <td>:</td>
                            <td class="value" style="font-weight: bold;">{{ 'SJ-' . $transaksi->kode }}</td>
                        </tr>
                        <tr>
                            <td class="label">Tanggal</td>
                            <td>:</td>
                            <td class="value">{{ $transaksi->tanggal->locale('id')->isoFormat('DD MMMM YYYY') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 10%;" class="text-center">No</th>
                    <th style="width: 50%;" class="text-center">Nama Barang</th>
                    <th style="width: 15%;" class="text-center">Qty</th>
                    <th style="width: 25%;" class="text-center">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php $totalQty = 0; @endphp
                @foreach($prosesItems as $index => $row)
                @php $qty = $row->transaksi->items->where('produk_id', $row->produk_id)->first()->qty ?? 0; @endphp
                @php $totalQty += $qty; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td style="font-weight: bold;">{{ $row->produk->nama ?? 'Tidak Ada' }}</td>
                    <td class="text-center" style="font-weight: bold;">{{ $qty }}</td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Attention & Total Box -->
        <table class="note-box">
            <tr>
                <td style="width: 50%; border-right: 1px solid #000000;">
                    <strong>Catatan:</strong><br>
                    <br>
                    <br>
                    <br>
                </td>
                <td style="width: 50%;">
                    <strong>PERHATIAN:</strong>
                    <ol class="attention-list">
                        <li>Surat Jalan ini merupakan bukti resmi penerimaan barang.</li>
                        <li>Surat Jalan ini bukan bukti penjualan.</li>
                        <li>Surat Jalan ini akan dilengkapi Invoice sebagai bukti penjualan resmi.</li>
                    </ol>
                </td>
            </tr>
        </table>

        <!-- Footer / Sign-off -->
        <div class="sign-header">
            BARANG SUDAH DITERIMA DALAM KEADAAN BAIK DAN CUKUP oleh:<br>
            (tanda tangan dan cap (stempel) perusahaan)
        </div>

        <table class="signature-table">
            <tr>
                <td>
                    <strong>Penerima </strong>
                    <div class="signature-space"></div>
                    <div>( ____________________ )</div>
                </td>
                <td>
                    <strong>Pengirim</strong>
                    <div class="signature-space"></div>
                    <div>( ____________________ )</div>
                </td>
                <td>
                    <strong>Pihak Toko</strong>
                    <div class="signature-space"></div>
                    <div>( ____________________ )</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
