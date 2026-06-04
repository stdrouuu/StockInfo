<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin.
     * 
     * Digunakan untuk pengecekan cepat apakah user memiliki role 'admin'.
     * Sangat berguna di Blade template (misal: @if(auth()->user()->isAdmin())) 
     * atau di dalam Controller untuk proteksi logic/fitur tambahan.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Transaksi yang dibuat oleh user ini.
     */
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }

    /**
     * Stok opname periode yang dibuat oleh user ini.
     */
    public function stokOpnamePeriodes()
    {
        return $this->hasMany(StokOpnamePeriode::class);
    }
}
