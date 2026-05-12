@extends('layouts.app')

@section('title', 'StockInfo - Data Produk')

@section('content')
<div class="p-8 space-y-8">
    <div class="bg-[#1e40af] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-blue-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-box text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Data Produk</h2>
                <div class="flex items-center gap-2 text-blue-100 text-[10px] mt-1 font-bold">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase">MASTER DATA</span>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="text-white uppercase font-black tracking-widest">PRODUK</span>
                </div>
            </div>
        </div>
        <i class="fas fa-boxes-stacked absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6">
        <div class="flex justify-between items-center mb-6">
            <button class="bg-[#2d46b9] hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 shadow-lg shadow-blue-200 transition-all">
                <i class="fas fa-plus text-xs"></i>
                Tambah Produk
            </button>
            <div class="flex gap-2">
                <button class="bg-white border border-slate-200 text-slate-600 px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2 hover:bg-slate-50 transition-all">
                    <i class="fas fa-file-excel text-emerald-600"></i> Export
                </button>
                <button class="bg-white border border-slate-200 text-slate-600 px-4 py-2 rounded-xl text-xs font-bold flex items-center gap-2 hover:bg-slate-50 transition-all">
                    <i class="fas fa-filter text-blue-600"></i> Filter
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-[#2d46b9] text-white text-[10px] font-black uppercase tracking-widest">
                        <th class="px-6 py-4 rounded-tl-xl">No</th>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Stok</th>
                        <th class="px-6 py-4">Satuan</th>
                        <th class="px-6 py-4">Harga Beli</th>
                        <th class="px-6 py-4">Harga Jual</th>
                        <th class="px-6 py-4 rounded-tr-xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @php
                        $products = [
                            ['no' => 1, 'name' => 'Cat Tembok Putih 5Kg', 'sku' => 'SKU-CAT-WHT-05', 'cat' => 'Cat & Pelapis', 'stock' => 120, 'unit' => 'Pail', 'buy' => 85000, 'sell' => 110000],
                            ['no' => 2, 'name' => 'Semen Padang 40Kg', 'sku' => 'SKU-SEM-PDG-40', 'cat' => 'Material Dasar', 'stock' => 500, 'unit' => 'Sack', 'buy' => 62000, 'sell' => 68000],
                            ['no' => 3, 'name' => 'Baut Baja M8 x 50', 'sku' => 'SKU-BT-M8-50', 'cat' => 'Hardware', 'stock' => 2500, 'unit' => 'Pcs', 'buy' => 1200, 'sell' => 2000],
                            ['no' => 4, 'name' => 'Paku Kayu 3 Inch', 'sku' => 'SKU-PK-3I', 'cat' => 'Hardware', 'stock' => 50, 'unit' => 'Kg', 'buy' => 18000, 'sell' => 22000],
                            ['no' => 5, 'name' => 'Pipa PVC 1/2 Inch', 'sku' => 'SKU-PI-PVC-12', 'cat' => 'Plumbing', 'stock' => 150, 'unit' => 'Batang', 'buy' => 24000, 'sell' => 32000],
                        ];
                    @endphp
                    @foreach($products as $p)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 text-sm text-slate-400 font-medium">{{ $p['no'] }}</td>
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-extrabold text-slate-800">{{ $p['name'] }}</span>
                                <span class="text-[10px] text-slate-400 font-bold tracking-widest">{{ $p['sku'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black uppercase rounded-full">{{ $p['cat'] }}</span>
                        </td>
                        <td class="px-6 py-5 text-sm font-black text-slate-800">{{ $p['stock'] }}</td>
                        <td class="px-6 py-5 text-sm font-medium text-slate-500">{{ $p['unit'] }}</td>
                        <td class="px-6 py-5 text-sm font-medium text-slate-500">Rp {{ number_format($p['buy'], 0, ',', '.') }}</td>
                        <td class="px-6 py-5 text-sm font-bold text-emerald-600">Rp {{ number_format($p['sell'], 0, ',', '.') }}</td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex justify-center gap-2">
                                <button class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-600 hover:text-white transition-all"><i class="fas fa-edit text-xs"></i></button>
                                <button class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all"><i class="fas fa-trash text-xs"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex items-center justify-between">
            <p class="text-xs text-slate-400 font-medium tracking-tight">Menampilkan 1-5 dari 1,300 produk</p>
            <div class="flex items-center gap-2">
                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#2d46b9] text-white text-xs font-bold shadow-md">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-500 text-xs font-bold transition-all">2</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-500 text-xs font-bold transition-all">3</button>
                <span class="text-slate-300 text-xs mx-1 font-bold tracking-widest">...</span>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-500 text-xs font-bold transition-all">260</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-100 hover:bg-slate-100 text-slate-400 text-xs transition-all">
                    <i class="fas fa-chevron-right text-[10px]"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
