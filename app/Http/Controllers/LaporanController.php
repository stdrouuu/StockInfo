<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display the dynamic reports dashboard.
     */
    public function index()
    {
        // 1. Total SKU
        $totalSKU = Produk::count();

        // 2. Total Inventory Value
        $invValue = Produk::sum(\DB::raw('stok * harga'));

        // 3. Low Stock Alerts (products where stok <= stok_minimum)
        $lowStockAlerts = Produk::where('stok', '<=', \DB::raw('stok_minimum'))
            ->orderBy('stok', 'asc')
            ->limit(5)
            ->get();

        // 4. Recent Inbound & Outbound Transactions
        $recentTransactions = Transaksi::with(['items.produk', 'supplier'])
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return view('laporan.laporan', compact(
            'totalSKU',
            'invValue',
            'lowStockAlerts',
            'recentTransactions'
        ));
    }
}
