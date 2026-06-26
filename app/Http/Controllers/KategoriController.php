<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Kategori::query();

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $kategoris = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('produk.kategori', compact('kategoris', 'search'));
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
            'nama' => 'required|string|max:255|unique:kategoris,nama',
        ]);

        Kategori::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'nama' => 'required|string|max:255|unique:kategoris,nama,' . $kategori->id,
        ]);

        $kategori->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        // Check if there are products inside this category
        if ($kategori->produks()->count() > 0) {
            return redirect()->route('kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk!');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
