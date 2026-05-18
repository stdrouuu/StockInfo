<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';

    protected $fillable = [
        'sku',
        'nama',
        'kategori_id',
        'stok',
        'harga',
        'stok_minimum',
        'gambar',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
        ];
    }

    /**
     * Kategori dari produk ini.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Item transaksi yang mengandung produk ini.
     */
    public function transaksiItems()
    {
        return $this->hasMany(TransaksiItem::class);
    }

    /**
     * Stok opname items untuk produk ini.
     */
    public function stokOpnameItems()
    {
        return $this->hasMany(StokOpnameItem::class);
    }

    /**
     * Proses yang berkaitan dengan produk ini.
     */
    public function proses()
    {
        return $this->hasMany(Proses::class);
    }

    /**
     * Cek apakah stok rendah (di bawah minimum).
     */
    public function isLowStock(): bool
    {
        return $this->stok <= $this->stok_minimum;
    }
}
