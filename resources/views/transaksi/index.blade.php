@extends('layouts.app')

@section('title', 'StockInfo - Data Transaksi Inventory')

@section('content')
<div class="space-y-8" x-data="{ 
    transactions: [
        {no: '01', id: 'TRX-IN-20240520-001', type: 'Masuk', source: 'PT. Semen Merah Putih', qty: 150, total: 'Rp 9.750.000', date: '20 Mei 2024', status: 'Selesai'},
        {no: '02', id: 'TRX-OUT-20240519-042', type: 'Keluar', source: 'Proyek Bendungan A', qty: 85, total: 'Rp 12.420.000', date: '19 Mei 2024', status: 'Selesai'},
        {no: '03', id: 'TRX-IN-20240519-041', type: 'Masuk', source: 'Distributor Cat Jotun', qty: 20, total: 'Rp 4.500.000', date: '19 Mei 2024', status: 'Selesai'},
        {no: '04', id: 'TRX-OUT-20240518-012', type: 'Keluar', source: 'Workshop Utama', qty: 300, total: 'Rp 3.200.000', date: '18 Mei 2024', status: 'Diproses'},
        {no: '05', id: 'TRX-IN-20240518-011', type: 'Masuk', source: 'PT. Holcim Indonesia', qty: 200, total: 'Rp 11.000.000', date: '18 Mei 2024', status: 'Selesai'}
    ],
    searchQuery: '',
    filterType: 'Semua'
}">
    <!-- Header Section -->
    <div class="bg-[#064e3b] rounded-[40px] p-10 text-white relative overflow-hidden shadow-2xl shadow-emerald-900/20">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="flex items-center gap-8">
                <div class="bg-white/10 p-5 rounded-[24px] backdrop-blur-xl border border-white/20 shadow-inner">
                    <i class="fas fa-exchange-alt text-4xl"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-extrabold tracking-tight">Transaksi Inventory</h2>
                    <div class="flex items-center gap-3 text-emerald-100/80 text-[11px] font-bold mt-2 uppercase tracking-widest">
                        <i class="fas fa-home"></i>
                        <i class="fas fa-chevron-right text-[8px]"></i>
                        <span>Transaksi</span>
                        <i class="fas fa-chevron-right text-[8px]"></i>
                        <span class="text-white">Data Transaksi</span>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <button @click="showModal = true; modalType = 'add-transaction'" class="bg-emerald-500 hover:bg-emerald-400 text-white px-8 py-4 rounded-2xl text-sm font-black flex items-center gap-3 transition-all transform hover:scale-105 active:scale-95 shadow-xl shadow-emerald-900/40">
                    <i class="fas fa-plus"></i>
                    TAMBAH TRANSAKSI
                </button>
            </div>
        </div>
        
        <!-- Abstract Background Elements -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -mr-20 -mt-20 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-400/10 rounded-full -ml-20 -mb-20 blur-3xl"></div>
        <i class="fas fa-boxes-stacked absolute -right-12 -bottom-16 text-[240px] opacity-[0.03] -rotate-12 pointer-events-none"></i>
    </div>

    <!-- Stats Section (Subtle) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5 group hover:border-emerald-200 transition-all">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <i class="fas fa-arrow-down text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Stock Masuk</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">1,240 <span class="text-xs font-bold text-slate-400">Items</span></h4>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5 group hover:border-rose-200 transition-all">
            <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <i class="fas fa-arrow-up text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Stock Keluar</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">852 <span class="text-xs font-bold text-slate-400">Items</span></h4>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-[40px] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
        <!-- Filter Bar -->
        <div class="p-8 border-b border-slate-50 flex flex-wrap items-center justify-between gap-6">
            <div class="flex items-center gap-4 flex-1 min-w-[300px]">
                <div class="relative flex-1 group">
                    <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                    <input type="text" x-model="searchQuery" placeholder="Cari kode transaksi, sumber, atau item..." class="w-full pl-12 pr-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-slate-400">
                </div>
                <div class="flex bg-slate-50 p-1.5 rounded-2xl">
                    <button @click="filterType = 'Semua'" :class="filterType === 'Semua' ? 'bg-white shadow-md text-blue-600' : 'text-slate-500 hover:text-slate-700'" class="px-6 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all">Semua</button>
                    <button @click="filterType = 'Masuk'" :class="filterType === 'Masuk' ? 'bg-white shadow-md text-emerald-600' : 'text-slate-500 hover:text-slate-700'" class="px-6 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all">Masuk</button>
                    <button @click="filterType = 'Keluar'" :class="filterType === 'Keluar' ? 'bg-white shadow-md text-rose-600' : 'text-slate-500 hover:text-slate-700'" class="px-6 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all">Keluar</button>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <button class="bg-[#2d46b9] hover:bg-blue-800 text-white px-8 py-4 rounded-2xl text-xs font-black flex items-center gap-3 transition-all shadow-lg shadow-blue-200">
                    <i class="fas fa-file-pdf"></i>
                    EKSPOR PDF
                </button>
                <button class="w-14 h-14 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 hover:bg-slate-50 transition-all">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-separate border-spacing-0">
                <thead>
                    <tr class="bg-[#2d46b9] text-white text-[10px] font-black uppercase tracking-[0.2em] text-left">
                        <th class="px-8 py-6 rounded-tl-2xl">No</th>
                        <th class="px-8 py-6">Kode Transaksi</th>
                        <th class="px-8 py-6 text-center">Tipe</th>
                        <th class="px-8 py-6">Asal / Tujuan</th>
                        <th class="px-8 py-6 text-center">Total Item</th>
                        <th class="px-8 py-6">Total Nilai</th>
                        <th class="px-8 py-6">Tanggal</th>
                        <th class="px-8 py-6 text-center rounded-tr-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <template x-for="(trx, index) in transactions" :key="index">
                        <tr x-show="(filterType === 'Semua' || trx.type === filterType) && (trx.id.toLowerCase().includes(searchQuery.toLowerCase()) || trx.source.toLowerCase().includes(searchQuery.toLowerCase()))" class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-7 text-sm font-bold text-slate-400" x-text="trx.no"></td>
                            <td class="px-8 py-7">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-800 group-hover:text-blue-600 transition-colors" x-text="trx.id"></span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tight mt-0.5" x-text="trx.status"></span>
                                </div>
                            </td>
                            <td class="px-8 py-7 text-center">
                                <span :class="trx.type === 'Masuk' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600'" class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest" x-text="trx.type"></span>
                            </td>
                            <td class="px-8 py-7 text-sm font-semibold text-slate-600" x-text="trx.source"></td>
                            <td class="px-8 py-7 text-center text-sm font-bold text-slate-800" x-text="trx.qty"></td>
                            <td class="px-8 py-7 text-sm font-black text-slate-800" x-text="trx.total"></td>
                            <td class="px-8 py-7 text-sm font-medium text-slate-500" x-text="trx.date"></td>
                            <td class="px-8 py-7">
                                <div class="flex items-center justify-center gap-3 transition-opacity">
                                    <button class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-blue-600 hover:border-blue-200 transition-all">
                                        <i class="far fa-eye text-sm"></i>
                                    </button>
                                    <button class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-red-600 hover:border-red-200 transition-all">
                                        <i class="far fa-trash-alt text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-8 bg-slate-50/50 flex items-center justify-between border-t border-slate-100">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Menampilkan 5 dari 124 Transaksi</span>
            <div class="flex items-center gap-3">
                <button class="w-11 h-11 flex items-center justify-center bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-slate-800 transition-all">
                    <i class="fas fa-chevron-left text-xs"></i>
                </button>
                <div class="flex items-center gap-2">
                    <button class="w-11 h-11 flex items-center justify-center rounded-xl bg-[#2d46b9] text-white text-sm font-black shadow-lg shadow-blue-200">1</button>
                    <button class="w-11 h-11 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-500 text-sm font-bold hover:bg-slate-50 transition-all">2</button>
                    <button class="w-11 h-11 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-500 text-sm font-bold hover:bg-slate-50 transition-all">3</button>
                </div>
                <button class="w-11 h-11 flex items-center justify-center bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-slate-800 transition-all">
                    <i class="fas fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal-content')
