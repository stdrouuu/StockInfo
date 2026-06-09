@extends('layouts.app')

@section('title', 'StockInfo - Dashboard Control')

@section('content')
<div class="mb-5 sm:mb-8">
    <p class="text-blue-500 font-bold text-[9px] sm:text-[10px] uppercase tracking-[0.2em] mb-1">Dashboard Control</p>
    <h2 class="text-xl sm:text-4xl font-extrabold text-slate-800 tracking-tight">Halo, {{ session('user.name') }} !</h2>
</div>

<div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 mb-10">
    <div class="bg-[#2452c1] p-4 sm:p-7 rounded-[1.25rem] sm:rounded-[1.5rem] text-white relative overflow-hidden shadow-xl shadow-blue-100">
        <div class="relative z-10">
            <p class="text-[9px] sm:text-[10px] font-bold opacity-80 uppercase tracking-widest mb-1.5 sm:mb-2">Jumlah Stok</p>
            <h3 class="text-base sm:text-2xl font-extrabold">{{ number_format($jumlahStok, 0, ',', '.') }} unit</h3>
            <p class="text-[10px] sm:text-[11px] font-bold opacity-75 mt-0.5 sm:mt-1">{{ $jumlahSku }} SKU</p>
        </div>
        <div class="absolute top-4 right-4 sm:top-6 sm:right-6 bg-white/20 p-1.5 sm:p-2.5 rounded-lg sm:rounded-xl text-xs sm:text-base"><i class="fas fa-archive"></i></div>
        <i class="fas fa-box-open absolute -bottom-4 -right-2 text-5xl sm:text-7xl opacity-10"></i>
    </div>

    <div class="bg-[#cc443a] p-4 sm:p-7 rounded-[1.25rem] sm:rounded-[1.5rem] text-white relative overflow-hidden shadow-xl shadow-red-100">
        <div class="relative z-10">
            <p class="text-[9px] sm:text-[10px] font-bold opacity-80 uppercase tracking-widest mb-1.5 sm:mb-2">Stok Rendah</p>
            <h3 class="text-base sm:text-2xl font-extrabold">{{ $stokRendah }} Produk</h3>
        </div>
        <div class="absolute top-4 right-4 sm:top-6 sm:right-6 bg-white/20 p-1.5 sm:p-2.5 rounded-lg sm:rounded-xl text-xs sm:text-base"><i class="fas fa-arrow-trend-down"></i></div>
        <i class="fas fa-chart-line scale-y-[-1] absolute -bottom-4 -right-2 text-5xl sm:text-7xl opacity-10"></i>
    </div>

    <div class="bg-[#3da56b] p-4 sm:p-7 rounded-[1.25rem] sm:rounded-[1.5rem] text-white relative overflow-hidden shadow-xl shadow-emerald-100">
        <div class="relative z-10">
            <p class="text-[9px] sm:text-[10px] font-bold opacity-80 uppercase tracking-widest mb-1.5 sm:mb-2">Transaksi</p>
            <div class="flex items-center gap-2 sm:gap-4 mt-0.5 sm:mt-1">
                <div>
                    <span class="text-[8px] sm:text-[9px] uppercase font-bold tracking-wider opacity-75 block mb-0.5">Masuk</span>
                    <h3 class="text-xs sm:text-xl font-extrabold">{{ number_format($stokMasuk, 0, ',', '.') }}</h3>
                </div>
                <div class="w-px h-6 sm:h-8 bg-white/20 self-end"></div>
                <div>
                    <span class="text-[8px] sm:text-[9px] uppercase font-bold tracking-wider opacity-75 block mb-0.5">Keluar</span>
                    <h3 class="text-xs sm:text-xl font-extrabold">{{ number_format($stokKeluar, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
        <div class="absolute top-4 right-4 sm:top-6 sm:right-6 bg-white/20 p-1.5 sm:p-2.5 rounded-lg sm:rounded-xl text-xs sm:text-base"><i class="fas fa-exchange-alt"></i></div>
        <i class="fas fa-chart-line absolute -bottom-4 -right-2 text-5xl sm:text-7xl opacity-10"></i>
    </div>

    {{-- 
        RBAC: Nilai Inventaris disembunyikan dari staff karena berisi data keuangan/aset yang sensitif.
        Hanya role 'admin' yang dapat melihat nilai total aset toko.
    --}}
    @if(auth()->user()->isAdmin())
    <div class="bg-[#e47d21] p-4 sm:p-7 rounded-[1.25rem] sm:rounded-[1.5rem] text-white relative overflow-hidden shadow-xl shadow-orange-100">
        <div class="relative z-10">
            <p class="text-[9px] sm:text-[10px] font-bold opacity-80 uppercase tracking-widest mb-1.5 sm:mb-2">Nilai Inventaris</p>
            <h3 class="text-xs sm:text-2xl font-extrabold truncate" title="Rp {{ number_format($inventoryValue, 0, ',', '.') }}">Rp {{ number_format($inventoryValue, 0, ',', '.') }}</h3>
        </div>
        <div class="absolute top-4 right-4 sm:top-6 sm:right-6 bg-white/20 p-1.5 sm:p-2.5 rounded-lg sm:rounded-xl text-xs sm:text-base"><i class="fas fa-wallet"></i></div>
        <i class="fas fa-briefcase absolute -bottom-4 -right-2 text-5xl sm:text-7xl opacity-10"></i>
    </div>
    @endif
</div>

<!-- Larapex Chart Integrated Container -->
<div class="bg-white p-4 sm:p-10 rounded-2xl sm:rounded-[2.5rem] border border-slate-100 shadow-sm mb-6 sm:mb-10">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h4 class="font-extrabold text-base sm:text-xl text-slate-800 mb-1">Tren Pergerakan Stok</h4>
            <p class="text-[10px] sm:text-xs font-medium text-slate-400">Volume pergerakan material yang masuk dan keluar.</p>
        </div>
        
        <!-- Premium Segmented Filter Control -->
        <div class="flex bg-slate-100 p-1 rounded-xl border border-slate-200/50 self-end sm:self-auto shadow-inner">
            <a href="{{ route('dashboard.dashboard', ['filter' => 'daily']) }}" 
               class="px-3 sm:px-4 py-1.5 rounded-lg text-[10px] sm:text-xs font-bold transition-all duration-200 {{ $filter === 'daily' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
               Harian
            </a>
            <a href="{{ route('dashboard.dashboard', ['filter' => 'weekly']) }}" 
               class="px-3 sm:px-4 py-1.5 rounded-lg text-[10px] sm:text-xs font-bold transition-all duration-200 {{ $filter === 'weekly' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
               Mingguan
            </a>
            <a href="{{ route('dashboard.dashboard', ['filter' => 'monthly']) }}" 
               class="px-3 sm:px-4 py-1.5 rounded-lg text-[10px] sm:text-xs font-bold transition-all duration-200 {{ $filter === 'monthly' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
               Bulanan
            </a>
        </div>
    </div>
    
    <div class="w-full">
        {!! $chart->container() !!}
    </div>
</div>

<div class="bg-white rounded-2xl sm:rounded-[2.5rem] border border-slate-100 overflow-hidden shadow-sm">
    <div class="p-4 sm:p-8 border-b border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h4 class="font-extrabold text-base sm:text-xl text-slate-800 mb-1">Peringatan Stok Rendah</h4>
            <p class="text-[10px] sm:text-xs font-medium text-slate-400">Daftar barang yang perlu dipesan segera</p>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left min-w-[500px] sm:min-w-0">
        <thead>
            <tr class="bg-[#1e40af] text-white text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-left">
                <th class="px-4 py-3 sm:px-10 sm:py-4 rounded-tl-2xl">No</th>
                <th class="px-4 py-3 sm:px-10 sm:py-4">Gambar</th>
                <th class="px-4 py-3 sm:px-10 sm:py-4">SKU</th>
                <th class="px-4 py-3 sm:px-10 sm:py-4">Nama Produk</th>
                <th class="px-4 py-3 sm:px-10 sm:py-4">Kategori</th>
                <th class="px-4 py-3 sm:px-10 sm:py-4 text-right rounded-tr-2xl">Stok</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse ($lowStockProducts as $index => $produk)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3 sm:px-10 sm:py-6 text-xs sm:text-sm font-bold text-slate-400">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                <td class="px-4 py-3 sm:px-10 sm:py-6">
                    <div class="w-14 h-14 sm:w-24 sm:h-24 bg-slate-100 flex items-center justify-center overflow-hidden border border-slate-200 rounded-xl sm:rounded-none shadow-sm flex-shrink-0">
                        @if ($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" class="w-full h-full object-cover">
                        @else
                            <i class="far fa-image text-slate-300 text-xl"></i>
                        @endif
                    </div>
                </td>
                <td class="px-4 py-3 sm:px-10 sm:py-6 text-xs sm:text-sm font-bold text-slate-700">{{ $produk->sku }}</td>
                <td class="px-4 py-3 sm:px-10 sm:py-6 text-sm sm:text-base font-extrabold text-slate-800">{{ $produk->nama }}</td>
                <td class="px-4 py-3 sm:px-10 sm:py-6 text-xs sm:text-sm font-medium text-slate-600">{{ $produk->kategori->nama ?? 'Umum' }}</td>
                <td class="px-4 py-3 sm:px-10 sm:py-6 text-right">
                    <span class="text-red-500 font-extrabold text-base sm:text-lg">{{ $produk->stok }}</span>
                    <span class="text-[10px] sm:text-xs text-slate-400 font-semibold ml-1">/ Min: {{ $produk->stok_minimum }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-8 sm:px-10 text-center text-slate-400 font-medium text-xs sm:text-sm">Semua produk memiliki stok yang cukup.</td>
            </tr>
            @endforelse
        </tbody>
        </table>
    </div>
    <div class="p-4 sm:p-6 text-center">
        <a href="{{ route('produk.index') }}" class="text-[#1e40af] text-[10px] sm:text-xs font-extrabold uppercase tracking-widest hover:underline">Lihat selengkapnya</a>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
{!! $chart->script() !!}
@endpush
