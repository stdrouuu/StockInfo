<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengaturanController extends Controller
{
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
