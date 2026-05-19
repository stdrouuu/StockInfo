@extends('layouts.app')

@section('title', 'StockInfo - Cocokkan Stok Fisik (Opname)')

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
                <i class="fas fa-archive text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Pencocokan Stok Fisik Toko (Opname)</h2>
                <div class="flex items-center gap-2 text-orange-100 text-[10px] mt-1 font-bold">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase">COCOKKAN STOK (OPNAME)</span>
                </div>
            </div>
        </div>
        <i class="fas fa-box absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6">
        <div class="mb-6 flex items-center justify-between">
            <button @click="showModal = true; modalType = 'add-period'" class="bg-[#2d46b9] hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 shadow-lg shadow-blue-200 transition-all">
                <i class="fas fa-plus text-xs"></i>
                + Mulai Periode Pengecekan Baru
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-[#2d46b9] text-white text-[10px] font-black uppercase tracking-widest">
                        <th class="px-6 py-4 rounded-tl-xl">No</th>
                        <th class="px-6 py-4">Jadwal Pengecekan</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-center">Total Barang Dicek</th>
                        <th class="px-6 py-4 text-center">Stok Sesuai (Aman)</th>
                        <th class="px-6 py-4 text-center">Stok Selisih (Beda)</th>
                        <th class="px-6 py-4 text-center">Status Kerja</th>
                        <th class="px-6 py-4 text-center">Laporan Akhir</th>
                        <th class="px-6 py-4 rounded-tr-xl text-center">Isi / Lihat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($periodes as $index => $row)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 text-sm text-slate-400 font-medium">{{ str_pad($index + 1 + ($periodes->currentPage() - 1) * $periodes->perPage(), 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-5 text-sm font-extrabold text-[#2d46b9] leading-relaxed">
                            {{ $row->tanggal_mulai->format('d M Y') }} s/d {{ $row->tanggal_selesai->format('d M Y') }}
                        </td>
                        <td class="px-6 py-5 text-sm text-slate-600 font-semibold max-w-xs truncate">{{ $row->keterangan }}</td>
                        <td class="px-6 py-5 text-sm font-medium text-slate-500 text-center">{{ $row->total_barang }}</td>
                        <td class="px-6 py-5 text-sm font-black text-emerald-600 text-center">{{ $row->total_sesuai }}</td>
                        <td class="px-6 py-5 text-sm font-bold text-rose-500 text-center">{{ $row->total_selisih }}</td>
                        <td class="px-6 py-5 text-sm font-semibold text-center">
                            @if($row->status_kerja === 'Aktif')
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase rounded">Berjalan</span>
                            @else
                                <span class="px-2.5 py-1 bg-slate-50 text-slate-400 text-[9px] font-black uppercase rounded">Selesai</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-center">
                            @if($row->status_pelaporan === 'LENGKAP' || $row->status_pelaporan === 'SELESAI')
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase rounded-full">SELESAI</span>
                            @else
                                <span class="px-3 py-1 bg-rose-50 text-rose-600 text-[10px] font-black uppercase rounded-full">BELUM LENGKAP</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-4">
                                <a href="{{ route('stok.opname2', ['periode_id' => $row->id]) }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-1 text-xs font-bold" title="Input Hasil Pengecekan">
                                    <i class="fas fa-edit"></i> Isi Stok Fisik
                                </a>
                                <a href="{{ route('stok.opname3', ['periode_id' => $row->id]) }}" class="text-emerald-600 hover:text-emerald-800 flex items-center gap-1 text-xs font-bold" title="Lihat Laporan Kecocokan">
                                    <i class="fas fa-chart-line"></i> Lihat Laporan
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-8 text-center text-slate-400 font-medium">Belum ada jadwal pengecekan stok fisik.</td>
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
    <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Mulai Periode Pengecekan Baru</h2>
    <form action="{{ route('stok.storePeriode') }}" method="POST" class="space-y-5">
        @csrf
        <div class="grid grid-cols-2 gap-5">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Tanggal Mulai Pengecekan</label>
                <input type="date" name="tanggal_mulai" required value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Tanggal Selesai Pengecekan</label>
                <input type="date" name="tanggal_selesai" required value="{{ date('Y-m-d', strtotime('+30 days')) }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
        </div>
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Keterangan Pengecekan</label>
            <textarea name="keterangan" required placeholder="Contoh: Cocokkan stok semen dan pasir - Mei 2026..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all resize-none" rows="2"></textarea>
        </div>
        <div class="flex justify-end gap-3 pt-4">
            <button type="button" @click="showModal = false" class="px-8 py-2.5 bg-slate-100 text-slate-800 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">Batal</button>
            <button type="submit" class="px-8 py-2.5 bg-[#2d46b9] text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-200 hover:bg-blue-800 transition-all">Mulai Pengecekan</button>
        </div>
    </form>
</div>
@endsection
