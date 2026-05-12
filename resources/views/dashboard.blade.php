@extends('layouts.app')

@section('title', 'StockInfo - Dashboard Control')

@section('content')
<div class="flex justify-between items-end mb-8">
    <div>
        <p class="text-blue-500 font-bold text-[10px] uppercase tracking-[0.2em] mb-1">Dashboard</p>
        <h2 class="text-4xl font-extrabold text-slate-800 tracking-tight">Dashboard Control</h2>
    </div>
    <button class="bg-[#1e40af] text-white px-5 py-2.5 rounded-xl flex items-center gap-2.5 text-xs font-bold shadow-lg shadow-blue-100 hover:scale-105 transition-transform">
        <i class="fas fa-download"></i> Export to Excel
    </button>
</div>

<div class="grid grid-cols-4 gap-6 mb-10">
    <div class="bg-[#2452c1] p-7 rounded-[1.5rem] text-white relative overflow-hidden shadow-xl shadow-blue-100">
        <div class="relative z-10">
            <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest mb-2">Jumlah Stok</p>
            <h3 class="text-2xl font-extrabold">1300 Produk</h3>
        </div>
        <div class="absolute top-6 right-6 bg-white/20 p-2.5 rounded-xl"><i class="fas fa-archive"></i></div>
        <i class="fas fa-box-open absolute -bottom-4 -right-2 text-7xl opacity-10"></i>
    </div>

    <div class="bg-[#cc443a] p-7 rounded-[1.5rem] text-white relative overflow-hidden shadow-xl shadow-red-100">
        <div class="relative z-10">
            <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest mb-2">Stok Rendah</p>
            <h3 class="text-2xl font-extrabold">45 Produk</h3>
        </div>
        <div class="absolute top-6 right-6 bg-white/20 p-2.5 rounded-xl"><i class="fas fa-arrow-trend-down"></i></div>
        <i class="fas fa-chart-line scale-y-[-1] absolute -bottom-4 -right-2 text-7xl opacity-10"></i>
    </div>

    <div class="bg-[#3da56b] p-7 rounded-[1.5rem] text-white relative overflow-hidden shadow-xl shadow-emerald-100">
        <div class="relative z-10">
            <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest mb-2">Stok Masuk</p>
            <h3 class="text-2xl font-extrabold">150 Produk</h3>
        </div>
        <div class="absolute top-6 right-6 bg-white/20 p-2.5 rounded-xl"><i class="fas fa-arrow-trend-up"></i></div>
        <i class="fas fa-chart-line absolute -bottom-4 -right-2 text-7xl opacity-10"></i>
    </div>

    <div class="bg-[#e47d21] p-7 rounded-[1.5rem] text-white relative overflow-hidden shadow-xl shadow-orange-100">
        <div class="relative z-10">
            <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest mb-2">Margin</p>
            <h3 class="text-2xl font-extrabold">32.4%</h3>
            <p class="text-[11px] mt-2 font-semibold opacity-90">Rp 192.300.000</p>
        </div>
        <div class="absolute top-6 right-6 bg-white/20 p-2.5 rounded-xl"><i class="fas fa-wallet"></i></div>
        <i class="fas fa-briefcase absolute -bottom-4 -right-2 text-7xl opacity-10"></i>
    </div>
</div>

