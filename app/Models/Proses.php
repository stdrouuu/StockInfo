<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proses extends Model
{
    use HasFactory;

    protected $table = 'proses';

    protected $fillable = [
        'produk_id',
        'no_surat_jalan',
        'status',
        'kategori_proses',
        'keterangan',
    ];

    /**
     * Produk yang terkait dengan proses ini.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
