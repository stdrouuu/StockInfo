<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\StokOpnamePeriode;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display the dynamic reports dashboard.
     */
    public function index()
    {
        // Fetch all stock opname periods dynamically from database (ordered by latest)
        $periodes = StokOpnamePeriode::orderBy('id', 'desc')->get();

        return view('laporan.laporan', compact('periodes'));
    }

    /**
     * DUMMY EXPORT METHODS
     */
    public function exportProdukExcel() {}
    public function exportTransaksiPdf() {}
    public function exportTransaksiExcel() {}
    public function exportStokOpnamePdf() {}
    public function exportStokOpnameExcel() {}
}