<div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm mb-10">
    <div class="flex justify-between items-start mb-12">
        <div>
            <h4 class="font-extrabold text-xl text-slate-800 mb-1">Stock Movement Trends</h4>
            <p class="text-xs font-medium text-slate-400">Volume harian material yang datang dan berangkat.</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-6 mr-4">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-blue-600 rounded-sm"></span>
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Inbound</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-slate-300 rounded-sm"></span>
                    <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Outbound</span>
                </div>
            </div>
            <select class="bg-slate-50 border border-slate-100 text-[10px] font-extrabold text-slate-600 py-2 px-4 rounded-xl outline-none">
                <option>Mingguan</option>
            </select>
        </div>
    </div>

    <div class="flex items-end justify-between h-64 gap-6 px-4">
        <div class="flex-1 flex flex-col items-center gap-4 h-full group">
            <div class="flex-1 w-full flex items-end justify-center gap-1.5 h-full">
                <div class="w-full bg-blue-100 h-1/4 rounded-t-lg transition-all group-hover:bg-blue-200"></div>
                <div class="w-full bg-slate-100 h-[15%] rounded-t-lg transition-all group-hover:bg-slate-200"></div>
            </div>
            <span class="text-[10px] font-extrabold text-slate-300 uppercase tracking-widest">Mon</span>
        </div>
        <div class="flex-1 flex flex-col items-center gap-4 h-full group">
            <div class="flex-1 w-full flex items-end justify-center gap-1.5 h-full">
                <div class="w-full bg-blue-200 h-[45%] rounded-t-lg transition-all"></div>
                <div class="w-full bg-slate-200 h-[30%] rounded-t-lg transition-all"></div>
            </div>
            <span class="text-[10px] font-extrabold text-slate-300 uppercase tracking-widest">Tue</span>
        </div>
        <div class="flex-1 flex flex-col items-center gap-4 h-full group">
            <div class="flex-1 w-full flex items-end justify-center gap-1.5 h-full">
                <div class="w-full bg-blue-400 h-[70%] rounded-t-lg shadow-lg shadow-blue-100"></div>
                <div class="w-full bg-slate-300 h-[50%] rounded-t-lg"></div>
            </div>
            <span class="text-[10px] font-extrabold text-slate-800 uppercase tracking-widest border-b-2 border-blue-500 pb-1">Wed</span>
        </div>
        <div class="flex-1 flex flex-col items-center gap-4 h-full group">
            <div class="flex-1 w-full flex items-end justify-center gap-1.5 h-full">
                <div class="w-full bg-blue-100 h-[40%] rounded-t-lg"></div>
                <div class="w-full bg-slate-200 h-[65%] rounded-t-lg"></div>
            </div>
            <span class="text-[10px] font-extrabold text-slate-300 uppercase tracking-widest">Thu</span>
        </div>
        <div class="flex-1 flex flex-col items-center gap-4 h-full group">
            <div class="flex-1 w-full flex items-end justify-center gap-1.5 h-full">
                <div class="w-full bg-blue-200 h-[80%] rounded-t-lg"></div>
                <div class="w-full bg-slate-100 h-[55%] rounded-t-lg"></div>
            </div>
            <span class="text-[10px] font-extrabold text-slate-300 uppercase tracking-widest">Fri</span>
        </div>
        <div class="flex-1 flex flex-col items-center gap-4 h-full group">
            <div class="flex-1 w-full flex items-end justify-center gap-1.5 h-full">
                <div class="w-full bg-blue-50 h-[15%] rounded-t-lg"></div>
                <div class="w-full bg-slate-50 h-[10%] rounded-t-lg"></div>
            </div>
            <span class="text-[10px] font-extrabold text-slate-300 uppercase tracking-widest">Sat</span>
        </div>
        <div class="flex-1 flex flex-col items-center gap-4 h-full group">
            <div class="flex-1 w-full flex items-end justify-center gap-1.5 h-full">
                <div class="w-full bg-slate-200 h-[45%] rounded-t-lg"></div>
                <div class="w-full bg-slate-50 h-[20%] rounded-t-lg"></div>
            </div>
            <span class="text-[10px] font-extrabold text-slate-300 uppercase tracking-widest">Sun</span>
        </div>
    </div>
</div>

<div class="bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden shadow-sm">
    <div class="p-8 border-b border-slate-50 flex justify-between items-center">
        <div>
            <h4 class="font-extrabold text-xl text-slate-800 mb-1">Low Stock Alert</h4>
            <p class="text-xs font-medium text-slate-400">Daftar barang yang perlu dipesan segera</p>
        </div>
    </div>
    <table class="w-full text-left">
        <thead>
            <tr class="bg-[#1e40af] text-white text-[10px] font-extrabold uppercase tracking-[0.2em]">
                <th class="px-10 py-4">Nama Produk</th>
                <th class="px-10 py-4 text-right">Stok</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-10 py-6">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-paint-roller text-slate-400 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-extrabold text-slate-800 text-base">Cat Tembok Putih 5Kg</p>
                            <p class="text-[10px] text-slate-400 font-bold tracking-widest mt-1">SKU-CAT-WHT-05</p>
                        </div>
                    </div>
                </td>
                <td class="px-10 py-6 text-right">
                    <span class="text-red-500 font-extrabold text-lg">2</span>
                </td>
            </tr>
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-10 py-6">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-toolbox text-slate-400 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-extrabold text-slate-800 text-base">Baut Baja M8</p>
                            <p class="text-[10px] text-slate-400 font-bold tracking-widest mt-1">SKU-BAUT-M8-01</p>
                        </div>
                    </div>
                </td>
                <td class="px-10 py-6 text-right">
                    <span class="text-red-500 font-extrabold text-lg">5</span>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="p-6 text-center">
        <a href="{{ route('produk.index') }}" class="text-[#1e40af] text-xs font-extrabold uppercase tracking-widest hover:underline">Lihat selengkapnya</a>
    </div>
</div>
@endsection
