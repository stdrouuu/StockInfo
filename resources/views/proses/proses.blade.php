@extends('layouts.app')

@section('title', 'StockInfo - Proses')

@section('content')
<div class="space-y-5 sm:space-y-8">
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

    <div class="bg-[#7c4335] rounded-2xl sm:rounded-3xl p-4 sm:p-8 text-white relative overflow-hidden shadow-xl shadow-orange-900/10">
        <div class="relative z-10 flex items-center gap-3 sm:gap-6">
            <div class="bg-white/20 p-3 sm:p-4 rounded-xl sm:rounded-2xl backdrop-blur-md">
                <i class="fas fa-truck text-2xl sm:text-3xl"></i>
            </div>
            <div>
                <h2 class="text-lg sm:text-2xl font-bold">Proses</h2>
                <div class="flex items-center gap-2 text-orange-100 text-[10px] sm:text-xs mt-1">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase tracking-wider font-bold text-white">Proses</span>
                </div>
            </div>
        </div>
        <i class="fas fa-truck absolute -right-8 -bottom-10 text-[120px] sm:text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-4 sm:p-6 space-y-4 sm:space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex flex-1 items-center gap-3 w-full sm:max-w-2xl">
                <!-- Search Form -->
                <form method="GET" action="{{ route('proses.index') }}" class="flex gap-2 flex-1">
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Surat Jalan, Status..." class="w-full px-4 py-2 sm:px-5 sm:py-3 bg-[#f1f5f9] border-none rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-slate-400">
                    </div>
                    <button type="submit" class="bg-[#2d46b9] hover:bg-blue-800 text-white px-3 sm:px-6 py-2 sm:py-3 rounded-xl text-xs sm:text-sm font-bold flex items-center gap-2 transition-all flex-shrink-0">
                        <i class="fas fa-search"></i>
                        <span>Cari</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-[#2d46b9] text-white text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-left">
                        <th class="px-3 py-2 sm:px-6 sm:py-4 rounded-tl-2xl">No</th>
                        <th class="px-3 py-2 sm:px-6 sm:py-4 text-center">Tipe</th>
                        <th class="px-3 py-2 sm:px-6 sm:py-4 text-center">No. Surat Jalan</th>
                        <th class="px-3 py-2 sm:px-6 sm:py-4 text-center">Asal / Tujuan</th>
                        <th class="px-3 py-2 sm:px-6 sm:py-4 text-center">Status</th>
                        <th class="px-3 py-2 sm:px-6 sm:py-4 text-center rounded-tr-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($proses as $index => $row)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-3 py-3 sm:px-6 sm:py-8 text-xs sm:text-sm font-bold text-slate-800">{{ str_pad($index + 1 + ($proses->currentPage() - 1) * $proses->perPage(), 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-3 py-3 sm:px-6 sm:py-8 text-center">
                            @if($row->transaksi)
                                @if(strtolower($row->transaksi->tipe) === 'masuk')
                                    <span class="px-2 sm:px-3 py-1 sm:py-1.5 bg-emerald-50 text-emerald-600 rounded-full text-[8px] sm:text-[10px] font-black uppercase tracking-wider inline-flex items-center justify-center gap-1 w-20 sm:w-24 border border-emerald-100">
                                        <i class="fas fa-arrow-down text-[8px]"></i> MASUK
                                    </span>
                                @else
                                    <span class="px-2 sm:px-3 py-1 sm:py-1.5 bg-rose-50 text-rose-600 rounded-full text-[8px] sm:text-[10px] font-black uppercase tracking-wider inline-flex items-center justify-center gap-1 w-20 sm:w-24 border border-rose-100">
                                        <i class="fas fa-arrow-up text-[8px]"></i> KELUAR
                                    </span>
                                @endif
                            @else
                                <span class="px-2 sm:px-3 py-1 sm:py-1.5 bg-slate-50 text-slate-500 rounded-full text-[8px] sm:text-[10px] font-black uppercase tracking-wider inline-flex items-center justify-center w-20 sm:w-24 border border-slate-100">
                                    MANUAL
                                </span>
                            @endif
                        </td>
                        <td class="px-3 py-3 sm:px-6 sm:py-8 text-xs sm:text-sm text-slate-600 font-black text-center uppercase tracking-tight">{{ $row->no_surat_jalan }}</td>
                        <td class="px-3 py-3 sm:px-6 sm:py-8 text-xs sm:text-sm text-slate-600 font-medium text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-xs sm:text-sm font-black text-slate-800">
                                    @if($row->transaksi)
                                        {{ $row->transaksi->tipe === 'masuk' ? ($row->transaksi->supplier->nama ?? '-') : $row->transaksi->tujuan }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                        </td>
                        <td class="px-3 py-3 sm:px-6 sm:py-8 text-xs sm:text-sm font-semibold text-center">
                            @if(strtolower($row->status) === 'completed')
                                <span class="px-2 sm:px-3 py-0.5 sm:py-1 bg-emerald-50 text-emerald-600 rounded-full text-[8px] sm:text-[10px] font-bold uppercase">Selesai</span>
                            @elseif(strtolower($row->status) === 'pending')
                                <span class="px-2 sm:px-3 py-0.5 sm:py-1 bg-amber-50 text-amber-600 rounded-full text-[8px] sm:text-[10px] font-bold uppercase">Tertunda</span>
                            @else
                                <span class="px-2 sm:px-3 py-0.5 sm:py-1 bg-blue-50 text-blue-600 rounded-full text-[8px] sm:text-[10px] font-bold uppercase">Dalam Perjalanan</span>
                            @endif
                        </td>
                        <td class="px-3 py-3 sm:px-6 sm:py-8">
                            <div class="flex justify-center gap-1 sm:gap-2">
                                <button @click="$store.prosesDetail.setData({
                                    no_surat_jalan: {{ json_encode($row->no_surat_jalan) }},
                                    status: {{ json_encode($row->status) }},
                                    items: {{ json_encode($row->transaksi && $row->transaksi->items ? $row->transaksi->items->map(fn($item) => [
                                        'nama' => $item->produk->nama ?? 'Tidak Ada',
                                        'qty' => $item->qty
                                    ])->toArray() : ($row->produk ? [[
                                        'nama' => $row->produk->nama ?? 'Tidak Ada',
                                        'qty' => 1
                                    ]] : [])) }},
                                    action: {{ json_encode(route('proses.update', $row->id)) }}
                                }); showModal = true; modalType = 'detail-proses';" class="p-1 sm:p-2 text-slate-400 hover:text-blue-600 transition-colors" title="Detail Proses">
                                    <i class="fas fa-eye text-xs sm:text-sm"></i>
                                </button>
                                @if(auth()->user()->isAdmin())
                                <button @click="showDeleteModal = true; deleteTarget = '{{ $row->no_surat_jalan }}'; deleteAction = '{{ route('proses.destroy', $row->id) }}'" class="p-1 sm:p-2 text-slate-400 hover:text-rose-600 transition-colors" title="Hapus Proses">
                                    <i class="far fa-trash-alt text-xs sm:text-sm"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-3 py-6 sm:px-6 sm:py-8 text-center text-slate-400 font-medium text-xs sm:text-sm">Tidak ada proses ditemukan.</td>
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
<div x-show="modalType === 'detail-proses'">
    
    <!-- Modal Header -->
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
        <div>
            <h2 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Status & Barang Bawaan</h2>
            <h3 class="text-xl font-extrabold text-slate-800" x-text="$store.prosesDetail.no_surat_jalan"></h3>
        </div>
        <button type="button" @click="showModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>

    <!-- Items Listing -->
    <div class="space-y-3 mb-6">
        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Daftar Barang Bawaan Supir</h4>
        <div class="border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-[9px] font-black uppercase tracking-wider border-b border-slate-100">
                        <th class="px-4 py-3 text-center w-12">No</th>
                        <th class="px-4 py-3">Nama Produk</th>
                        <th class="px-4 py-3 text-center w-24">Jumlah Qty</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-xs">
                    <template x-for="(item, idx) in $store.prosesDetail.items" :key="idx">
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-4 py-3.5 text-center font-bold text-slate-400" x-text="idx + 1"></td>
                            <td class="px-4 py-3.5 font-extrabold text-slate-800" x-text="item.nama"></td>
                            <td class="px-4 py-3.5 text-center font-black text-emerald-600" x-text="item.qty"></td>
                        </tr>
                    </template>
                    <template x-if="$store.prosesDetail.items.length === 0">
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-center text-slate-400">Tidak ada barang bawaan.</td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Status Form Update / View -->
    @if(auth()->user()->isAdmin())
    <form :action="$store.prosesDetail.action" method="POST" class="space-y-6 pt-4 border-t border-slate-100">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider block">Status Pengiriman</label>
            <div class="relative max-w-xs">
                <select name="status" x-model="$store.prosesDetail.status" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="On-Going">Dalam Perjalanan</option>
                    <option value="Pending">Tertunda</option>
                    <option value="Completed">Selesai</option>
                </select>
                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <button type="button" @click="showModal = false" class="px-6 py-2.5 bg-slate-100 text-slate-800 rounded-xl text-xs font-bold hover:bg-slate-200 transition-all">Batal / Tutup</button>
            <button type="submit" class="px-6 py-2.5 bg-[#2d46b9] text-white rounded-xl text-xs font-black shadow-lg shadow-blue-200 hover:bg-blue-800 transition-all">Simpan Status</button>
        </div>
    </form>
    @else
    <div class="space-y-6 pt-4 border-t border-slate-100 text-left">
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider block">Status Pengiriman</label>
            <span class="inline-flex px-3.5 py-1.5 bg-blue-50 text-blue-600 rounded-full text-xs font-extrabold uppercase tracking-wide" x-text="$store.prosesDetail.status"></span>
        </div>
        <div class="flex justify-end pt-4">
            <button type="button" @click="showModal = false" class="px-6 py-2.5 bg-slate-100 text-slate-800 rounded-xl text-xs font-bold hover:bg-slate-200 transition-all">Tutup</button>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('prosesDetail', {
            no_surat_jalan: '',
            status: 'On-Going',
            items: [],
            action: '',
            setData(data) {
                this.no_surat_jalan = data.no_surat_jalan || '';
                
                let statusVal = data.status || 'On-Going';
                if (statusVal.toLowerCase() === 'completed') {
                    this.status = 'Completed';
                } else if (statusVal.toLowerCase() === 'pending') {
                    this.status = 'Pending';
                } else {
                    this.status = 'On-Going';
                }
                
                this.items = data.items || [];
                this.action = data.action || '';
            }
        });
    });
</script>
@endpush
