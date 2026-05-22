<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\TransaksiItem;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the dashboard.
     */
    public function index(Request $request)
    {
        // 1. Jumlah Stok (Sum of all product stocks)
        $jumlahStok = Produk::sum('stok');

        // 2. Stok Rendah (Count of products where stock <= minimum stock)
        $stokRendah = Produk::whereColumn('stok', '<=', 'stok_minimum')->count();

        // 3. Stok Masuk (Sum of incoming transactions qty)
        $stokMasuk = TransaksiItem::whereHas('transaksi', function ($query) {
            $query->where('tipe', 'masuk');
        })->sum('qty');

        // 4. Inventory Value (Sum of stock * price)
        $inventoryValue = Produk::sum(DB::raw('stok * harga'));

        // 5. Low Stock Alerts (Products below minimum stock)
        $lowStockProducts = Produk::with('kategori')
            ->whereColumn('stok', '<=', 'stok_minimum')
            ->orderBy('stok', 'asc')
            ->limit(5)
            ->get();

        // 6. Dynamic Chart Filtering (Daily, Weekly, Monthly)
        $filter = $request->input('filter', 'weekly'); // default to weekly
        $latestTrx = \App\Models\Transaksi::max('tanggal');
        $baseDate = $latestTrx ? \Carbon\Carbon::parse($latestTrx) : now();

        $labels = [];
        $inboundData = [];
        $outboundData = [];

        if ($filter === 'daily') {
            // Show last 7 days ending at $baseDate
            for ($i = 6; $i >= 0; $i--) {
                $date = (clone $baseDate)->subDays($i);
                $labels[] = $date->locale('id')->isoFormat('D MMM'); // e.g. "20 Mei"

                $in = TransaksiItem::whereHas('transaksi', function ($query) use ($date) {
                    $query->where('tipe', 'masuk')
                          ->whereDate('tanggal', $date->toDateString());
                })->sum('qty');

                $out = TransaksiItem::whereHas('transaksi', function ($query) use ($date) {
                    $query->where('tipe', 'keluar')
                          ->whereDate('tanggal', $date->toDateString());
                })->sum('qty');

                $inboundData[] = (int) $in;
                $outboundData[] = (int) $out;
            }
        } elseif ($filter === 'monthly') {
            // Show last 6 months ending at $baseDate
            for ($i = 5; $i >= 0; $i--) {
                $monthDate = (clone $baseDate)->subMonths($i);
                $labels[] = $monthDate->locale('id')->isoFormat('MMM YYYY'); // e.g. "Mei 2024"

                $in = TransaksiItem::whereHas('transaksi', function ($query) use ($monthDate) {
                    $query->where('tipe', 'masuk')
                          ->whereMonth('tanggal', $monthDate->month)
                          ->whereYear('tanggal', $monthDate->year);
                })->sum('qty');

                $out = TransaksiItem::whereHas('transaksi', function ($query) use ($monthDate) {
                    $query->where('tipe', 'keluar')
                          ->whereMonth('tanggal', $monthDate->month)
                          ->whereYear('tanggal', $monthDate->year);
                })->sum('qty');

                $inboundData[] = (int) $in;
                $outboundData[] = (int) $out;
            }
        } else {
            // Default: 'weekly' (show last 4 weeks ending at $baseDate)
            for ($i = 3; $i >= 0; $i--) {
                $startOfWeek = (clone $baseDate)->subWeeks($i)->startOfWeek();
                $endOfWeek = (clone $baseDate)->subWeeks($i)->endOfWeek();
                
                // Elegant range label e.g., "13/05-19/05"
                $labels[] = $startOfWeek->format('d/m') . '-' . $endOfWeek->format('d/m');

                $in = TransaksiItem::whereHas('transaksi', function ($query) use ($startOfWeek, $endOfWeek) {
                    $query->where('tipe', 'masuk')
                          ->whereBetween('tanggal', [$startOfWeek->toDateString(), $endOfWeek->toDateString()]);
                })->sum('qty');

                $out = TransaksiItem::whereHas('transaksi', function ($query) use ($startOfWeek, $endOfWeek) {
                    $query->where('tipe', 'keluar')
                          ->whereBetween('tanggal', [$startOfWeek->toDateString(), $endOfWeek->toDateString()]);
                })->sum('qty');

                $inboundData[] = (int) $in;
                $outboundData[] = (int) $out;
            }
        }

        // Build Larapex Chart
        $chart = (new LarapexChart)->barChart()
            ->setXAxis($labels)
            ->setDataset([
                [
                    'name' => 'Inbound',
                    'data' => $inboundData
                ],
                [
                    'name' => 'Outbound',
                    'data' => $outboundData
                ]
            ])
            ->setColors(['#2563eb', '#cbd5e1']) // blue-600 and slate-300
            ->setHeight(280);

        return view('dashboard.dashboard', compact(
            'jumlahStok',
            'stokRendah',
            'stokMasuk',
            'inventoryValue',
            'lowStockProducts',
            'chart',
            'filter'
        ));
    }
}
