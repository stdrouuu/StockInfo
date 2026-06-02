@extends('layouts.app')

@section('title', 'StockInfo - Stok Opname')

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
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-clipboard-check text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Stok Opname</h2>
                <div class="flex items-center gap-2 text-orange-100 text-[10px] mt-1 font-bold">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase">STOK OPNAME</span>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="text-white uppercase font-black tracking-widest">DATA</span>
                </div>
            </div>
        </div>
        <i class="fas fa-clipboard-check absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6">
        <div class="mb-6 flex items-center justify-between">
            <button @click="showModal = true; modalType = 'add-period'" class="bg-[#2d46b9] hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 shadow-lg shadow-blue-200 transition-all">
                <i class="fas fa-plus text-xs"></i>
                Buat Periode
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-[#2d46b9] text-white text-[10px] font-black uppercase tracking-widest">
                        <th class="px-6 py-4 rounded-tl-xl text-center whitespace-nowrap">No</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Periode</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Keterangan</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Jumlah Barang</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Jumlah Sesuai</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Jumlah Selisih</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Status Kerja</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Status Pelaporan</th>
                        <th class="px-6 py-4 rounded-tr-xl text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($periodes as $index => $row)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 text-sm text-slate-400 font-medium">{{ str_pad($index + 1 + ($periodes->currentPage() - 1) * $periodes->perPage(), 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-5 text-sm font-extrabold text-[#2d46b9] leading-relaxed">
                            {{ $row->tanggal_mulai->format('d M Y') }} s/d {{ $row->tanggal_selesai->format('d M Y') }}
                        </td>
                        <td class="px-6 py-5 text-sm text-slate-600 font-semibold max-w-xs">
                            <div class="truncate mb-1.5">{{ $row->keterangan }}</div>
                            @if($row->status_pelaporan === 'selesai' || $row->status_pelaporan === 'lengkap')
                                @if($row->is_adjusted)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase rounded border border-emerald-100" title="Stok Telah Sinkron">
                                        <i class="fas fa-check-circle"></i> Sinkron
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-50 text-blue-600 text-[9px] font-black uppercase rounded border border-blue-100" title="Siap Sinkron - Buka Form Input untuk Menyesuaikan">
                                        <i class="fas fa-exclamation-circle text-blue-500"></i> Siap Sinkron
                                    </span>
                                @endif
                            @endif
                        </td>
                        <td class="px-6 py-5 text-sm font-medium text-slate-500 text-center">{{ $row->total_barang }}</td>
                        <td class="px-6 py-5 text-sm font-medium text-slate-500 text-center">{{ $row->total_sesuai }}</td>
                        <td class="px-6 py-5 text-sm font-medium text-slate-500 text-center">{{ $row->total_selisih }}</td>
                        <td class="px-6 py-5 text-sm font-semibold text-center">
                            @if($row->status_kerja === 'aktif')
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase rounded">{{ $row->status_kerja }}</span>
                            @else
                                <span class="px-2.5 py-1 bg-slate-50 text-slate-400 text-[9px] font-black uppercase rounded">{{ $row->status_kerja }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($row->status_pelaporan === 'lengkap' || $row->status_pelaporan === 'selesai')
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase rounded-full">{{ str_replace('_', ' ', $row->status_pelaporan) }}</span>
                            @else
                                <span class="px-3 py-1 bg-rose-50 text-rose-600 text-[10px] font-black uppercase rounded-full">{{ str_replace('_', ' ', $row->status_pelaporan) }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('stok.opname2', ['periode_id' => $row->id]) }}" class="p-2 text-slate-400 hover:text-blue-600 transition-colors" title="Input Stok Fisik">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <a href="{{ route('stok.opname3', ['periode_id' => $row->id]) }}" class="p-2 text-slate-400 hover:text-emerald-600 transition-colors" title="Lihat Laporan">
                                    <i class="fas fa-chart-line text-sm"></i>
                                </a>
                                 <button type="button" @click="$dispatch('open-edit-modal', { action: '{{ route('stok.updatePeriode', $row->id) }}', keterangan: '{{ addslashes($row->keterangan) }}' })" class="p-2 text-slate-400 hover:text-blue-600 transition-colors" title="Edit Keterangan">
                                     <i class="fas fa-pen text-xs"></i>
                                 </button>
                                <button type="button" @click="showDeleteModal = true; deleteTarget = 'Periode Opname {{ $row->tanggal_mulai->format('d M Y') }} s/d {{ $row->tanggal_selesai->format('d M Y') }}'; deleteAction = '{{ route('stok.destroyPeriode', $row->id) }}'" class="p-2 text-slate-400 hover:text-rose-600 transition-colors" title="Hapus Periode">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center text-slate-400 font-medium">Belum ada periode stok opname.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex items-center justify-between">
            <p class="text-xs text-slate-400 font-medium tracking-tight">
                Menampilkan {{ $periodes->firstItem() ?? 0 }}-{{ $periodes->lastItem() ?? 0 }} dari {{ $periodes->total() }} Periode
            </p>
            <div class="flex items-center gap-2">
                @if ($periodes->onFirstPage())
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $periodes->previousPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Sebelumnya</a>
                @endif

                @if ($periodes->hasMorePages())
                    <a href="{{ $periodes->nextPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Selanjutnya</a>
                @else
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Selanjutnya</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal-content')
<div x-show="modalType === 'add-period'">
    <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Buat Periode Opname</h2>
    <form action="{{ route('stok.storePeriode') }}" method="POST" class="space-y-5">
        @csrf
        <div class="grid grid-cols-2 gap-5">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" required value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" required value="{{ date('Y-m-d', strtotime('+30 days')) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
        </div>
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Keterangan Periode</label>
            <textarea name="keterangan" required placeholder="Contoh: Stok Opname Gudang A - Akhir Tahun" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all resize-none" rows="2"></textarea>
        </div>
        <div class="flex justify-end gap-3 pt-4">
            <button type="button" @click="showModal = false" class="px-8 py-2.5 bg-slate-100 text-slate-800 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">Batal</button>
            <button type="submit" class="px-8 py-2.5 bg-[#2d46b9] text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-200 hover:bg-blue-800 transition-all">Buat</button>
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

<!-- Local Edit Period Modal -->
<div x-data="{ show: false, action: '', keterangan: '' }"
     x-show="show" 
     @open-edit-modal.window="show = true; action = $event.detail.action; keterangan = $event.detail.keterangan"
     x-cloak
     class="fixed inset-0 bg-black/40 backdrop-blur-[2px] z-[70] flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div @click.away="show = false" 
         class="bg-white w-full max-w-md rounded-[32px] shadow-2xl overflow-hidden p-8 text-left"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">
        <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Edit Keterangan Periode</h2>
        <form :action="action" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Keterangan Periode</label>
                <textarea name="keterangan" required x-model="keterangan" placeholder="Contoh: Stok Opname Gudang A - Akhir Tahun" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all resize-none" rows="3"></textarea>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <button type="button" @click="show = false" class="px-8 py-2.5 bg-slate-100 text-slate-800 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">Batal</button>
                <button type="submit" class="px-8 py-2.5 bg-[#2d46b9] text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-200 hover:bg-blue-800 transition-all">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endpush