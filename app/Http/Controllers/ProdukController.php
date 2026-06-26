<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Proses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter'); // 'tinggi_rendah', 'rendah_tinggi', 'kritis'
        $kategori_id = $request->input('kategori_id');

        $query = Produk::with('kategori');

        // Search functionality
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%'.$search.'%')
                    ->orWhere('sku', 'like', '%'.$search.'%');
            });
        }

        // Filter category functionality
        if ($kategori_id) {
            $query->where('kategori_id', $kategori_id);
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
        $dalamTransit = Proses::where('status', 'On-Going')->count();

        // Inv. Value: Sum of stock * price
        $invValue = Produk::sum(DB::raw('stok * harga'));

        // Load categories for dropdown in modal
        $kategoris = Kategori::all();

        // Load all existing SKUs for duplicate validation in the frontend modal
        $existingSkus = Produk::select('id', 'sku')->get();

        return view('produk.produk', compact(
            'produks',
            'totalSKU',
            'stokRendahCount',
            'dalamTransit',
            'invValue',
            'kategoris',
            'search',
            'filter',
            'kategori_id',
            'existingSkus'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'sku' => 'required|string|unique:produks,sku|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:12288',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('produk', 'public');
            $data['gambar'] = $path;
        }

        $produk = Produk::create($data);

        if ($request->expectsJson() || $request->ajax()) {
            // Load the category name so we can return it too if needed
            $produk->load('kategori');
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan!',
                'data' => $produk
            ]);
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:produks,sku,'.$produk->id,
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:12288',
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
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        // Delete image file
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
