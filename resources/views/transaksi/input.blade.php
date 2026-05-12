@extends('layouts.app')

@section('title', 'StockInfo - Form Input Transaksi Masuk')

@section('content')
<div class="space-y-8">
    <div class="bg-[#064e3b] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-emerald-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-chart-line text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Form Input Transaksi Masuk</h2>
                <div class="flex items-center gap-2 text-emerald-100 text-xs mt-1">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase tracking-wider">TRANSAKSI MASUK</span>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="font-bold text-white uppercase tracking-wider">INPUT</span>
                </div>
            </div>
        </div>
        <i class="fas fa-arrow-trend-up absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
        <div class="grid grid-cols-12 gap-8">
            <div class="col-span-7 space-y-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pengirim / Supplier</label>
                    <input type="text" value="PT. Rimba Jaya Abadi" class="w-full px-5 py-3 bg-[#f1f5f9] border-none rounded-xl text-sm font-medium text-slate-600 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kontak Person</label>
                    <input type="text" value="Hendra Setiawan" class="w-full px-5 py-3 bg-[#f1f5f9] border-none rounded-xl text-sm font-medium text-slate-600 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Transaksi</label>
                    <input type="text" value="08-05-2026" class="w-full px-5 py-3 bg-[#f1f5f9] border-none rounded-xl text-sm font-medium text-slate-600 outline-none">
                </div>
            </div>
            <div class="col-span-5 space-y-2 flex flex-col h-full">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Keterangan Tambahan</label>
                <textarea class="flex-1 w-full px-5 py-4 bg-[#f1f5f9] border-none rounded-xl text-sm font-medium text-slate-600 outline-none resize-none">Pengiriman stok rutin bulanan. Kondisi material kering dan sudah diperiksa.</textarea>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-slate-100">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Input Item Produk</h3>
            </div>

            <div class="grid grid-cols-12 gap-4 items-end">
                <div class="col-span-5 space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pilih Produk</label>
                    <div class="relative">
                        <select class="w-full px-5 py-3 bg-[#f1f5f9] border-none rounded-xl text-sm font-medium text-slate-400 appearance-none outline-none">
                            <option>Pilih Produk</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                    </div>
                </div>
                <div class="col-span-2 space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest text-center block">Qty</label>
                    <input type="number" value="0" class="w-full px-5 py-3 bg-[#f1f5f9] border-none rounded-xl text-sm font-medium text-slate-600 text-center outline-none">
                </div>
                <div class="col-span-3 space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block">Harga Satuan (Rp)</label>
                    <input type="number" value="0" class="w-full px-5 py-3 bg-[#f1f5f9] border-none rounded-xl text-sm font-medium text-slate-600 outline-none">
                </div>
                <div class="col-span-2">
                    <button class="w-full bg-[#2d46b9] hover:bg-blue-800 text-white py-3 rounded-xl text-sm font-bold flex items-center justify-center gap-2 shadow-lg shadow-blue-200 transition-all">
                        <i class="fas fa-plus"></i>
                        Tambahkan
                    </button>
                </div>
            </div>

            <div class="mt-8 overflow-hidden rounded-2xl border border-slate-100">
                <table class="w-full">
                    <thead>
                        <tr class="bg-[#2d46b9] text-white text-[10px] font-black uppercase tracking-widest text-left">
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Produk</th>
                            <th class="px-6 py-4">Qty</th>
                            <th class="px-6 py-4">Harga</th>
                            <th class="px-6 py-4">Sub Total</th>
                            <th class="px-6 py-4 text-center">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="py-20 text-center">
                                <div class="flex flex-col items-center gap-3 opacity-20">
                                    <i class="fas fa-archive text-4xl"></i>
                                    <p class="text-sm font-bold uppercase tracking-widest">Belum ada item yang ditambahkan</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-10 flex flex-col items-end">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Grand Total</p>
                <h4 class="text-5xl font-black text-[#2d46b9] mt-2 tracking-tighter">Rp 0</h4>
                <button class="mt-8 bg-[#2d46b9] hover:bg-blue-800 text-white px-10 py-4 rounded-2xl text-sm font-bold flex items-center gap-3 shadow-xl shadow-blue-200 transition-all">
                    <i class="fas fa-save"></i>
                    Simpan Transaksi
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
