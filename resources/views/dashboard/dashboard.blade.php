@extends('layouts.app')

@section('title', 'StockInfo - Dashboard Control')

@section('content')
<div class="mb-8">
    <p class="text-blue-500 font-bold text-[10px] uppercase tracking-[0.2em] mb-1">Dashboard</p>
    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-800 tracking-tight">Dashboard Control</h2>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
    <div class="bg-[#2452c1] p-7 rounded-[1.5rem] text-white relative overflow-hidden shadow-xl shadow-blue-100">
        <div class="relative z-10">
            <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest mb-2">Jumlah Stok</p>
            <h3 class="text-2xl font-extrabold">{{ number_format($jumlahStok, 0, ',', '.') }} unit</h3>
        </div>
        <div class="absolute top-6 right-6 bg-white/20 p-2.5 rounded-xl"><i class="fas fa-archive"></i></div>
        <i class="fas fa-box-open absolute -bottom-4 -right-2 text-7xl opacity-10"></i>
    </div>

    <div class="bg-[#cc443a] p-7 rounded-[1.5rem] text-white relative overflow-hidden shadow-xl shadow-red-100">
        <div class="relative z-10">
            <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest mb-2">Stok Rendah</p>
            <h3 class="text-2xl font-extrabold">{{ $stokRendah }} Produk</h3>
        </div>
        <div class="absolute top-6 right-6 bg-white/20 p-2.5 rounded-xl"><i class="fas fa-arrow-trend-down"></i></div>
        <i class="fas fa-chart-line scale-y-[-1] absolute -bottom-4 -right-2 text-7xl opacity-10"></i>
    </div>

    <div class="bg-[#3da56b] p-7 rounded-[1.5rem] text-white relative overflow-hidden shadow-xl shadow-emerald-100">
        <div class="relative z-10">
            <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest mb-2">Stok Masuk</p>
            <h3 class="text-2xl font-extrabold">{{ number_format($stokMasuk, 0, ',', '.') }} unit</h3>
        </div>
        <div class="absolute top-6 right-6 bg-white/20 p-2.5 rounded-xl"><i class="fas fa-arrow-trend-up"></i></div>
        <i class="fas fa-chart-line absolute -bottom-4 -right-2 text-7xl opacity-10"></i>
    </div>

    <div class="bg-[#e47d21] p-7 rounded-[1.5rem] text-white relative overflow-hidden shadow-xl shadow-orange-100">
        <div class="relative z-10">
            <p class="text-[10px] font-bold opacity-80 uppercase tracking-widest mb-2">Nilai Inventaris</p>
            <h3 class="text-2xl font-extrabold">Rp {{ number_format($inventoryValue, 0, ',', '.') }}</h3>
        </div>
        <div class="absolute top-6 right-6 bg-white/20 p-2.5 rounded-xl"><i class="fas fa-wallet"></i></div>
        <i class="fas fa-briefcase absolute -bottom-4 -right-2 text-7xl opacity-10"></i>
    </div>
</div>

<!-- Larapex Chart Integrated Container -->
<div class="bg-white p-6 sm:p-10 rounded-[1.5rem] sm:rounded-[2.5rem] border border-slate-100 shadow-sm mb-10">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h4 class="font-extrabold text-xl text-slate-800 mb-1">Stock Movement Trends</h4>
            <p class="text-xs font-medium text-slate-400">Volume pergerakan material yang masuk dan keluar.</p>
        </div>
        
        <!-- Premium Segmented Filter Control -->
        <div class="flex bg-slate-100 p-1 rounded-xl border border-slate-200/50 self-end sm:self-auto shadow-inner">
            <a href="{{ route('dashboard.dashboard', ['filter' => 'daily']) }}" 
               class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 {{ $filter === 'daily' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
               Harian
            </a>
            <a href="{{ route('dashboard.dashboard', ['filter' => 'weekly']) }}" 
               class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 {{ $filter === 'weekly' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
               Mingguan
            </a>
            <a href="{{ route('dashboard.dashboard', ['filter' => 'monthly']) }}" 
               class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 {{ $filter === 'monthly' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
               Bulanan
            </a>
        </div>
    </div>
    
    <div class="w-full">
        {!! $chart->container() !!}
    </div>
</div>

<div class="bg-white rounded-[1.5rem] sm:rounded-[2.5rem] border border-slate-100 overflow-hidden shadow-sm">
    <div class="p-6 sm:p-8 border-b border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h4 class="font-extrabold text-xl text-slate-800 mb-1">Low Stock Alert</h4>
            <p class="text-xs font-medium text-slate-400">Daftar barang yang perlu dipesan segera</p>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left min-w-[500px] sm:min-w-0">
        <thead>
            <tr class="bg-[#1e40af] text-white text-[10px] font-extrabold uppercase tracking-[0.2em]">
                <th class="px-10 py-4">Nama Produk</th>
                <th class="px-10 py-4 text-right">Stok</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse ($lowStockProducts as $produk)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-10 py-6">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center overflow-hidden">
                            @if ($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" class="w-full h-full object-cover">
                            @else
                                <i class="far fa-image text-slate-300"></i>
                            @endif
                        </div>
                        <div>
                            <p class="font-extrabold text-slate-800 text-base">{{ $produk->nama }}</p>
                            <p class="text-[10px] text-slate-400 font-bold tracking-widest mt-1">{{ $produk->sku }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-10 py-6 text-right">
                    <span class="text-red-500 font-extrabold text-lg">{{ $produk->stok }}</span>
                    <span class="text-xs text-slate-400 font-semibold ml-1">/ Min: {{ $produk->stok_minimum }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="px-10 py-8 text-center text-slate-400 font-medium">Semua produk memiliki stok yang cukup.</td>
            </tr>
            @endforelse
        </tbody>
        </table>
    </div>
    <div class="p-6 text-center">
        <a href="{{ route('produk.index') }}" class="text-[#1e40af] text-xs font-extrabold uppercase tracking-widest hover:underline">Lihat selengkapnya</a>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
{!! $chart->script() !!}
@endpush
