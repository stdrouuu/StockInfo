<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardController extends Controller
{
    /**
     * Show the dashboard.
     */
    public function index()
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

        // 6. Stock Movement Trends (Dummy / calculate daily transactions for current week)
        $trends = [
            'Mon' => ['in' => 120, 'out' => 80],
            'Tue' => ['in' => 240, 'out' => 150],
            'Wed' => ['in' => 450, 'out' => 300],
            'Thu' => ['in' => 210, 'out' => 310],
            'Fri' => ['in' => 380, 'out' => 220],
            'Sat' => ['in' => 90, 'out' => 50],
            'Sun' => ['in' => 150, 'out' => 110],
        ];

        // Retrieve actual daily transactional totals if available
        $days = ['Monday' => 'Mon', 'Tuesday' => 'Tue', 'Wednesday' => 'Wed', 'Thursday' => 'Thu', 'Friday' => 'Fri', 'Saturday' => 'Sat', 'Sunday' => 'Sun'];
        foreach ($days as $fullName => $shortName) {
            $in = TransaksiItem::whereHas('transaksi', function ($query) use ($fullName) {
                $query->where('tipe', 'masuk')
                      ->whereRaw("DAYNAME(tanggal) = ?", [$fullName]);
            })->sum('qty');

            $out = TransaksiItem::whereHas('transaksi', function ($query) use ($fullName) {
                $query->where('tipe', 'keluar')
                      ->whereRaw("DAYNAME(tanggal) = ?", [$fullName]);
            })->sum('qty');

            if ($in > 0 || $out > 0) {
                $trends[$shortName] = [
                    'in' => (int) $in,
                    'out' => (int) $out
                ];
            }
        }

        // Build Larapex Chart
        $chart = (new LarapexChart)->barChart()
            ->setXAxis(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'])
            ->setDataset([
                [
                    'name' => 'Inbound',
                    'data' => [
                        $trends['Mon']['in'],
                        $trends['Tue']['in'],
                        $trends['Wed']['in'],
                        $trends['Thu']['in'],
                        $trends['Fri']['in'],
                        $trends['Sat']['in'],
                        $trends['Sun']['in'],
                    ]
                ],
                [
                    'name' => 'Outbound',
                    'data' => [
                        $trends['Mon']['out'],
                        $trends['Tue']['out'],
                        $trends['Wed']['out'],
                        $trends['Thu']['out'],
                        $trends['Fri']['out'],
                        $trends['Sat']['out'],
                        $trends['Sun']['out'],
                    ]
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
            'chart'
        ));
    }
}
