<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokOpnameItem extends Model
{
    use HasFactory;

    protected $table = 'stok_opname_items';

    protected $fillable = [
        'periode_id',
        'produk_id',
        'stok_sistem',
        'stok_fisik',
        'selisih',
        'catatan',
    ];

    /**
     * Periode opname dari item ini.
     */
    public function periode()
    {
        return $this->belongsTo(StokOpnamePeriode::class, 'periode_id');
    }

    /**
     * Produk yang terkait dengan item opname ini.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
