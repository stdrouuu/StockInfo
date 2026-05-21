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
        <i class="fas fa-box absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden p-6">
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
