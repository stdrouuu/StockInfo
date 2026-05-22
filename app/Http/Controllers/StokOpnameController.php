<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\StokOpnameItem;
use App\Models\StokOpnamePeriode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StokOpnameController extends Controller
{
    /**
     * Display a listing of opname periods.
     */
    public function opname1()
    {
        $periodes = StokOpnamePeriode::with(['items', 'user'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('stok.opname1', compact('periodes'));
    }

    /**
     * Store a new opname period and pre-populate items from active products.
     */
    public function storePeriode(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // Set all other periods to status_kerja = 'Tidak Aktif'
            StokOpnamePeriode::query()->update(['status_kerja' => 'Tidak Aktif']);

            // Create new active period
            $periode = StokOpnamePeriode::create([
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'keterangan' => $request->keterangan,
                'status_kerja' => 'Aktif',
                'status_pelaporan' => 'BELUM LENGKAP',
                'user_id' => Auth::id() ?? 1,
            ]);

            // Add all existing products as items for this opname period
            $produks = Produk::all();
            foreach ($produks as $produk) {
                StokOpnameItem::create([
                    'periode_id' => $periode->id,
                    'produk_id' => $produk->id,
                    'stok_sistem' => $produk->stok,
                    'stok_fisik' => $produk->stok, // default to matching
                    'selisih' => 0,
                    'catatan' => 'belum dilaporkan',
                ]);
            }

            DB::commit();

            return redirect()->route('stok.opname1')->with('success', 'Periode Stok Opname baru berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Gagal membuat periode: '.$e->getMessage());
        }
    }

    /**
     * Display sheet for inputting opname physical stocks.
     */
    public function opname2(Request $request)
    {
        $periodeId = $request->input('periode_id');

        if ($periodeId) {
            $periode = StokOpnamePeriode::find($periodeId);
        } else {
            $periode = StokOpnamePeriode::where('status_kerja', 'Aktif')->first()
                ?? StokOpnamePeriode::orderBy('id', 'desc')->first();
        }

        if (! $periode) {
            return redirect()->route('stok.opname1')->with('error', 'Silakan buat periode stok opname terlebih dahulu.');
        }

        $items = StokOpnameItem::with('produk')
            ->where('periode_id', $periode->id)
            ->paginate(15)
            ->withQueryString();

        return view('stok.opname2', compact('periode', 'items'));
    }

    /**
     * Update/report physical stock and notes for a specific item.
     */
    public function reportItem(Request $request, StokOpnameItem $item)
    {
        $request->validate([
            'stok_fisik' => 'required|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        $selisih = $request->stok_fisik - $item->stok_sistem;

        $item->update([
            'stok_fisik' => $request->stok_fisik,
            'selisih' => $selisih,
            'catatan' => $request->catatan ?? ($selisih === 0 ? 'sesuai' : 'selisih'),
        ]);

        // Check if all items in this period have been checked
        $periode = $item->periode;
        $unreported = StokOpnameItem::where('periode_id', $periode->id)
            ->where('catatan', 'belum dilaporkan')
            ->count();

        if ($unreported === 0) {
            $periode->update(['status_pelaporan' => 'SELESAI']);
        } else {
            $periode->update(['status_pelaporan' => 'BELUM LENGKAP']);
        }

        return redirect()->back()->with('success', 'Stok fisik berhasil dilaporkan untuk '.$item->produk->nama);
    }

    /**
     * Display report sheet showing match/diff percentage.
     */
    public function opname3(Request $request)
    {
        $periodeId = $request->input('periode_id');

        if ($periodeId) {
            $periode = StokOpnamePeriode::with('items.produk')->find($periodeId);
        } else {
            $periode = StokOpnamePeriode::with('items.produk')->where('status_kerja', 'Aktif')->first()
                ?? StokOpnamePeriode::with('items.produk')->orderBy('id', 'desc')->first();
        }

        if (! $periode) {
            return redirect()->route('stok.opname1')->with('error', 'Tidak ada laporan stok opname tersedia.');
        }

        $totalItems = $periode->items->count();
        $totalSesuai = $periode->items->where('selisih', 0)->count();
        $totalSelisih = $totalItems - $totalSesuai;

        $sesuaiPercent = $totalItems > 0 ? round(($totalSesuai / $totalItems) * 100, 1) : 100;
        $selisihPercent = $totalItems > 0 ? round(($totalSelisih / $totalItems) * 100, 1) : 0;

        $items = StokOpnameItem::with('produk')
            ->where('periode_id', $periode->id)
            ->paginate(15)
            ->withQueryString();

        return view('stok.opname3', compact('periode', 'items', 'totalItems', 'totalSesuai', 'totalSelisih', 'sesuaiPercent', 'selisihPercent'));
    }
}
