<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = [
        'nama',
    ];

    /**
     * Produk yang termasuk kategori ini.
     */
    public function produks()
    {
        return $this->hasMany(Produk::class);
    }
}
