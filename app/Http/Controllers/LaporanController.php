<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\StokOpnameItem;
use App\Models\StokOpnamePeriode;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProdukExport;
use App\Exports\TransaksiExport;
use App\Exports\StokOpnameExport;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LaporanController extends Controller implements HasMiddleware
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
     * Display the dynamic reports dashboard.
     */
    public function index()
    {
        // Fetch all stock opname periods dynamically from database (ordered by latest)
        $periodes = StokOpnamePeriode::orderBy('id', 'desc')->get();

        return view('laporan.laporan', compact('periodes'));
    }

    /**
     * EXPORT METHODS
     */
    public function exportProdukExcel()
    {
        return Excel::download(new ProdukExport, 'Laporan_Produk_' . Carbon::now()->format('Ymd') . '.xlsx');
    }

    public function exportTransaksiPdf(Request $request)
    {
        $tipe = $request->input('tipe');
        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_selesai = $request->input('tanggal_selesai');

        $query = TransaksiItem::query()
            ->with(['transaksi.supplier', 'transaksi.user', 'produk'])
            ->join('transaksis', 'transaksi_items.transaksi_id', '=', 'transaksis.id')
            ->select('transaksi_items.*');

        if ($tipe && $tipe !== 'all') {
            $query->where('transaksis.tipe', $tipe);
        }

        if ($tanggal_mulai && $tanggal_selesai) {
            $query->whereBetween('transaksis.tanggal', [$tanggal_mulai, $tanggal_selesai]);
        }

        $transaksiItems = $query->orderBy('transaksis.tanggal', 'desc')->get();

        $pdf = Pdf::loadView('laporan.pdf.transaksi', compact('transaksiItems', 'tipe', 'tanggal_mulai', 'tanggal_selesai'));
        return $pdf->stream('Laporan_Transaksi_' . Carbon::now()->format('Ymd') . '.pdf');
    }

    public function exportTransaksiExcel(Request $request)
    {
        $tipe = $request->input('tipe');
        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_selesai = $request->input('tanggal_selesai');

        return Excel::download(new TransaksiExport($tipe, $tanggal_mulai, $tanggal_selesai), 'Laporan_Transaksi_' . Carbon::now()->format('Ymd') . '.xlsx');
    }

    public function exportStokOpnamePdf(Request $request)
    {
        $periode_id = $request->input('periode_id');
        
        if (!$periode_id) {
            return back()->withErrors(['periode_id' => 'Silakan pilih periode stok opname terlebih dahulu.']);
        }

        $periode = StokOpnamePeriode::find($periode_id);
        $items = StokOpnameItem::with(['produk.kategori'])->where('periode_id', $periode_id)->get();

        $pdf = Pdf::loadView('laporan.pdf.stok_opname', compact('items', 'periode'));
        return $pdf->stream('Laporan_Stok_Opname_' . Carbon::now()->format('Ymd') . '.pdf');
    }

    public function exportStokOpnameExcel(Request $request)
    {
        $periode_id = $request->input('periode_id');
        
        if (!$periode_id) {
            return back()->withErrors(['periode_id' => 'Silakan pilih periode stok opname terlebih dahulu.']);
        }

        return Excel::download(new StokOpnameExport($periode_id), 'Laporan_Stok_Opname_' . Carbon::now()->format('Ymd') . '.xlsx');
    }
}
