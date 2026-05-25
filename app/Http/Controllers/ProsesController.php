<?php

namespace App\Http\Controllers;

use App\Models\Proses;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProsesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Proses::with('produk.kategori');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_surat_jalan', 'like', '%' . $search . '%')
                  ->orWhere('status', 'like', '%' . $search . '%')
                  ->orWhere('kategori_proses', 'like', '%' . $search . '%')
                  ->orWhereHas('produk', function ($pq) use ($search) {
                      $pq->where('nama', 'like', '%' . $search . '%');
                  });
            });
        }

        $proses = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        $produks = Produk::with('kategori')->orderBy('nama', 'asc')->get();

        return view('proses.proses', compact('proses', 'produks', 'search'));
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
            'produk_id' => 'required|exists:produks,id',
            'no_surat_jalan' => 'required|string|max:255',
            'status' => 'required|in:On-Going,Pending,Completed',
            'kategori_proses' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Proses::create($request->all());

        return redirect()->route('proses.index')->with('success', 'Proses berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proses $prose)
    {
        // Automatically fetch and attach the product category name
        if ($request->has('produk_id')) {
            $produk = Produk::with('kategori')->find($request->produk_id);
            if ($produk) {
                $request->merge(['kategori_proses' => $produk->kategori->nama ?? 'Umum']);
            }
        }

        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'no_surat_jalan' => 'required|string|max:255',
            'status' => 'required|in:On-Going,Pending,Completed',
            'kategori_proses' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $prose->update($request->all());

        return redirect()->route('proses.index')->with('success', 'Proses berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proses $prose)
    {
        $prose->delete();

        return redirect()->route('proses.index')->with('success', 'Proses berhasil dihapus!');
    }
}
