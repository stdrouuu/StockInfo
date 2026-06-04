<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     * 
     * Middleware ini berfungsi sebagai "Satpam" (penyaring request).
     * Menerima daftar $roles (contoh: 'admin', 'staff') yang diperbolehkan mengakses route.
     * Jika user belum login atau role user tidak terdaftar dalam $roles, request ditolak dengan HTTP 403.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Cek apakah user sudah terautentikasi (login)
        // 2. Cek apakah role user saat ini ada di dalam array $roles yang diizinkan
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            // Jika tidak memenuhi syarat, batalkan request dan kirim respon 403 Forbidden
            abort(403, 'Akses ditolak.');
        }
        
        // Jika lolos pengecekan, teruskan request ke controller/proses berikutnya
        return $next($request);
    }
}
