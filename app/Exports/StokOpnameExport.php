<?php

namespace App\Exports;

use App\Models\StokOpnameItem;
use App\Models\StokOpnamePeriode;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class StokOpnameExport implements FromQuery, WithHeadings, WithMapping, WithTitle
{
    use Exportable;

    protected $periodeId;
    protected $periode;

    public function __construct($periodeId)
    {
        $this->periodeId = $periodeId;
        $this->periode = StokOpnamePeriode::find($periodeId);
    }

    public function query()
    {
        return StokOpnameItem::query()
            ->with(['produk', 'periode'])
            ->where('periode_id', $this->periodeId);
    }

    public function headings(): array
    {
        return [
            'SKU',
            'Nama Produk',
            'Stok Sistem',
            'Stok Fisik',
            'Selisih',
            'Catatan',
        ];
    }

    public function map($item): array
    {
        return [
            $item->produk->sku ?? '-',
            $item->produk->nama ?? '-',
            $item->stok_sistem,
            $item->stok_fisik,
            $item->selisih,
            $item->catatan,
        ];
    }
    
    public function title(): string
    {
        return 'Opname ' . ($this->periode ? $this->periode->tanggal_mulai->format('d-m-Y') : 'Data');
    }
}
