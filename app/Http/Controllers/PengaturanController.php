<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaturanController extends Controller
{
    /**
     * Display current user settings.
     */
    public function index()
    {
        $user = Auth::user();

        return view('pengaturan.pengaturan', compact('user'));
    }
}
