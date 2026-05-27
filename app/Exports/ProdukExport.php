<?php

namespace App\Exports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProdukExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Produk::with('kategori')->get();
    }

    public function headings(): array
    {
        return [
            'SKU',
            'Nama Produk',
            'Kategori',
            'Stok Fisik',
            'Harga Satuan',
            'Total Aset',
        ];
    }

    public function map($produk): array
    {
        return [
            $produk->sku,
            $produk->nama_produk,
            $produk->kategori->nama_kategori ?? '-',
            $produk->stok,
            $produk->harga,
            $produk->stok * $produk->harga,
        ];
    }
}
