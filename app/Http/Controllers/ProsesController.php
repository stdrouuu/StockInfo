<?php

namespace App\Http\Controllers;

use App\Models\Proses;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProsesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Proses::with(['produk.kategori', 'transaksi.supplier', 'transaksi.user', 'transaksi.items.produk'])
            ->select('no_surat_jalan', 'transaksi_id', 'status', 'keterangan', DB::raw('MAX(produk_id) as produk_id'), DB::raw('MAX(kategori_proses) as kategori_proses'), DB::raw('MAX(id) as id'))
            ->groupBy('no_surat_jalan', 'transaksi_id', 'status', 'keterangan');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_surat_jalan', 'like', '%' . $search . '%')
                  ->orWhere('status', 'like', '%' . $search . '%')
                  ->orWhere('kategori_proses', 'like', '%' . $search . '%')
                  ->orWhereHas('produk', function ($pq) use ($search) {
                      $pq->where('nama', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('transaksi', function ($tq) use ($search) {
                      $tq->where('kode', 'like', '%' . $search . '%')
                        ->orWhere('tujuan', 'like', '%' . $search . '%');
                  });
            });
        }

        $proses = $query->orderBy(DB::raw('MAX(id)'), 'desc')->paginate(10)->withQueryString();
        $produks = Produk::with('kategori')->orderBy('nama', 'asc')->get();
        $transaksis = Transaksi::with(['items.produk.kategori', 'supplier'])->orderBy('kode', 'desc')->get();

        return view('proses.proses', compact('proses', 'produks', 'transaksis', 'search'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Automatically fetch and attach the product category name
        if ($request->has('produk_id')) {
            $produk = Produk::with('kategori')->find($request->produk_id);
            if ($produk) {
                $request->merge(['kategori_proses' => $produk->kategori->nama ?? 'Umum']);
            }
        }

        $request->validate([
            'transaksi_id' => 'nullable|exists:transaksis,id',
            'produk_id' => 'required|exists:produks,id',
            'no_surat_jalan' => 'required|string|max:255',
            'status' => 'required|in:On-Going,Pending,Completed',
            'kategori_proses' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Proses::create($request->all());

        return redirect()->route('proses.index')->with('success', 'Proses berhasil ditambahkan!');
    }

    public function update(Request $request, Proses $prose)
    {
        $request->validate([
            'status' => 'required|in:On-Going,Pending,Completed',
        ]);

        Proses::where('no_surat_jalan', $prose->no_surat_jalan)
            ->update(['status' => $request->status]);

        return redirect()->route('proses.index')->with('success', 'Status Surat Jalan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proses $prose)
    {
        Proses::where('no_surat_jalan', $prose->no_surat_jalan)->delete();

        return redirect()->route('proses.index')->with('success', 'Surat Jalan berhasil dihapus!');
    }
}
