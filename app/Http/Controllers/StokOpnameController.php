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
        // RBAC: Hanya Admin yang dapat membuat periode opname baru.
        // Hal ini untuk mencegah staff memanipulasi waktu/jadwal stok opname untuk menyembunyikan selisih stok.
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // Set all other periods to status_kerja = 'tidak_aktif'
            StokOpnamePeriode::query()->update(['status_kerja' => 'tidak_aktif']);

            // Create new active period
            $periode = StokOpnamePeriode::create([
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'keterangan' => $request->keterangan,
                'status_kerja' => 'aktif',
                'status_pelaporan' => 'belum_lengkap',
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
            $periode = StokOpnamePeriode::where('status_kerja', 'aktif')->first()
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

        // Move active status to this period if it's not already active
        if ($periode->status_kerja !== 'aktif') {
            StokOpnamePeriode::query()->where('id', '!=', $periode->id)->update(['status_kerja' => 'tidak_aktif']);
            $periode->update(['status_kerja' => 'aktif']);
        }

        $unreported = StokOpnameItem::where('periode_id', $periode->id)
            ->where('catatan', 'belum dilaporkan')
            ->count();

        if ($unreported === 0) {
            $periode->update(['status_pelaporan' => 'selesai']);
        } else {
            $periode->update(['status_pelaporan' => 'belum_lengkap']);
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
            $periode = StokOpnamePeriode::with('items.produk')->where('status_kerja', 'aktif')->first()
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

    /**
     * Terapkan dan sesuaikan stok produk sesuai dengan stok fisik hasil opname.
     * Mencatat selisihnya sebagai kerugian/penyesuaian operasional.
     */
    public function adjustStock(Request $request, StokOpnamePeriode $periode)
    {
        // RBAC: Menyelaraskan/Menyesuaikan stok (Adjust Stock) merupakan keputusan finansial/inventaris yang krusial.
        // Hanya Admin yang diperbolehkan mengeksekusi penyesuaian ini setelah memverifikasi laporan selisih opname.
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        // 1. Pastikan belum pernah disesuaikan
        if ($periode->is_adjusted) {
            return redirect()->back()->with('error', 'Stok untuk periode ini sudah disesuaikan sebelumnya.');
        }

        // 2. Pastikan status pelaporan sudah selesai atau lengkap
        if ($periode->status_pelaporan !== 'selesai' && $periode->status_pelaporan !== 'lengkap') {
            return redirect()->back()->with('error', 'Stok tidak dapat disinkronkan karena pelaporan belum lengkap.');
        }

        try {
            DB::beginTransaction();

            $items = StokOpnameItem::with('produk')->where('periode_id', $periode->id)->get();
            
            $shortages = []; // selisih < 0 (stok_fisik < stok_sistem) -> kerugian
            $surpluses = []; // selisih > 0 (stok_fisik > stok_sistem) -> surplus

            foreach ($items as $item) {
                $produk = $item->produk;
                if (!$produk) {
                    continue;
                }

                $selisih = $item->selisih;

                if ($selisih < 0) {
                    $shortages[] = [
                        'produk' => $produk,
                        'qty' => abs($selisih),
                        'harga' => $produk->harga,
                    ];
                } elseif ($selisih > 0) {
                    $surpluses[] = [
                        'produk' => $produk,
                        'qty' => $selisih,
                        'harga' => $produk->harga,
                    ];
                }

                // Jika item belum pernah dilaporkan, otomatis tandai sebagai sesuai
                if ($item->catatan === 'belum dilaporkan') {
                    $item->catatan = 'sesuai';
                    $item->save();
                }

                // Perbarui stok produk utama di database
                $produk->stok = $item->stok_fisik;
                $produk->save();
            }

            $userId = Auth::id() ?? 1;
            $tanggal = date('Y-m-d');
            $datePrefix = date('Ymd');

            // Catat transaksi KELUAR untuk kekurangan stok (Kerugian Operasional)
            if (count($shortages) > 0) {
                $pattern = "TRX-OUT-{$datePrefix}-%";
                $lastTrx = \App\Models\Transaksi::where('kode', 'like', $pattern)
                    ->orderBy('kode', 'desc')
                    ->first();

                $sequence = 1;
                if ($lastTrx) {
                    $lastCode = $lastTrx->kode;
                    $parts = explode('-', $lastCode);
                    $lastSeq = (int) end($parts);
                    $sequence = $lastSeq + 1;
                }
                $kodeKeluar = "TRX-OUT-{$datePrefix}-" . str_pad($sequence, 3, '0', STR_PAD_LEFT);

                $totalNilaiKeluar = 0;
                foreach ($shortages as $s) {
                    $totalNilaiKeluar += $s['qty'] * $s['harga'];
                }

                $transaksiKeluar = \App\Models\Transaksi::create([
                    'kode' => $kodeKeluar,
                    'tipe' => 'keluar',
                    'tujuan' => 'Kerugian Operasional',
                    'alamat' => 'Penyesuaian Stok Opname',
                    'tanggal' => $tanggal,
                    'keterangan' => "Kerugian Operasional Stok Opname - Periode: " . $periode->tanggal_mulai->format('d/m/Y') . " s/d " . $periode->tanggal_selesai->format('d/m/Y'),
                    'status' => 'selesai',
                    'total_nilai' => $totalNilaiKeluar,
                    'user_id' => $userId,
                ]);

                foreach ($shortages as $s) {
                    $transaksiKeluar->items()->create([
                        'produk_id' => $s['produk']->id,
                        'qty' => $s['qty'],
                        'harga_satuan' => $s['harga'],
                        'subtotal' => $s['qty'] * $s['harga'],
                    ]);
                }
            }

            // Catat transaksi MASUK untuk kelebihan stok (Surplus Penyesuaian)
            if (count($surpluses) > 0) {
                $pattern = "TRX-IN-{$datePrefix}-%";
                $lastTrx = \App\Models\Transaksi::where('kode', 'like', $pattern)
                    ->orderBy('kode', 'desc')
                    ->first();

                $sequence = 1;
                if ($lastTrx) {
                    $lastCode = $lastTrx->kode;
                    $parts = explode('-', $lastCode);
                    $lastSeq = (int) end($parts);
                    $sequence = $lastSeq + 1;
                }
                $kodeMasuk = "TRX-IN-{$datePrefix}-" . str_pad($sequence, 3, '0', STR_PAD_LEFT);

                $totalNilaiMasuk = 0;
                foreach ($surpluses as $s) {
                    $totalNilaiMasuk += $s['qty'] * $s['harga'];
                }

                $transaksiMasuk = \App\Models\Transaksi::create([
                    'kode' => $kodeMasuk,
                    'tipe' => 'masuk',
                    'supplier_id' => null,
                    'tanggal' => $tanggal,
                    'keterangan' => "Penyesuaian Masuk Stok Opname - Periode: " . $periode->tanggal_mulai->format('d/m/Y') . " s/d " . $periode->tanggal_selesai->format('d/m/Y'),
                    'status' => 'selesai',
                    'total_nilai' => $totalNilaiMasuk,
                    'user_id' => $userId,
                ]);

                foreach ($surpluses as $s) {
                    $transaksiMasuk->items()->create([
                        'produk_id' => $s['produk']->id,
                        'qty' => $s['qty'],
                        'harga_satuan' => $s['harga'],
                        'subtotal' => $s['qty'] * $s['harga'],
                    ]);
                }
            }

            // Tandai periode opname sebagai sudah diselesaikan dan disesuaikan
            $periode->status_pelaporan = 'selesai';
            $periode->is_adjusted = true;
            $periode->save();

            DB::commit();

            return redirect()->route('stok.opname1')->with('success', 'Stok produk utama berhasil disinkronkan dan selisihnya telah dicatat ke riwayat transaksi.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menyinkronkan stok: ' . $e->getMessage());
        }
    }

    /**
     * Update the description of an opname period.
     */
    public function updatePeriode(Request $request, StokOpnamePeriode $periode)
    {
        // RBAC: Hanya Admin yang boleh memodifikasi detail periode opname.
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'keterangan' => 'required|string',
        ]);

        $periode->update([
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('stok.opname1')->with('success', 'Keterangan periode stok opname berhasil diperbarui!');
    }

    /**
     * Delete an opname period and its associated items.
     */
    public function destroyPeriode(StokOpnamePeriode $periode)
    {
        // RBAC: Menghapus riwayat stok opname adalah tindakan destruktif.
        // Dibatasi hanya untuk Admin demi menjaga integritas data audit.
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        try {
            DB::beginTransaction();

            // Hapus periode (items akan terhapus otomatis melalui cascade on delete)
            $periode->delete();

            DB::commit();

            return redirect()->route('stok.opname1')->with('success', 'Periode stok opname berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('stok.opname1')->with('error', 'Gagal menghapus periode: ' . $e->getMessage());
        }
    }
}
