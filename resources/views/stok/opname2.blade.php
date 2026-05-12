@extends('layouts.app')

@section('title', 'StockInfo - Form Input Stok Opname')

@section('content')
<div class="space-y-8">
    <div class="bg-[#d35400] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-orange-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-archive text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Form Input Stok Opname</h2>
                <div class="flex items-center gap-2 text-orange-100 text-[10px] mt-1 font-bold">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase">STOK OPNAME</span>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="text-white uppercase font-black tracking-widest">INPUT</span>
                </div>
            </div>
        </div>
        <i class="fas fa-box absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden p-6">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-[#1e40af] text-white text-[10px] font-black uppercase tracking-widest">
                    <th class="px-6 py-4 rounded-tl-2xl">No</th>
                    <th class="px-6 py-4">Nomor SKU</th>
                    <th class="px-6 py-4 text-center">Produk</th>
                    <th class="px-6 py-4 text-center">Stok</th>
                    <th class="px-6 py-4 text-center">Jumlah Terlapor</th>
                    <th class="px-6 py-4 text-center">Status Pelaporan</th>
                    <th class="px-6 py-4 text-center">Keterangan</th>
                    <th class="px-6 py-4 rounded-tr-2xl text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <tr class="hover:bg-slate-50/50">
                    <td class="px-6 py-6 text-sm text-slate-400 font-medium">1</td>
                    <td class="px-6 py-6 text-sm font-bold text-blue-700">SKU000001</td>
                    <td class="px-6 py-6 text-sm font-semibold text-slate-600 text-center">Semen Tiga Roda 50kg</td>
                    <td class="px-6 py-6 text-sm font-black text-slate-800 text-center">150</td>
                    <td class="px-6 py-6 text-sm font-medium text-slate-500 text-center">150</td>
                    <td class="px-6 py-6 text-center">
                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-full">SESUAI</span>
                    </td>
                    <td class="px-6 py-6 text-sm text-slate-400 text-center italic">sesuai</td>
                    <td class="px-6 py-6 text-center">
                        <button @click="showModal = true; modalType = 'report-opname'" class="bg-[#1e40af] text-white text-[10px] font-black px-4 py-1.5 rounded-lg uppercase shadow-lg shadow-blue-100">Laporkan</button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50/50">
                    <td class="px-6 py-6 text-sm text-slate-400 font-medium">2</td>
                    <td class="px-6 py-6 text-sm font-bold text-blue-700">SKU000002</td>
                    <td class="px-6 py-6 text-sm font-semibold text-slate-600 text-center">Semen Tiga Roda 50kg</td>
                    <td class="px-6 py-6 text-sm font-black text-slate-800 text-center">87</td>
                    <td class="px-6 py-6 text-sm font-medium text-slate-500 text-center">2</td>
                    <td class="px-6 py-6 text-center">
                        <span class="px-3 py-1 bg-rose-50 text-rose-600 text-[10px] font-black rounded-full">SELISIH</span>
                    </td>
                    <td class="px-6 py-6 text-sm text-slate-400 text-center italic leading-tight">barang<br>rusak</td>
                    <td class="px-6 py-6 text-center">
                        <button @click="showModal = true; modalType = 'report-opname'" class="bg-[#1e40af] text-white text-[10px] font-black px-4 py-1.5 rounded-lg uppercase">Laporkan</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-8 flex items-center justify-between">
            <p class="text-xs text-slate-400 font-medium">Menampilkan 1-2 dari 1,290 transaksi</p>
            <div class="flex items-center gap-2">
                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-600 text-white text-xs font-bold shadow-md">1</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal-content')
<div x-show="modalType === 'report-opname'">
    <h2 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.25em] mb-8">Input Stok Opname</h2>
    <form action="#" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Nama Produk</label>
                <input type="text" value="Besi Beton Polos 10mm (12m)" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">No. SKU</label>
                <div class="relative">
                    <select class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium appearance-none focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all">
                        <option>ST-BPN-10-001</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Jumlah Stok</label>
                <input type="number" value="41" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Jumlah Dilaporkan</label>
                <input type="number" value="35" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all">
            </div>
        </div>
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Keterangan</label>
            <textarea rows="4" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all resize-none" placeholder="Tuliskan keterangan jika ada selisih stok...">barang ada yang rusak</textarea>
        </div>
        <div class="flex items-center justify-end gap-3 pt-4">
            <button type="button" @click="showModal = false" class="px-10 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-800 text-sm font-bold rounded-xl transition-colors">Batal</button>
            <button type="submit" class="px-10 py-3.5 bg-[#2d46b9] hover:bg-blue-800 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-200 transition-all">Simpan</button>
        </div>
    </form>
</div>
@endsection
