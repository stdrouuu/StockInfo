<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PengaturanController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('role:admin'),
        ];
    }
    /**
     * Display settings page.
     */
    public function index()
    {
        return redirect()->route('dashboard.dashboard')->with('error', 'Fitur pengaturan belum diimplementasikan.');
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        return redirect()->route('dashboard.dashboard')->with('error', 'Fitur pengaturan belum diimplementasikan.');
    }
}
