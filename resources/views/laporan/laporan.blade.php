@extends('layouts.app')

@section('title', 'StockInfo - Unduh Laporan')

@section('content')
<div class="space-y-8">
    <!-- Header Banner (Branded Red) -->
    <div class="bg-[#d32f2f] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-red-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-file-invoice text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight">Laporan & Ekspor Berkas</h2>
                <div class="flex items-center gap-2 text-red-100 text-xs mt-1">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px] opacity-60"></i>
                    <span class="uppercase tracking-wider font-bold text-white">Laporan</span>
                </div>
            </div>
        </div>
        <i class="fas fa-print absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <!-- Reports Hub Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- 1. Executive Summary -->
        <div class="bg-white rounded-[32px] border border-slate-200/60 shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-all duration-300">
            <div>
                <div class="flex items-center gap-4 border-b border-slate-100 pb-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-inner">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-base">Ringkasan Eksekutif</h3>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-0.5">Dashboard Summary</p>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-4 leading-relaxed font-medium">
                    Laporan ringkasan eksekutif yang mencakup metrik performa utama, total nominal aset inventaris gudang, supplier terdaftar, dan log aktivitas operasional terakhir.
                </p>
                
                <!-- No Filters Needed -->
                <div class="bg-slate-50 border border-slate-100/70 rounded-2xl p-4 my-6 text-center text-xs font-bold text-slate-400">
                    <i class="fas fa-info-circle mr-1"></i> Tanpa Parameter Tambahan
                </div>
            </div>

            <!-- Export Actions -->
            <form method="GET" class="flex gap-3">
                <button type="submit" formaction="{{ route('laporan.dashboard.pdf') }}" target="_blank" class="flex-1 py-3 bg-rose-50 text-rose-700 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 hover:bg-rose-100 hover:text-rose-800 transition-all duration-200">
                    <i class="fas fa-file-pdf"></i>
                    <span>Ekspor PDF</span>
                </button>
                <button type="submit" formaction="{{ route('laporan.dashboard.excel') }}" class="flex-1 py-3 bg-emerald-50 text-emerald-700 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 hover:bg-emerald-100 hover:text-emerald-800 transition-all duration-200">
                    <i class="fas fa-file-excel"></i>
                    <span>Ekspor Excel</span>
                </button>
            </form>
        </div>

        <!-- 2. Product Catalog -->
        <div class="bg-white rounded-[32px] border border-slate-200/60 shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-all duration-300">
            <form method="GET" class="flex flex-col h-full justify-between">
                <div>
                    <div class="flex items-center gap-4 border-b border-slate-100 pb-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shadow-inner">
                            <i class="fas fa-box"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-slate-800 text-base">Katalog & Aset Produk</h3>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-0.5">Product Asset Catalog</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 mt-4 leading-relaxed font-medium">
                        Daftar lengkap katalog produk terdaftar, nilai nominal investasi stok barang, kategori produk, serta batas minimum persediaan gudang.
                    </p>

                    <!-- Filters Box -->
                    <div class="bg-slate-50 border border-slate-100/70 rounded-2xl p-4 my-6 space-y-4">
                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Kategori Produk</label>
                            <select name="kategori_id" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                <option value="all">Semua Kategori</option>
                                @foreach($kategoris as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Status Persediaan</label>
                            <select name="stok_status" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                <option value="all">Semua Status Stok</option>
                                <option value="safe">Stok Aman (Di atas Minimum)</option>
                                <option value="low">Stok Rendah (Kritis)</option>
                                <option value="empty">Stok Kosong</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Export Actions -->
                <div class="flex gap-3">
                    <button type="submit" formaction="{{ route('laporan.produk.pdf') }}" target="_blank" class="flex-1 py-3 bg-rose-50 text-rose-700 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 hover:bg-rose-100 hover:text-rose-800 transition-all duration-200">
                        <i class="fas fa-file-pdf"></i>
                        <span>Ekspor PDF</span>
                    </button>
                    <button type="submit" formaction="{{ route('laporan.produk.excel') }}" class="flex-1 py-3 bg-emerald-50 text-emerald-700 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 hover:bg-emerald-100 hover:text-emerald-800 transition-all duration-200">
                        <i class="fas fa-file-excel"></i>
                        <span>Ekspor Excel</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- 3. Transactions Inbound & Outbound -->
        <div class="bg-white rounded-[32px] border border-slate-200/60 shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-all duration-300">
            <form method="GET" class="flex flex-col h-full justify-between">
                <div>
                    <div class="flex items-center gap-4 border-b border-slate-100 pb-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shadow-inner">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-slate-800 text-base">Transaksi Masuk & Keluar</h3>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-0.5">Logistics & Transactions</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 mt-4 leading-relaxed font-medium">
                        Log logistik barang masuk (Inbound) dan barang keluar (Outbound) secara lengkap beserta dengan detail supplier, tujuan, dan total nilai mutasi.
                    </p>

                    <!-- Filters Box -->
                    <div class="bg-slate-50 border border-slate-100/70 rounded-2xl p-4 my-6 space-y-4">
                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Tipe Transaksi</label>
                            <select name="tipe" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                <option value="all">Semua Tipe</option>
                                <option value="masuk">Barang Masuk (Inbound)</option>
                                <option value="keluar">Barang Keluar (Outbound)</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" class="w-full bg-white border border-slate-200 rounded-xl px-2 py-1.5 text-[10px] font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="w-full bg-white border border-slate-200 rounded-xl px-2 py-1.5 text-[10px] font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-100">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Export Actions -->
                <div class="flex gap-3">
                    <button type="submit" formaction="{{ route('laporan.transaksi.pdf') }}" target="_blank" class="flex-1 py-3 bg-rose-50 text-rose-700 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 hover:bg-rose-100 hover:text-rose-800 transition-all duration-200">
                        <i class="fas fa-file-pdf"></i>
                        <span>Ekspor PDF</span>
                    </button>
                    <button type="submit" formaction="{{ route('laporan.transaksi.excel') }}" class="flex-1 py-3 bg-emerald-50 text-emerald-700 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 hover:bg-emerald-100 hover:text-emerald-800 transition-all duration-200">
                        <i class="fas fa-file-excel"></i>
                        <span>Ekspor Excel</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- 4. Supplier List -->
        <div class="bg-white rounded-[32px] border border-slate-200/60 shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-all duration-300">
            <div>
                <div class="flex items-center gap-4 border-b border-slate-100 pb-4">
                    <div class="w-12 h-12 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center text-xl shadow-inner">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-base">Kemitraan Supplier</h3>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-0.5">Supplier Directory</p>
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-4 leading-relaxed font-medium">
                    Laporan informasi kontak person, nomor telepon, email, alamat fisik supplier terdaftar, serta frekuensi logistik transaksi barang masuk.
                </p>
                
                <!-- No Filters Needed -->
                <div class="bg-slate-50 border border-slate-100/70 rounded-2xl p-4 my-6 text-center text-xs font-bold text-slate-400">
                    <i class="fas fa-info-circle mr-1"></i> Tanpa Parameter Tambahan
                </div>
            </div>

            <!-- Export Actions -->
            <form method="GET" class="flex gap-3">
                <button type="submit" formaction="{{ route('laporan.supplier.pdf') }}" target="_blank" class="flex-1 py-3 bg-rose-50 text-rose-700 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 hover:bg-rose-100 hover:text-rose-800 transition-all duration-200">
                    <i class="fas fa-file-pdf"></i>
                    <span>Ekspor PDF</span>
                </button>
                <button type="submit" formaction="{{ route('laporan.supplier.excel') }}" class="flex-1 py-3 bg-emerald-50 text-emerald-700 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 hover:bg-emerald-100 hover:text-emerald-800 transition-all duration-200">
                    <i class="fas fa-file-excel"></i>
                    <span>Ekspor Excel</span>
                </button>
            </form>
        </div>

        <!-- 5. Stock Opname Report -->
        <div class="bg-white rounded-[32px] border border-slate-200/60 shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-all duration-300">
            <form method="GET" class="flex flex-col h-full justify-between">
                <div>
                    <div class="flex items-center gap-4 border-b border-slate-100 pb-4">
                        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl shadow-inner">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-slate-800 text-base">Laporan Stok Opname</h3>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-0.5">Stock Audits & Opname</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 mt-4 leading-relaxed font-medium">
                        Laporan audit fisik penyesuaian persediaan barang gudang. Menampilkan persentase akurasi stok sistem dengan perhitungan fisik di lapangan.
                    </p>

                    <!-- Filters Box -->
                    <div class="bg-slate-50 border border-slate-100/70 rounded-2xl p-4 my-6 space-y-4">
                        <div class="space-y-1">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Periode Audit Stok Opname</label>
                            <select name="periode_id" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-100">
                                @foreach($periodes as $per)
                                    <option value="{{ $per->id }}">{{ $per->keterangan }} ({{ $per->tanggal_mulai->format('d/m') }} - {{ $per->tanggal_selesai->format('d/m') }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Export Actions -->
                <div class="flex gap-3">
                    <button type="submit" formaction="{{ route('laporan.stok-opname.pdf') }}" target="_blank" class="flex-1 py-3 bg-rose-50 text-rose-700 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 hover:bg-rose-100 hover:text-rose-800 transition-all duration-200">
                        <i class="fas fa-file-pdf"></i>
                        <span>Ekspor PDF</span>
                    </button>
                    <button type="submit" formaction="{{ route('laporan.stok-opname.excel') }}" class="flex-1 py-3 bg-emerald-50 text-emerald-700 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 hover:bg-emerald-100 hover:text-emerald-800 transition-all duration-200">
                        <i class="fas fa-file-excel"></i>
                        <span>Ekspor Excel</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
