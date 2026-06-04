<?php
 
namespace App\Http\Controllers;
 
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Proses;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
 
class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter', 'Semua'); // 'Semua', 'Masuk', 'Keluar'

        $query = Transaksi::with(['supplier', 'user', 'items.produk']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', '%' . $search . '%')
                  ->orWhere('tujuan', 'like', '%' . $search . '%')
                  ->orWhere('keterangan', 'like', '%' . $search . '%')
                  ->orWhereHas('supplier', function ($sq) use ($search) {
                      $sq->where('nama', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($filter !== 'Semua') {
            $query->where('tipe', strtolower($filter));
        }

        $transaksis = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        // Stats
        $stockMasukCount = TransaksiItem::whereHas('transaksi', function ($q) {
            $q->where('tipe', 'masuk');
        })->sum('qty');

        $stockKeluarCount = TransaksiItem::whereHas('transaksi', function ($q) {
            $q->where('tipe', 'keluar');
        })->sum('qty');

        $produks = Produk::orderBy('nama', 'asc')->get();
        $suppliers = Supplier::orderBy('nama', 'asc')->get();
        $kategoris = \App\Models\Kategori::orderBy('nama', 'asc')->get();

        return view('transaksi.transaksi', compact(
            'transaksis',
            'stockMasukCount',
            'stockKeluarCount',
            'produks',
            'suppliers',
            'kategoris',
            'search',
            'filter'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:Masuk,Keluar',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'supplier_id' => 'required_if:tipe,Masuk|exists:suppliers,id|nullable',
            'tujuan' => 'nullable|string',
            'alamat' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $tipeLower = strtolower($request->tipe);
            
            // Generate Code: TRX-IN-YYYYMMDD-XXX or TRX-OUT-YYYYMMDD-XXX
            $datePrefix = date('Ymd', strtotime($request->tanggal));
            $typePrefix = $tipeLower === 'masuk' ? 'IN' : 'OUT';
            $pattern = "TRX-{$typePrefix}-{$datePrefix}-%";
            
            $lastTrx = Transaksi::where('kode', 'like', $pattern)
                ->orderBy('kode', 'desc')
                ->first();

            $sequence = 1;
            if ($lastTrx) {
                $lastCode = $lastTrx->kode;
                $parts = explode('-', $lastCode);
                $lastSeq = (int) end($parts);
                $sequence = $lastSeq + 1;
            }
            $kode = "TRX-{$typePrefix}-{$datePrefix}-" . str_pad($sequence, 3, '0', STR_PAD_LEFT);

            // Compute total nilai
            $totalNilai = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $subtotal = $item['qty'] * $item['harga_satuan'];
                $totalNilai += $subtotal;
                $itemsData[] = [
                    'produk_id' => $item['produk_id'],
                    'qty' => $item['qty'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $subtotal,
                ];
            }

            // Create Transaction
            $transaksi = Transaksi::create([
                'kode' => $kode,
                'tipe' => $tipeLower,
                'supplier_id' => $tipeLower === 'masuk' ? $request->supplier_id : null,
                'tujuan' => $tipeLower === 'keluar' ? $request->tujuan : null,
                'alamat' => $tipeLower === 'keluar' ? $request->alamat : null,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
                'status' => 'Selesai',
                'total_nilai' => $totalNilai,
                'user_id' => Auth::id() ?? 1,
            ]);

            // Save Items & Update Stock
            foreach ($itemsData as $data) {
                $transaksi->items()->create($data);

                // Update product stock
                $produk = Produk::find($data['produk_id']);
                if ($tipeLower === 'masuk') {
                    $produk->stok += $data['qty'];
                } else {
                    // Check if stock is sufficient
                    if ($produk->stok < $data['qty']) {
                        throw new \Exception("Stok tidak mencukupi untuk produk: {$produk->nama}. Stok saat ini: {$produk->stok}");
                    }
                    $produk->stok -= $data['qty'];
                }
                $produk->save();
            }

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', "Transaksi {$kode} berhasil dicatat!");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Transaksi $transaksi)
    {
        // RBAC (Defense in Depth): Walaupun route sudah dilindungi middleware 'role:admin',
        // pengecekan di controller tetap dilakukan sebagai lapisan keamanan tambahan (double confirmation/safety).
        // Penghapusan transaksi adalah aksi berisiko tinggi karena dapat memanipulasi stok.
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        try {
            DB::beginTransaction();

            $tipeLower = strtolower($transaksi->tipe);

            // Revert stocks
            foreach ($transaksi->items as $item) {
                $produk = $item->produk;
                if ($tipeLower === 'masuk') {
                    $produk->stok -= $item->qty;
                } else {
                    $produk->stok += $item->qty;
                }
                $produk->save();
            }

            // Delete items and transaction
            $transaksi->items()->delete();
            $transaksi->delete();

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus dan stok telah dikembalikan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transaksi.index')->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Cetak Surat Jalan dan generate otomatis data Proses jika belum ada (hanya tipe keluar).
     */
    public function cetakSuratJalan(Transaksi $transaksi)
    {
        // 1. Pastikan transaksi bertipe keluar
        if (strtolower($transaksi->tipe) !== 'keluar') {
            return redirect()->back()->with('error', 'Surat Jalan hanya dapat dicetak untuk Transaksi Keluar!');
        }

        // 2. Hubungkan data Proses secara otomatis jika belum dibuat
        $existingProsesCount = Proses::where('transaksi_id', $transaksi->id)->count();
        
        if ($existingProsesCount === 0) {
            $noSuratJalan = 'SJ-' . $transaksi->kode;
            
            foreach ($transaksi->items as $item) {
                $produk = $item->produk;
                $kategori = $produk->kategori->nama ?? 'Umum';
                
                Proses::create([
                    'transaksi_id'    => $transaksi->id,
                    'produk_id'       => $item->produk_id,
                    'no_surat_jalan'  => $noSuratJalan,
                    'status'          => 'On-Going',
                    'kategori_proses' => $kategori,
                    'keterangan'      => 'Pengiriman otomatis dari Transaksi Keluar ' . $transaksi->kode,
                ]);
            }
        }

        // 3. Ambil data proses yang telah terbuat untuk di-render di PDF
        $prosesItems = Proses::with(['produk.kategori', 'transaksi.user'])
            ->where('transaksi_id', $transaksi->id)
            ->get();

        // 4. Generate PDF menggunakan view khusus
        $pdf = Pdf::loadView('laporan.pdf.surat_jalan', compact('transaksi', 'prosesItems'));
        
        // 5. Stream ke browser
        return $pdf->stream('Surat_Jalan_' . $transaksi->kode . '.pdf');
    }
}
