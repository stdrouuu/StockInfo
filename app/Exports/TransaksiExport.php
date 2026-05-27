<?php

namespace App\Exports;

use App\Models\TransaksiItem;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

class TransaksiExport extends StringValueBinder implements FromQuery, WithHeadings, WithMapping, WithCustomValueBinder
{
    use Exportable;

    protected $tipe;
    protected $tanggal_mulai;
    protected $tanggal_selesai;

    public function __construct($tipe = null, $tanggal_mulai = null, $tanggal_selesai = null)
    {
        $this->tipe = $tipe;
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_selesai = $tanggal_selesai;
    }

    public function query()
    {
        $query = TransaksiItem::query()
            ->with(['transaksi.supplier', 'transaksi.user', 'produk'])
            ->join('transaksis', 'transaksi_items.transaksi_id', '=', 'transaksis.id')
            ->select('transaksi_items.*'); // Select only items to avoid column conflicts

        if ($this->tipe && $this->tipe !== 'all') {
            $query->where('transaksis.tipe', $this->tipe);
        }

        if ($this->tanggal_mulai && $this->tanggal_selesai) {
            $query->whereBetween('transaksis.tanggal', [$this->tanggal_mulai, $this->tanggal_selesai]);
        }

        return $query->orderBy('transaksis.tanggal', 'desc');
    }

    public function headings(): array
    {
        return [
            'No Referensi',
            'Tanggal',
            'Tipe',
            'Produk (SKU)',
            'Nama Produk',
            'Kuantitas',
            'Harga Satuan',
            'Subtotal',
            'Supplier / Tujuan',
            'Pembuat (User)'
        ];
    }

    public function map($item): array
    {
        $transaksi = $item->transaksi;
        $produk = $item->produk;
        
        $supplier_tujuan = $transaksi->tipe === 'masuk' 
            ? ($transaksi->supplier->nama ?? '-') 
            : ($transaksi->tujuan ?? '-');

        return [
            $transaksi->kode,
            $transaksi->tanggal ? $transaksi->tanggal->format('Y-m-d') : '-',
            ucfirst($transaksi->tipe),
            $produk->sku ?? '-',
            $produk->nama ?? '-',
            $item->qty,
            $item->harga_satuan,
            $item->subtotal,
            $supplier_tujuan,
            $transaksi->user->name ?? '-'
        ];
    }
}
