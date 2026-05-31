<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Supplier::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('kontak_person', 'like', '%' . $search . '%')
                  ->orWhere('telepon', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $suppliers = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('supplier.supplier', compact('suppliers', 'search'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak_person' => 'required|string|max:255',
            'telepon' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'alamat' => 'required|string',
        ]);

        $supplier = Supplier::create($request->all());

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Supplier berhasil ditambahkan!',
                'data' => $supplier
            ]);
        }

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak_person' => 'required|string|max:255',
            'telepon' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'alamat' => 'required|string',
        ]);

        $supplier->update($request->all());

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        // Check if there are transactions associated with this supplier
        if ($supplier->transaksis()->count() > 0) {
            return redirect()->route('supplier.index')->with('error', 'Supplier tidak dapat dihapus karena memiliki riwayat transaksi!');
        }

        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus!');
    }
}
