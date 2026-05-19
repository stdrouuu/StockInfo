<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter'); // 'tinggi_rendah', 'rendah_tinggi', 'kritis'

        $query = Produk::with('kategori');

        // Search functionality
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        // Filter stock functionality
        if ($filter === 'tinggi_rendah') {
            $query->orderBy('stok', 'desc');
        } elseif ($filter === 'rendah_tinggi') {
            $query->orderBy('stok', 'asc');
        } elseif ($filter === 'kritis') {
            $query->whereColumn('stok', '<=', 'stok_minimum')->orderBy('stok', 'asc');
        } else {
            $query->orderBy('id', 'desc');
        }

        $produks = $query->paginate(10)->withQueryString();

        // Calculate statistics cards
        $totalSKU = Produk::count();
        $stokRendahCount = Produk::whereColumn('stok', '<=', 'stok_minimum')->count();
        
        // Dalam Transit: let's calculate active proses count
        $dalamTransit = \App\Models\Proses::where('status', 'On-Going')->count();

        // Inv. Value: Sum of stock * price
        $invValue = Produk::sum(DB::raw('stok * harga'));

        // Load categories for dropdown in modal
        $kategoris = Kategori::all();

        return view('produk.produk', compact(
            'produks',
            'totalSKU',
            'stokRendahCount',
            'dalamTransit',
            'invValue',
            'kategoris',
            'search',
            'filter'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'sku' => 'required|string|unique:produks,sku|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('produk', 'public');
            $data['gambar'] = $path;
        }

        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:produks,sku,' . $produk->id,
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $path = $request->file('gambar')->store('produk', 'public');
            $data['gambar'] = $path;
        }

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        // Delete image file
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
