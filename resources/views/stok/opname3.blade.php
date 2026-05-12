@extends('layouts.app')

@section('title', 'StockInfo - Laporan Stok Opname')

@section('content')
<div class="space-y-8">
    <div class="bg-[#d35400] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-orange-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-archive text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Laporan Periode Stok Opname</h2>
                <div class="flex items-center gap-2 text-orange-100 text-[10px] mt-1 font-bold">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase">STOK OPNAME</span>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="text-white uppercase font-black tracking-widest">LAPORAN</span>
                </div>
            </div>
        </div>
        <i class="fas fa-box absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 mb-8">
        <div class="grid grid-cols-12 gap-8 items-center">
            <div class="col-span-7 space-y-4">
                <div class="space-y-2">
                    <p class="text-xl font-bold text-slate-800">Periode : 01 Sep 2025 s/d 30 Sep 2025</p>
                    <div class="space-y-1 text-slate-600 font-semibold">
                        <p>Jumlah Barang : 10</p>
                        <p>Jumlah Barang Sesuai : 7</p>
                        <p>Jumlah Barang Selisih : 3</p>
                        <p>Status Kerja : Tidak Aktif</p>
                        <p>Pelaporan Stok : Selesai</p>
                    </div>
                </div>
            </div>

            <div class="col-span-5 flex flex-col items-center">
                <div class="relative w-48 h-48 rounded-full border-[16px] border-emerald-500 border-l-rose-500 flex items-center justify-center transform -rotate-45">
                    <div class="absolute top-4 right-4 transform rotate-45 text-[10px] font-bold text-emerald-600">70.0%</div>
                    <div class="absolute top-4 left-4 transform rotate-45 text-[10px] font-bold text-rose-600">30.0%</div>
                </div>
                <div class="mt-6 flex gap-6 text-[10px] font-bold uppercase tracking-widest">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                        <span class="text-slate-500">Sesuai</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-rose-500 rounded-full"></span>
                        <span class="text-slate-500">Selisih</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 overflow-hidden border border-slate-100 rounded-2xl">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-[#2d46b9] text-white text-[10px] font-black uppercase tracking-widest">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nomor SKU</th>
                        <th class="px-6 py-4 text-center">Produk</th>
                        <th class="px-6 py-4 text-center">Stock</th>
                        <th class="px-6 py-4 text-center">Terlapor</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <tr class="text-sm hover:bg-slate-50/50">
                        <td class="px-6 py-5 text-slate-400 font-medium tracking-tight">1</td>
                        <td class="px-6 py-5 font-bold text-blue-600 tracking-tighter">SKU09238231</td>
                        <td class="px-6 py-5 font-medium text-slate-600 text-center">Baja Ringan</td>
                        <td class="px-6 py-5 font-black text-slate-800 text-center tracking-tighter">150</td>
                        <td class="px-6 py-5 font-medium text-slate-500 text-center tracking-tighter">150</td>
                        <td class="px-6 py-5 text-center">
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-full uppercase">Sesuai</span>
                        </td>
                        <td class="px-6 py-5 text-slate-500 font-medium italic">lengkap</td>
                    </tr>
                    <tr class="text-sm hover:bg-slate-50/50">
                        <td class="px-6 py-5 text-slate-400 font-medium tracking-tight">2</td>
                        <td class="px-6 py-5 font-bold text-blue-600 tracking-tighter">SKU09238232</td>
                        <td class="px-6 py-5 font-medium text-slate-600 text-center">Cat</td>
                        <td class="px-6 py-5 font-black text-slate-800 text-center tracking-tighter">20</td>
                        <td class="px-6 py-5 font-medium text-slate-500 text-center tracking-tighter">13</td>
                        <td class="px-6 py-5 text-center">
                            <span class="px-3 py-1 bg-rose-50 text-rose-600 text-[10px] font-black rounded-full uppercase">Selisih</span>
                        </td>
                        <td class="px-6 py-5 text-slate-500 font-medium italic">barang rusak</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex items-center justify-between">
            <p class="text-xs text-slate-400 font-medium">Menampilkan 1-2 dari 1,290 transaksi</p>
            <div class="flex items-center gap-2">
                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#2d46b9] text-white text-xs font-bold shadow-lg shadow-blue-200 transition-all">1</button>
            </div>
        </div>
    </div>
</div>
@endsection
