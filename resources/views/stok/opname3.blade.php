@extends('layouts.app')

@section('title', 'StockInfo - Laporan Stok Opname')

@section('content')
<div class="space-y-8">
    <div class="bg-[#d35400] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-orange-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-clipboard-check text-3xl"></i>
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
        <i class="fas fa-clipboard-check absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 mb-8">
        <div class="grid grid-cols-12 gap-8 items-center">
            <div class="col-span-7 space-y-6">
                <div class="space-y-2.5">
                    <p class="text-xl font-bold text-slate-800">Periode : {{ $periode->tanggal_mulai->locale('id')->isoFormat('DD MMM YYYY') }} s/d {{ $periode->tanggal_selesai->locale('id')->isoFormat('DD MMM YYYY') }}</p>
                    <div class="space-y-1.5 text-slate-600 font-semibold">
                        <p>Jumlah Barang : {{ $totalItems }}</p>
                        <p>Jumlah Barang Sesuai : {{ $totalSesuai }}</p>
                        <p>Jumlah Barang Selisih : {{ $totalSelisih }}</p>
                        <p>Status Kerja : {{ str_replace('_', ' ', $periode->status_kerja) }}</p>
                        <p>Pelaporan Stok : {{ str_replace('_', ' ', $periode->status_pelaporan) }}</p>
                    </div>
                </div>

                @if($periode->status_pelaporan === 'selesai' || $periode->status_pelaporan === 'lengkap')
                    @if($periode->is_adjusted)
                        <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 text-emerald-800">
                            <div class="p-2 bg-emerald-500 text-white rounded-xl">
                                <i class="fas fa-check-circle text-lg"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm">Stok Telah Sinkron</p>
                                <p class="text-xs text-emerald-600 font-medium">Stok sistem telah diperbarui berdasarkan stok fisik periode opname ini.</p>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-blue-50 border border-blue-100 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-blue-800">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-[#2d46b9] text-white rounded-xl">
                                    <i class="fas fa-exclamation-triangle text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-sm">Sinkronisasi Stok Belum Dilakukan</p>
                                    <p class="text-xs text-blue-600 font-medium">Jika pelaporan stok opname sudah selesai, silahkan sinkronkan stok opname dengan data produk utama.</p>
                                </div>
                            </div>
                            <button type="button" @click="$dispatch('open-sync-modal', { action: '{{ route('stok.adjustStock', $periode->id) }}', message: 'Apakah Anda yakin ingin menyinkronkan stok untuk periode ini? Tindakan ini akan memperbarui stok produk utama dan mencatat selisihnya sebagai kerugian/penyesuaian operasional.' })" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-[#2d46b9] hover:bg-blue-800 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-500/10 hover:shadow-lg transition-all shrink-0">
                                <i class="fas fa-sync-alt"></i> Terapkan & Sinkronkan Stok
                            </button>
                        </div>
                    @endif
                @endif
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

@push('modals')
<!-- Local Sync Confirmation Modal -->
<div x-data="{ show: false, action: '', message: '' }"
     x-show="show" 
     @open-sync-modal.window="show = true; action = $event.detail.action; message = $event.detail.message"
     x-cloak
     class="fixed inset-0 bg-black/40 backdrop-blur-[2px] z-[70] flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div @click.away="show = false" 
         class="bg-white w-full max-w-md rounded-[32px] shadow-2xl overflow-hidden p-8 text-center"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6 border border-blue-100">
            <i class="fas fa-sync-alt text-[#2d46b9] text-3xl"></i>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Sinkronkan Stok?</h3>
        <p class="text-slate-500 text-sm mb-8" x-text="message"></p>
        <div class="flex gap-3">
            <button type="button" @click="show = false" class="flex-1 py-3 bg-slate-100 text-slate-800 rounded-xl font-bold hover:bg-slate-200 transition-all">Batal</button>
            <form :action="action" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full py-3 bg-[#2d46b9] text-white rounded-xl font-bold hover:bg-blue-800 shadow-lg shadow-blue-100 transition-all">Sinkronkan</button>
            </form>
        </div>
    </div>
</div>
@endpush