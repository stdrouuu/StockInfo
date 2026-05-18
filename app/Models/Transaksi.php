<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'kode',
        'tipe',
        'supplier_id',
        'tujuan',
        'tanggal',
        'keterangan',
        'status',
        'total_nilai',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'total_nilai' => 'decimal:2',
        ];
    }

    /**
     * Supplier untuk transaksi ini (jika tipe masuk).
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * User yang membuat transaksi ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Detail item transaksi.
     */
    public function items()
    {
        return $this->hasMany(TransaksiItem::class);
    }

    /**
     * Hitung total qty dari semua items.
     */
    public function getTotalQtyAttribute(): int
    {
        return $this->items->sum('qty');
    }
}
