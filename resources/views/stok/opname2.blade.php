@extends('layouts.app')

@section('title', 'StockInfo - Form Input Stok Opname')

@section('content')
<div class="space-y-8">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-semibold border border-emerald-200">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 rounded-xl bg-rose-50 text-rose-700 text-sm font-semibold border border-rose-200">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-[#d35400] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-orange-900/10">
        <div class="relative z-10 flex items-center justify-between gap-6">
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
            <div class="bg-white/10 px-5 py-3 rounded-2xl backdrop-blur-md text-right">
                <span class="text-xs text-orange-100 font-bold block">Periode Aktif</span>
                <span class="text-sm font-black">{{ $periode->tanggal_mulai->format('d M Y') }} - {{ $periode->tanggal_selesai->format('d M Y') }}</span>
            </div>
        </div>
        <i class="fas fa-clipboard-check absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden p-6">
        @if($periode->is_adjusted)
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-between gap-4">
                <div class="flex items-center gap-3 text-emerald-800">
                    <div class="p-2 bg-emerald-500 text-white rounded-xl">
                        <i class="fas fa-check-circle text-lg"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm">Stok Telah Sinkron</p>
                        <p class="text-xs text-emerald-600 font-medium">Stok sistem telah diperbarui berdasarkan stok fisik periode opname ini.</p>
                    </div>
                </div>
            </div>
        @else
            <div class="mb-6 p-4 bg-blue-50 border border-blue-100 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3 text-blue-800">
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
        <table class="w-full text-left">
            <thead>
                <tr class="bg-[#1e40af] text-white text-[10px] font-black uppercase tracking-widest">
                    <th class="px-6 py-4 rounded-tl-2xl">No</th>
                    <th class="px-6 py-4">Nomor SKU</th>
                    <th class="px-6 py-4">Produk</th>
                    <th class="px-6 py-4 text-center">Stok Sistem</th>
                    <th class="px-6 py-4 text-center">Stok Fisik Terlapor</th>
                    <th class="px-6 py-4 text-center">Selisih</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Keterangan</th>
                    <th class="px-6 py-4 rounded-tr-2xl text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($items as $index => $item)
                <tr class="hover:bg-slate-50/50">
                    <td class="px-6 py-6 text-sm text-slate-400 font-medium">{{ str_pad($index + 1 + ($items->currentPage() - 1) * $items->perPage(), 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-6 text-sm font-bold text-blue-700">{{ $item->produk->sku }}</td>
                    <td class="px-6 py-6 text-sm font-semibold text-slate-600">{{ $item->produk->nama }}</td>
                    <td class="px-6 py-6 text-sm font-black text-slate-800 text-center">{{ $item->stok_sistem }}</td>
                    <td class="px-6 py-6 text-sm font-medium text-slate-500 text-center">{{ $item->stok_fisik }}</td>
                    <td class="px-6 py-6 text-sm font-black text-center {{ $item->selisih < 0 ? 'text-rose-500' : ($item->selisih > 0 ? 'text-emerald-500' : 'text-slate-600') }}">
                        {{ $item->selisih > 0 ? '+' : '' }}{{ $item->selisih }}
                    </td>
                    <td class="px-6 py-6 text-center">
                        @if($item->catatan === 'belum dilaporkan')
                            <span class="px-3 py-1 bg-amber-50 text-amber-600 text-[10px] font-black rounded-full uppercase">BELUM</span>
                        @elseif($item->selisih === 0)
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-full uppercase">SESUAI</span>
                        @else
                            <span class="px-3 py-1 bg-rose-50 text-rose-600 text-[10px] font-black rounded-full uppercase font-black">SELISIH</span>
                        @endif
                    </td>
                    <td class="px-6 py-6 text-sm text-slate-400 text-center italic">{{ $item->catatan }}</td>
                    <td class="px-6 py-6 text-center">
                        <button @click="$dispatch('open-report-modal', {
                            nama: '{{ $item->produk->nama }}',
                            sku: '{{ $item->produk->sku }}',
                            stok_sistem: '{{ $item->stok_sistem }}',
                            stok_fisik: '{{ $item->stok_fisik }}',
                            catatan: '{{ $item->catatan === 'belum dilaporkan' ? '' : $item->catatan }}',
                            action: '{{ route('stok.reportItem', $item->id) }}'
                        })" class="bg-[#1e40af] text-white text-[10px] font-black px-4 py-1.5 rounded-lg uppercase shadow-lg shadow-blue-100 hover:bg-blue-800 transition-colors">Laporkan</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-8 text-center text-slate-400 font-medium">Tidak ada barang dalam periode stok opname ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

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

@section('modal-content')
<div x-show="modalType === 'report-opname'"
     x-data="{
        nama: '',
        sku: '',
        stok_sistem: 0,
        stok_fisik: 0,
        catatan: '',
        action: ''
     }"
     @open-report-modal.window="
        showModal = true;
        modalType = 'report-opname';
        nama = $event.detail.nama;
        sku = $event.detail.sku;
        stok_sistem = $event.detail.stok_sistem;
        stok_fisik = $event.detail.stok_fisik;
        catatan = $event.detail.catatan || '';
        action = $event.detail.action;
     ">
    <h2 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.25em] mb-8">Input Stok Opname</h2>
    <form :action="action" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Nama Produk</label>
                <input type="text" x-model="nama" disabled class="w-full px-5 py-3.5 bg-slate-100 border border-slate-200 rounded-xl text-sm text-slate-500 font-medium outline-none">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">No. SKU</label>
                <input type="text" x-model="sku" disabled class="w-full px-5 py-3.5 bg-slate-100 border border-slate-200 rounded-xl text-sm text-slate-500 font-medium outline-none">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Jumlah Stok Sistem</label>
                <input type="number" x-model="stok_sistem" disabled class="w-full px-5 py-3.5 bg-slate-100 border border-slate-200 rounded-xl text-sm text-slate-500 font-medium outline-none">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Jumlah Dilaporkan (Fisik)</label>
                <input type="number" name="stok_fisik" x-model="stok_fisik" required min="0" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all">
            </div>
        </div>
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Keterangan / Catatan</label>
            <textarea name="catatan" x-model="catatan" rows="4" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all resize-none" placeholder="Tuliskan keterangan jika ada selisih stok..."></textarea>
        </div>
        <div class="flex items-center justify-end gap-3 pt-4">
            <button type="button" @click="showModal = false" class="px-10 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-800 text-sm font-bold rounded-xl transition-colors">Batal</button>
            <button type="submit" class="px-10 py-3.5 bg-[#2d46b9] hover:bg-blue-800 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-200 transition-all">Simpan</button>
        </div>
    </form>
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
