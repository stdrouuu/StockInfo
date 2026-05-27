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
                    <p class="text-xl font-bold text-slate-800">Periode : {{ $periode->tanggal_mulai->format('d M Y') }} s/d {{ $periode->tanggal_selesai->format('d M Y') }}</p>
                    <div class="space-y-1.5 text-slate-600 font-semibold">
                        <p>Jumlah Barang : {{ $totalItems }}</p>
                        <p>Jumlah Barang Sesuai : {{ $totalSesuai }}</p>
                        <p>Jumlah Barang Selisih : {{ $totalSelisih }}</p>
                        <p>Status Kerja : {{ str_replace('_', ' ', $periode->status_kerja) }}</p>
                        <p>Pelaporan Stok : {{ str_replace('_', ' ', $periode->status_pelaporan) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-span-5 flex flex-col items-center">
                <!-- Premium Dynamic Pie Chart using CSS conic-gradient -->
                <div class="relative w-48 h-48 rounded-full flex items-center justify-center shadow-md border-4 border-white" 
                     style="background: conic-gradient(#10b981 0% {{ $sesuaiPercent }}%, #ef4444 {{ $sesuaiPercent }}% 100%)">
                    <!-- Innermost circle for donut hole aesthetic -->
                    <div class="w-32 h-32 rounded-full bg-white flex flex-col items-center justify-center shadow-inner">
                        <span class="text-2xl font-black text-slate-800">{{ $sesuaiPercent }}%</span>
                        <span class="text-[9px] font-black uppercase text-slate-400 tracking-wider">Akurasi</span>
                    </div>
                </div>
                <div class="mt-6 flex gap-6 text-[10px] font-bold uppercase tracking-widest">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                        <span class="text-slate-500">Sesuai ({{ $sesuaiPercent }}%)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-rose-500 rounded-full"></span>
                        <span class="text-slate-500">Selisih ({{ $selisihPercent }}%)</span>
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
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4 text-center">Stok Sistem</th>
                        <th class="px-6 py-4 text-center">Terlapor</th>
                        <th class="px-6 py-4 text-center">Selisih</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($items as $index => $item)
                    <tr class="text-sm hover:bg-slate-50/50">
                        <td class="px-6 py-5 text-slate-400 font-medium tracking-tight">{{ str_pad($index + 1 + ($items->currentPage() - 1) * $items->perPage(), 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-5 font-bold text-blue-600 tracking-tighter">{{ $item->produk->sku }}</td>
                        <td class="px-6 py-5 font-semibold text-slate-700">{{ $item->produk->nama }}</td>
                        <td class="px-6 py-5 font-black text-slate-800 text-center tracking-tighter">{{ $item->stok_sistem }}</td>
                        <td class="px-6 py-5 font-medium text-slate-500 text-center tracking-tighter">{{ $item->stok_fisik }}</td>
                        <td class="px-6 py-5 font-bold text-center tracking-tighter {{ $item->selisih < 0 ? 'text-rose-500' : ($item->selisih > 0 ? 'text-emerald-500' : 'text-slate-600') }}">
                            {{ $item->selisih > 0 ? '+' : '' }}{{ $item->selisih }}
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($item->catatan === 'belum dilaporkan')
                                <span class="px-3 py-1 bg-amber-50 text-amber-600 text-[10px] font-black rounded-full uppercase">BELUM</span>
                            @elseif($item->selisih === 0)
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-full uppercase font-black">Sesuai</span>
                            @else
                                <span class="px-3 py-1 bg-rose-50 text-rose-600 text-[10px] font-black rounded-full uppercase font-black font-black">Selisih</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-slate-500 font-medium italic">{{ $item->catatan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-slate-400 font-medium">Tidak ada barang dalam laporan stok opname ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex items-center justify-between">
            <p class="text-xs text-slate-400 font-medium">
                Menampilkan {{ $items->firstItem() ?? 0 }}-{{ $items->lastItem() ?? 0 }} dari {{ $items->total() }} Produk
            </p>
            <div class="flex items-center gap-2">
                @if ($items->onFirstPage())
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $items->appends(request()->query())->previousPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Sebelumnya</a>
                @endif

                @if ($items->hasMorePages())
                    <a href="{{ $items->appends(request()->query())->nextPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Selanjutnya</a>
                @else
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Selanjutnya</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection