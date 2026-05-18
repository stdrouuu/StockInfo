<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokOpnamePeriode extends Model
{
    use HasFactory;

    protected $table = 'stok_opname_periodes';

    protected $fillable = [
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'status_kerja',
        'status_pelaporan',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    /**
     * User yang membuat periode ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Detail item opname dalam periode ini.
     */
    public function items()
    {
        return $this->hasMany(StokOpnameItem::class, 'periode_id');
    }

    /**
     * Hitung total barang dalam periode ini.
     */
    public function getTotalBarangAttribute(): int
    {
        return $this->items->count();
    }

    /**
     * Hitung total barang yang sesuai (selisih = 0).
     */
    public function getTotalSesuaiAttribute(): int
    {
        return $this->items->where('selisih', 0)->count();
    }

    /**
     * Hitung total barang yang selisih (selisih != 0).
     */
    public function getTotalSelisihAttribute(): int
    {
        return $this->items->where('selisih', '!=', 0)->count();
    }
}
