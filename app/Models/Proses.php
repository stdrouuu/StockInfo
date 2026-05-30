<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proses extends Model
{
    use HasFactory;

    protected $table = 'proses';

    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'no_surat_jalan',
        'status',
        'kategori_proses',
        'keterangan',
    ];

    /**
     * Transaksi yang terkait dengan proses ini (opsional).
     */
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    /**
     * Produk yang terkait dengan proses ini.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
