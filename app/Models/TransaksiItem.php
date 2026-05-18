<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    use HasFactory;

    protected $table = 'transaksi_items';

    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'qty',
        'harga_satuan',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'harga_satuan' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    /**
     * Transaksi induk dari item ini.
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    /**
     * Produk yang terkait dengan item ini.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