<!-- Input Transaksi Modal -->
<div x-show="modalType === 'add-transaction'" x-data="{ 
    step: 1, 
    type: 'Masuk',
    items: [{id: 1, name: '', qty: 1, price: 0}],
    addItem() {
        this.items.push({id: Date.now(), name: '', qty: 1, price: 0});
    },
    removeItem(index) {
        if (this.items.length > 1) this.items.splice(index, 1);
    }
}">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h2 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.25em] mb-1">Pencatatan Transaksi</h2>
            <h3 class="text-2xl font-extrabold text-slate-800">Tambah Transaksi Baru</h3>
        </div>
        <div class="flex gap-1.5">
            <template x-for="i in 2">
                <div :class="step >= i ? 'bg-blue-600 w-8' : 'bg-slate-200 w-3'" class="h-1.5 rounded-full transition-all duration-500"></div>
            </template>
        </div>
    </div>

    <form class="space-y-8">
        <!-- Step 1: Basic Info -->
        <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div class="md:col-span-2">
                    <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1 mb-3">Tipe Transaksi</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="trx_type" value="Masuk" x-model="type" class="peer hidden">
                            <div class="flex items-center gap-4 px-6 py-4 rounded-2xl bg-slate-50 border-2 border-transparent peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all group-hover:bg-slate-100">
                                <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-emerald-600">
                                    <i class="fas fa-download"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-800">Barang Masuk</p>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-tight">Stock Replenishment</p>
                                </div>
                            </div>
                        </label>
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="trx_type" value="Keluar" x-model="type" class="peer hidden">
                            <div class="flex items-center gap-4 px-6 py-4 rounded-2xl bg-slate-50 border-2 border-transparent peer-checked:border-rose-500 peer-checked:bg-rose-50 transition-all group-hover:bg-slate-100">
                                <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-rose-600">
                                    <i class="fas fa-upload"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-800">Barang Keluar</p>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-tight">Stock Distribution</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Tanggal Transaksi</label>
                    <input type="date" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1" x-text="type === 'Masuk' ? 'Supplier / Pengirim' : 'Penerima / Proyek'"></label>
                    <div class="relative">
                        <input type="text" :placeholder="type === 'Masuk' ? 'Cari Supplier...' : 'Cari Tujuan...'" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                        <i class="fas fa-search absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-2">
                    <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Keterangan (Opsional)</label>
                    <textarea placeholder="Catatan tambahan untuk transaksi ini..." rows="3" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 outline-none transition-all"></textarea>
                </div>
            </div>
        </div>

        <!-- Step 2: Items -->
        <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-6">
            <div class="flex items-center justify-between">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Daftar Barang</h4>
                <button type="button" @click="addItem()" class="text-[#2d46b9] hover:text-blue-800 text-xs font-black flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    TAMBAH BARANG
                </button>
            </div>

            <div class="max-h-[300px] overflow-y-auto pr-2 space-y-4 custom-scrollbar">
                <template x-for="(item, index) in items" :key="item.id">
                    <div class="p-5 rounded-2xl border border-slate-100 bg-slate-50/50 flex flex-wrap md:flex-nowrap items-end gap-4 relative group">
                        <div class="flex-1 min-w-[200px] space-y-2">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block ml-1">Nama Barang</label>
                            <select class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Barang...</option>
                                <option>Semen Merah Putih 50kg</option>
                                <option>Besi Beton 12mm</option>
                                <option>Pasir Putih Bangka</option>
                            </select>
                        </div>
                        <div class="w-24 space-y-2">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block ml-1">Qty</label>
                            <input type="number" x-model="item.qty" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="w-40 space-y-2">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block ml-1">Harga Satuan</label>
                            <input type="text" placeholder="Rp 0" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="button" @click="removeItem(index)" class="w-10 h-10 flex items-center justify-center rounded-xl text-slate-300 hover:text-red-500 transition-colors mb-0.5">
                            <i class="fas fa-trash-alt text-sm"></i>
                        </button>
                    </div>
                </template>
            </div>

            <div class="p-6 bg-blue-50 rounded-2xl flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Estimasi Total</p>
                    <p class="text-xl font-black text-blue-600">Rp 0</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Total Qty</p>
                    <p class="text-xl font-black text-blue-600" x-text="items.reduce((acc, curr) => acc + parseInt(curr.qty || 0), 0)"></p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-6 border-t border-slate-50">
            <button type="button" @click="showModal = false" class="px-8 py-4 text-slate-400 hover:text-slate-600 text-sm font-bold transition-colors">Batal</button>
            <div class="flex gap-3">
                <button type="button" x-show="step === 2" @click="step = 1" class="px-8 py-4 bg-slate-100 hover:bg-slate-200 text-slate-800 text-sm font-black rounded-2xl transition-all">Kembali</button>
                <button type="button" x-show="step === 1" @click="step = 2" class="px-10 py-4 bg-[#2d46b9] hover:bg-blue-800 text-white text-sm font-black rounded-2xl shadow-xl shadow-blue-200 transition-all flex items-center gap-3">
                    Lanjutkan
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </button>
                <button type="submit" x-show="step === 2" @click.prevent="showModal = false; step = 1" class="px-10 py-4 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-black rounded-2xl shadow-xl shadow-emerald-100 transition-all">Simpan Transaksi</button>
            </div>
        </div>
    </form>
</div>
@endsection
