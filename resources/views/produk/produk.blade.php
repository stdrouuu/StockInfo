@extends('layouts.app')

@section('title', 'StockInfo - Data Produk')

@section('content')
<div class="space-y-8">
    <!-- Page Title Card -->
    <div class="bg-[#1e40af] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-blue-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-box text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Data Produk</h2>
                <p class="text-blue-100 text-sm mt-1">Dashboard > Data Produk</p>
            </div>
        </div>
        <!-- Decorative Background Icon -->
        <i class="fas fa-box-open absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                <i class="fas fa-boxes-stacked text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total SKU</p>
                <p class="text-2xl font-bold">1,284</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600">
                <i class="fas fa-exclamation-triangle text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Stok Rendah</p>
                <p class="text-2xl font-bold">14</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600">
                <i class="fas fa-truck text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Dalam Transit</p>
                <p class="text-2xl font-bold">82</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                <i class="fas fa-hand-holding-dollar text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Inv. Value</p>
                <p class="text-2xl font-bold">Rp 5.000.000</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden" x-data="{ openFilter: false }">
        <!-- Table Toolbar -->
        <div class="p-6 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4 flex-1">
                <div class="relative w-full max-w-md">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" placeholder="Cari Produk..." class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                <div class="relative">
                    <button @click="openFilter = !openFilter" class="px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold flex items-center gap-2 hover:bg-slate-100 transition-all">
                        <i class="fas fa-sort-amount-down text-slate-400"></i>
                        Stock
                        <i class="fas fa-chevron-down text-[10px] transition-transform" :class="openFilter ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openFilter" @click.away="openFilter = false" x-cloak class="absolute left-0 mt-2 w-48 bg-white border border-slate-100 rounded-2xl shadow-xl z-30 overflow-hidden">
                        <a href="#" class="block px-6 py-3 text-xs font-bold text-slate-600 hover:bg-slate-50">Tinggi ke Rendah</a>
                        <a href="#" class="block px-6 py-3 text-xs font-bold text-slate-600 hover:bg-slate-50">Rendah ke Tinggi</a>
                        <a href="#" class="block px-6 py-3 text-xs font-bold text-slate-600 hover:bg-slate-50">Stok Kritis</a>
                    </div>
                </div>
            </div>
            <button @click="showModal = true; modalType = 'add-product'" class="bg-[#1e40af] hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 shadow-lg shadow-blue-200 transition-all">
                <i class="fas fa-plus"></i>
                Produk Baru
            </button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-[#1e40af] text-white text-[11px] font-bold uppercase tracking-widest text-left">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">SKU</th>
                        <th class="px-6 py-4">Nama Produk</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Stok</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-5 text-slate-400 text-sm">01</td>
                        <td class="px-6 py-5 font-bold text-slate-700 text-sm">ST-001-CM</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                                    <i class="far fa-image text-slate-300"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Semen Tiga Roda 50kg</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase">Indocement</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-sm text-slate-600 font-medium">Semen & Mortar</td>
                        <td class="px-6 py-5 text-sm font-bold text-slate-700">850</td>
                        <td class="px-6 py-5 text-sm font-bold text-slate-700">Rp 65.000</td>
                        <td class="px-6 py-5">
                            <div class="flex justify-center gap-2">
                                <button @click="showModal = true; modalType = 'add-product'" class="p-2 text-slate-400 hover:text-blue-600 transition-colors"><i class="far fa-edit"></i></button>
                                <button @click="showDeleteModal = true; deleteTarget = 'Semen Tiga Roda 50kg'" class="p-2 text-slate-400 hover:text-rose-600 transition-colors"><i class="far fa-trash-alt"></i></button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 2 (Low Stock) -->
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-5 text-slate-400 text-sm">02</td>
                        <td class="px-6 py-5 font-bold text-slate-700 text-sm">BS-002-8MM</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                                    <i class="far fa-image text-slate-300"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Besi Beton 8mm SNI</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase">Krakatau Steel</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-sm text-slate-600 font-medium">Besi & Baja</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-rose-600">15</span>
                                <span class="px-2 py-0.5 bg-rose-50 text-rose-600 text-[9px] font-bold uppercase rounded">Low</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-sm font-bold text-slate-700">Rp 45.000</td>
                        <td class="px-6 py-5">
                            <div class="flex justify-center gap-2">
                                <button @click="showModal = true; modalType = 'add-product'" class="p-2 text-slate-400 hover:text-blue-600 transition-colors"><i class="far fa-edit"></i></button>
                                <button @click="showDeleteModal = true; deleteTarget = 'Semen Tiga Roda 50kg'" class="p-2 text-slate-400 hover:text-rose-600 transition-colors"><i class="far fa-trash-alt"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-6 border-t border-slate-100 flex items-center justify-between">
            <button class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-400 hover:bg-slate-50 transition-all">Sebelumnya</button>
            <div class="flex items-center gap-2">
                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-600 text-white text-xs font-bold">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-500 text-xs font-bold">2</button>
            </div>
            <button class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Selanjutnya</button>
        </div>
    </div>
</div>
@endsection

@section('modal-content')
<div x-show="modalType === 'add-product'">
    <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Tambah & Edit Produk</h2>
    
    <form class="space-y-5">
        <div class="grid grid-cols-2 gap-5">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Nama Produk</label>
                <input type="text" placeholder="Besi Beton Polos 10mm (12m)" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">No. SKU</label>
                <div class="relative">
                    <select class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>ST-BPN-10-001</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px]"></i>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Kategori</label>
                <div class="relative">
                    <select class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>BESI & BAJA</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px]"></i>
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Jumlah Produk</label>
                <input type="number" placeholder="500" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Harga</label>
                <input type="text" placeholder="95.000" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Jumlah Minimum Produk</label>
                <input type="number" placeholder="50" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
        </div>

        <div class="w-full h-32 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50 flex items-center justify-center flex-col gap-2 hover:bg-slate-100 transition-all cursor-pointer group">
            <i class="far fa-image text-slate-300 text-2xl group-hover:text-blue-400 transition-colors"></i>
            <span class="text-xs font-semibold text-slate-400 group-hover:text-slate-500">Upload Image</span>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <button type="button" @click="showModal = false" class="px-8 py-2.5 bg-slate-100 text-slate-800 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">Batal</button>
            <button type="submit" class="px-8 py-2.5 bg-[#2d46b9] text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-200 hover:bg-blue-800 transition-all">Simpan</button>
        </div>
    </form>
</div>
@endsection
