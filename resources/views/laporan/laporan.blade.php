@extends('layouts.app')

@section('title', 'StockInfo - Laporan')

@section('content')
<div class="space-y-8">
    <!-- Header Banner (Branded Red) -->
    <div class="bg-[#d32f2f] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-red-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-archive text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Laporan</h2>
                <div class="flex items-center gap-2 text-red-100 text-xs mt-1">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase tracking-wider font-bold text-white">Laporan</span>
                </div>
            </div>
        </div>
        <i class="fas fa-file-alt absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <!-- Reports Hub Grid (3 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- 1. Data Produk (Blue Color Accent, Excel Only) -->
        <div class="bg-white rounded-[32px] border border-slate-200/60 shadow-sm p-6 flex flex-col justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <div>
                <div class="flex items-center gap-4 border-b border-slate-100 pb-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-inner">
                        <i class="fas fa-box"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-base">Data Produk</h3>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-4 leading-relaxed font-medium">
                    Ekspor seluruh daftar data katalog produk terdaftar beserta detail stok fisik dan harga satuan saat ini langsung ke dalam berkas spreadsheet.
                </p>

                <!-- Column Info (Simple & Clean) -->
                <p class="text-[11px] text-slate-400 font-semibold mt-4 flex items-center gap-1.5 bg-slate-50 border border-slate-100/75 rounded-2xl p-4 my-6">
                    <i class="fas fa-info-circle text-blue-500"></i>
                    <span>Mencakup kolom: SKU, Nama, Kategori, Stok, Harga, & Total Aset.</span>
                </p>

            </div>

            <!-- Export Action (Excel Only) -->
            <form method="GET" class="w-full">
                <button type="submit" formaction="{{ route('laporan.produk.excel') }}" class="w-full py-3.5 bg-white border border-slate-200/80 hover:bg-slate-50 text-slate-700 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 hover:shadow-sm transition-all duration-200">
                    <i class="fas fa-file-excel text-emerald-600 text-sm"></i>
                    <span>Ekspor Excel</span>
                </button>
            </form>
        </div>

        <!-- 2. Transaksi Masuk & Keluar (Green Color Accent, PDF & Excel) -->
        <div class="bg-white rounded-[32px] border border-slate-200/60 shadow-sm p-6 flex flex-col justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <form method="GET" class="flex flex-col h-full justify-between">
                <div>
                    <div class="flex items-center gap-4 border-b border-slate-100 pb-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shadow-inner">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-slate-800 text-base">Transaksi Masuk & Keluar</h3>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 mt-4 leading-relaxed font-medium">
                        Ekspor log mutasi barang masuk (Inbound) dan barang keluar (Outbound) gudang lengkap dengan detail supplier, tujuan, qty, dan nilai nominal mutasi.
                    </p>

                    <!-- Filters Box -->
                    <div class="bg-slate-50 border border-slate-100/70 rounded-2xl p-4 my-6 space-y-4">
                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Tipe Transaksi</label>
                            <select name="tipe" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                                <option value="all">Semua Tipe</option>
                                <option value="masuk">Barang Masuk (Inbound)</option>
                                <option value="keluar">Barang Keluar (Outbound)</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="w-full bg-white border border-slate-200 rounded-xl px-2 py-1.5 text-[10px] font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="w-full bg-white border border-slate-200 rounded-xl px-2 py-1.5 text-[10px] font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Export Actions -->
                <div class="flex gap-3">
                    <button type="submit" formaction="{{ route('laporan.transaksi.pdf') }}" target="_blank" class="flex-1 py-3 bg-white border border-slate-200/80 hover:bg-slate-50 text-slate-700 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 hover:shadow-sm transition-all duration-200">
                        <i class="fas fa-file-pdf text-red-500 text-sm"></i>
                        <span>Ekspor PDF</span>
                    </button>
                    <button type="submit" formaction="{{ route('laporan.transaksi.excel') }}" class="flex-1 py-3 bg-white border border-slate-200/80 hover:bg-slate-50 text-slate-700 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 hover:shadow-sm transition-all duration-200">
                        <i class="fas fa-file-excel text-emerald-600 text-sm"></i>
                        <span>Ekspor Excel</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- 3. Laporan Stok Opname (Orange Color Accent, PDF & Excel) -->
        <div class="bg-white rounded-[32px] border border-slate-200/60 shadow-sm p-6 flex flex-col justify-between hover:-translate-y-1 hover:shadow-md transition-all duration-300">
            <form method="GET" class="flex flex-col h-full justify-between">
                <div>
                    <div class="flex items-center gap-4 border-b border-slate-100 pb-4">
                        <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center text-xl shadow-inner">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-slate-800 text-base">Laporan Stok Opname</h3>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 mt-4 leading-relaxed font-medium">
                        Ekspor laporan audit fisik penyesuaian persediaan barang gudang. Menampilkan data perbandingan stok aktual lapangan dengan catatan sistem.
                    </p>

                    <!-- Filters Box -->
                    <div class="bg-slate-50 border border-slate-100/70 rounded-2xl p-4 my-6 space-y-4">
                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Periode Audit Stok Opname</label>
                            <select name="periode_id" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-orange-100">
                                @forelse($periodes as $per)
                                    <option value="{{ $per->id }}">{{ $per->keterangan }} ({{ $per->tanggal_mulai->format('d/m') }} - {{ $per->tanggal_selesai->format('d/m') }})</option>
                                @empty
                                    <option value="" disabled>Belum ada periode dibuat</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Export Actions -->
                <div class="flex gap-3">
                    <button type="submit" formaction="{{ route('laporan.stok-opname.pdf') }}" target="_blank" class="flex-1 py-3 bg-white border border-slate-200/80 hover:bg-slate-50 text-slate-700 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 hover:shadow-sm transition-all duration-200">
                        <i class="fas fa-file-pdf text-red-500 text-sm"></i>
                        <span>Ekspor PDF</span>
                    </button>
                    <button type="submit" formaction="{{ route('laporan.stok-opname.excel') }}" class="flex-1 py-3 bg-white border border-slate-200/80 hover:bg-slate-50 text-slate-700 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 hover:shadow-sm transition-all duration-200">
                        <i class="fas fa-file-excel text-emerald-600 text-sm"></i>
                        <span>Ekspor Excel</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
