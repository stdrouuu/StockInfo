@extends('layouts.app')

@section('title', 'StockInfo - Proses')

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

    <div class="bg-[#7c4335] rounded-3xl p-6 sm:p-8 text-white relative overflow-hidden shadow-xl shadow-orange-900/10">
        <div class="relative z-10 flex items-center gap-4 sm:gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-archive text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Proses</h2>
                <div class="flex items-center gap-2 text-orange-100 text-xs mt-1">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase tracking-wider font-bold text-white">Proses</span>
                </div>
            </div>
        </div>
        <i class="fas fa-file-alt absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex flex-1 items-center gap-3 w-full sm:max-w-2xl">
                <!-- Search Form -->
                <form method="GET" action="{{ route('proses.index') }}" class="flex gap-2 flex-1">
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Surat Jalan, Status..." class="w-full px-5 py-3 bg-[#f1f5f9] border-none rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-slate-400">
                    </div>
                    <button type="submit" class="bg-[#2d46b9] hover:bg-blue-800 text-white px-5 sm:px-6 py-3 rounded-xl text-sm font-bold flex items-center gap-2 transition-all">
                        <i class="fas fa-search"></i>
                        <span>Cari</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-[#2d46b9] text-white text-[10px] font-black uppercase tracking-widest text-left">
                        <th class="px-6 py-4 rounded-tl-2xl">No</th>
                        <th class="px-6 py-4 text-center">Tipe</th>
                        <th class="px-6 py-4 text-center">No. Surat Jalan</th>
                        <th class="px-6 py-4 text-center">Asal / Tujuan</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center rounded-tr-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($proses as $index => $row)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-8 text-sm font-bold text-slate-800">{{ str_pad($index + 1 + ($proses->currentPage() - 1) * $proses->perPage(), 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-8 text-center">
                            @if($row->transaksi)
                                @if(strtolower($row->transaksi->tipe) === 'masuk')
                                    <span class="px-3 py-1.5 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black uppercase tracking-wider inline-flex items-center justify-center gap-1 w-24 border border-emerald-100">
                                        <i class="fas fa-arrow-down text-[8px]"></i> MASUK
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 bg-rose-50 text-rose-600 rounded-full text-[10px] font-black uppercase tracking-wider inline-flex items-center justify-center gap-1 w-24 border border-rose-100">
                                        <i class="fas fa-arrow-up text-[8px]"></i> KELUAR
                                    </span>
                                @endif
                            @else
                                <span class="px-3 py-1.5 bg-slate-50 text-slate-500 rounded-full text-[10px] font-black uppercase tracking-wider inline-flex items-center justify-center w-24 border border-slate-100">
                                    MANUAL
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-8 text-sm text-slate-600 font-black text-center uppercase tracking-tight">{{ $row->no_surat_jalan }}</td>
                        <td class="px-6 py-8 text-sm text-slate-600 font-medium text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-sm font-black text-slate-800">
                                    @if($row->transaksi)
                                        {{ $row->transaksi->tipe === 'masuk' ? ($row->transaksi->supplier->nama ?? '-') : $row->transaksi->tujuan }}
                                    @else
                                        -
                                    @endif
                                </span>
                                @if($row->transaksi)
                                    <span class="text-[10px] text-slate-400 font-bold uppercase mt-1.5 text-center max-w-sm leading-relaxed" title="Nama Barang">
                                        @foreach($row->transaksi->items as $item)
                                            {{ $item->produk->nama ?? 'Tidak Ada' }} ({{ $item->qty }} unit){{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    </span>
                                @else
                                    <span class="text-[10px] text-slate-400 font-bold uppercase mt-1.5">
                                        {{ $row->produk->nama ?? '-' }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-8 text-sm font-semibold text-center">
                            @if($row->status === 'Completed')
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-bold uppercase">{{ $row->status }}</span>
                            @elseif($row->status === 'Pending')
                                <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-bold uppercase">{{ $row->status }}</span>
                            @else
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold uppercase">{{ $row->status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-8">
                            <div class="flex justify-center gap-3">
                                <button @click="showModal = true; modalType = 'detail-proses'; window.dispatchEvent(new CustomEvent('open-detail-modal', { detail: {
                                    id: {{ json_encode($row->id) }},
                                    no_surat_jalan: {{ json_encode($row->no_surat_jalan) }},
                                    tipe: {{ json_encode($row->transaksi ? ($row->transaksi->tipe === 'masuk' ? 'Barang Masuk' : 'Barang Keluar') : 'Manual') }},
                                    asal_tujuan: {{ json_encode($row->transaksi ? ($row->transaksi->tipe === 'masuk' ? ($row->transaksi->supplier->nama ?? '-') : $row->transaksi->tujuan) : '-') }},
                                    alamat: {{ json_encode($row->transaksi ? ($row->transaksi->alamat ?? '-') : '-') }},
                                    status: {{ json_encode($row->status) }},
                                    keterangan: {{ json_encode($row->keterangan) }},
                                    items: {{ json_encode($row->transaksi ? $row->transaksi->items->map(fn($item) => [
                                        'sku' => $item->produk->sku ?? '-',
                                        'nama' => $item->produk->nama ?? 'Tidak Ada',
                                        'qty' => $item->qty,
                                        'kategori' => $item->produk->kategori->nama ?? 'Umum'
                                    ]) : [[
                                        'sku' => $row->produk->sku ?? '-',
                                        'nama' => $row->produk->nama ?? 'Tidak Ada',
                                        'qty' => 1,
                                        'kategori' => $row->kategori_proses
                                    ]]) }},
                                    action: {{ json_encode(route('proses.update', $row->id)) }}
                                } }))" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-blue-600 hover:border-blue-200 hover:scale-105 active:scale-95 transition-all shadow-sm">
                                    <i class="fas fa-eye text-sm"></i>
                                </button>
                                <button @click="showDeleteModal = true; deleteTarget = '{{ $row->no_surat_jalan }}'; deleteAction = '{{ route('proses.destroy', $row->id) }}'" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-red-600 hover:border-red-200 hover:scale-105 active:scale-95 transition-all shadow-sm">
                                    <i class="far fa-trash-alt text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-400 font-medium">Tidak ada proses ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">
                Menampilkan {{ $proses->firstItem() ?? 0 }}-{{ $proses->lastItem() ?? 0 }} dari {{ $proses->total() }} Proses
            </div>
            <div class="flex items-center gap-2">
                @if ($proses->onFirstPage())
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $proses->appends(request()->query())->previousPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Sebelumnya</a>
                @endif

                @if ($proses->hasMorePages())
                    <a href="{{ $proses->appends(request()->query())->nextPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Selanjutnya</a>
                @else
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Selanjutnya</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal-content')
<!-- Detail & Edit Status Modal -->
<div x-show="modalType === 'detail-proses'"
     x-data="{ 
        id: '',
        no_surat_jalan: '',
        tipe: '',
        asal_tujuan: '',
        alamat: '',
        status: 'On-Going',
        keterangan: '',
        items: [],
        action: ''
     }"
     @open-detail-modal.window="
        id = $event.detail.id || '';
        no_surat_jalan = $event.detail.no_surat_jalan || '';
        tipe = $event.detail.tipe || '';
        asal_tujuan = $event.detail.asal_tujuan || '';
        alamat = $event.detail.alamat || '';
        status = $event.detail.status || 'On-Going';
        keterangan = $event.detail.keterangan || '';
        items = $event.detail.items || [];
        action = $event.detail.action || '';
     }">
    
    <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-100">
        <div>
            <h2 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Rincian Surat Jalan</h2>
            <h3 class="text-xl font-extrabold text-slate-800" x-text="no_surat_jalan"></h3>
        </div>
        <div class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider border"
             :class="tipe === 'Barang Masuk' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : (tipe === 'Barang Keluar' ? 'bg-rose-50 text-rose-600 border-rose-100' : 'bg-slate-50 text-slate-500 border-slate-100')"
             x-text="tipe">
        </div>
    </div>

    <!-- Metadata Details -->
    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 mb-6">
        <div class="space-y-4">
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Asal / Tujuan Pengiriman</p>
                <p class="text-sm font-bold text-slate-800 mt-1" x-text="asal_tujuan"></p>
            </div>
            <div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Alamat Pengiriman</p>
                <p class="text-xs text-slate-600 font-bold mt-1" x-text="alamat"></p>
            </div>
        </div>
        <div>
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Keterangan / Catatan</p>
            <p class="text-sm text-slate-600 font-semibold mt-1" x-text="keterangan || '-'"></p>
        </div>
    </div>

    <!-- Items Listing Table -->
    <div class="space-y-3 mb-8">
        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Daftar Barang Bawaan</h4>
        <div class="border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-[9px] font-black uppercase tracking-wider border-b border-slate-100">
                        <th class="px-4 py-3 text-center w-12">No</th>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Nama Produk</th>
                        <th class="px-4 py-3 text-center">Kategori</th>
                        <th class="px-4 py-3 text-center w-24">Jumlah Qty</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-xs">
                    <template x-for="(item, idx) in items" :key="idx">
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-4 py-3.5 text-center font-bold text-slate-400" x-text="idx + 1"></td>
                            <td class="px-4 py-3.5 font-mono text-slate-600 font-bold" x-text="item.sku"></td>
                            <td class="px-4 py-3.5 font-extrabold text-slate-800" x-text="item.nama"></td>
                            <td class="px-4 py-3.5 text-center font-semibold text-slate-500" x-text="item.kategori"></td>
                            <td class="px-4 py-3.5 text-center font-black text-[#064e3b]" x-text="item.qty"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Status Form Update -->
    <form :action="action" method="POST" class="space-y-6 pt-4 border-t border-slate-100">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider block">Perbarui Status Logistik</label>
            <div class="relative max-w-xs">
                <select name="status" x-model="status" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="On-Going">On-Going</option>
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                </select>
                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <button type="button" @click="showModal = false" class="px-8 py-3 bg-slate-100 text-slate-800 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">Batal / Tutup</button>
            <button type="submit" class="px-8 py-3 bg-[#2d46b9] text-white rounded-xl text-sm font-black shadow-lg shadow-blue-200 hover:bg-blue-800 transition-all">Simpan Status</button>
        </div>
    </form>
</div>
@endsection
