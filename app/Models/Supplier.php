<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = [
        'nama',
        'kontak_person',
        'telepon',
        'email',
        'alamat',
    ];

    /**
     * Transaksi dari supplier ini.
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
