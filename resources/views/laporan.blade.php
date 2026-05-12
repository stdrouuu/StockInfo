@extends('layouts.app')

@section('title', 'StockInfo - Laporan')

@section('content')
<div class="space-y-8">
    <div class="bg-[#d32f2f] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-red-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-archive text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Laporan</h2>
                <div class="flex items-center gap-2 text-red-100 text-xs mt-1">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase tracking-wider font-bold text-white">Laporan</span>
                </div>
            </div>
        </div>
        <i class="fas fa-file-alt absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-7 bg-white rounded-3xl border border-slate-100 shadow-sm p-8 flex justify-between items-center relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Inventory Value</p>
                <h3 class="text-4xl font-black text-slate-800">Rp 45.000.000</h3>
                <p class="text-xs text-slate-400 mt-2 font-medium">Calculated across 4,102 unique SKU entries.</p>
            </div>
            <i class="fas fa-wallet text-[120px] text-slate-50 absolute -right-4 -bottom-4"></i>
        </div>
        <div class="col-span-5 bg-white rounded-3xl border border-slate-100 shadow-sm p-8 flex flex-col justify-between">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Active SKUs</p>
                <h3 class="text-4xl font-black text-slate-800">3,842</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-8 bg-white rounded-3xl border border-slate-200 shadow-sm p-8 space-y-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                    <h4 class="font-bold text-slate-800">Low Stock Alerts</h4>
                </div>
                <a href="#" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">View All Alerts</a>
            </div>

            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">
                        <th class="pb-4">Item Description</th>
                        <th class="pb-4">SKU</th>
                        <th class="pb-4">Current</th>
                        <th class="pb-4 text-center">Min. Level</th>
                        <th class="pb-4">Status</th>
                        <th class="pb-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <tr class="text-sm group">
                        <td class="py-4 font-bold text-slate-700">Industrial Steel Beam 12ft</td>
                        <td class="py-4 text-slate-400 font-medium">ST-BL-1209</td>
                        <td class="py-4 font-black text-red-500">12</td>
                        <td class="py-4 text-slate-400 font-medium text-center">45</td>
                        <td class="py-4">
                            <span class="px-2 py-0.5 bg-red-50 text-red-600 text-[9px] font-black uppercase rounded">Critical</span>
                        </td>
                        <td class="py-4 text-right">
                            <button class="text-blue-600 font-bold text-xs hover:underline">Reorder Now</button>
                        </td>
                    </tr>
                    <tr class="text-sm">
                        <td class="py-4 font-bold text-slate-700">Reinforced Concrete Mix</td>
                        <td class="py-4 text-slate-400 font-medium">CM-RF-50KG</td>
                        <td class="py-4 font-black text-slate-700">156</td>
                        <td class="py-4 text-slate-400 font-medium text-center">200</td>
                        <td class="py-4">
                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase rounded">Low</span>
                        </td>
                        <td class="py-4 text-right">
                            <button class="text-blue-600 font-bold text-xs hover:underline">Reorder Now</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="flex justify-end gap-3 pt-6">
                <button class="px-6 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold flex items-center gap-2 hover:bg-slate-200 transition-all">
                    <i class="fas fa-file-pdf"></i> Export to PDF
                </button>
                <button class="px-6 py-2.5 bg-[#2d46b9] text-white rounded-xl text-xs font-bold flex items-center gap-2 hover:bg-blue-800 transition-all shadow-lg shadow-blue-200">
                    <i class="fas fa-file-excel"></i> Export to Excel
                </button>
            </div>
        </div>

        <div class="col-span-4 bg-white rounded-3xl border border-slate-200 shadow-sm p-8 flex flex-col">
            <div class="mb-8">
                <h4 class="font-bold text-slate-800">Riwayat Transaksi</h4>
                <p class="text-[10px] text-slate-400 font-medium mt-1">Log aktivitas operasional gudang secara langsung</p>
            </div>

            <div class="flex-1 space-y-6">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-green-50 text-green-600 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-slate-800">Concrete Mesh</p>
                        <p class="text-[9px] font-black text-green-500 uppercase">Inbound</p>
                    </div>
                    <span class="text-[10px] text-slate-300 font-bold uppercase">10:45 AM</span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-slate-50 text-slate-400 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-slate-800">Portland Cement (Type I)</p>
                        <p class="text-[9px] font-black text-red-400 uppercase">Outbound</p>
                    </div>
                    <span class="text-[10px] text-slate-300 font-bold uppercase">09:12 AM</span>
                </div>
            </div>

            <a href="{{ route('transaksi.index') }}" class="w-full block bg-slate-50 text-slate-500 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest mt-8 hover:bg-slate-100 transition-all text-center">
                Lihat Semua Transaksi
            </a>
        </div>
    </div>
</div>
@endsection
