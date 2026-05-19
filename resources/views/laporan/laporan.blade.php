@extends('layouts.app')

@section('title', 'StockInfo - Laporan Barang & Aset Toko')

@section('content')
<div class="space-y-8">
    <div class="bg-[#d32f2f] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-red-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-archive text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Laporan Barang & Aset Toko</h2>
                <div class="flex items-center gap-2 text-red-100 text-xs mt-1">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase tracking-wider font-bold text-white">Menu Laporan</span>
                </div>
            </div>
        </div>
        <i class="fas fa-file-alt absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-7 bg-white rounded-3xl border border-slate-100 shadow-sm p-8 flex justify-between items-center relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Nilai Modal Barang (Aset)</p>
                <h3 class="text-4xl font-black text-slate-800">Rp {{ number_format($invValue, 0, ',', '.') }}</h3>
                <p class="text-xs text-slate-400 mt-2 font-medium">Dihitung dari total {{ number_format($totalSKU, 0, ',', '.') }} jenis barang unik.</p>
            </div>
            <i class="fas fa-wallet text-[120px] text-slate-50 absolute -right-4 -bottom-4"></i>
        </div>
        <div class="col-span-5 bg-white rounded-3xl border border-slate-100 shadow-sm p-8 flex flex-col justify-between">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Jenis Barang Aktif</p>
                <h3 class="text-4xl font-black text-slate-800">{{ number_format($totalSKU, 0, ',', '.') }} jenis</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-8 bg-white rounded-3xl border border-slate-200 shadow-sm p-8 space-y-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                    <h4 class="font-bold text-slate-800">⚠️ Peringatan: Barang Hampir Habis!</h4>
                </div>
                <a href="{{ route('produk.index', ['filter' => 'kritis']) }}" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">Lihat Semua</a>
            </div>

            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">
                        <th class="pb-4">Nama Barang</th>
                        <th class="pb-4">Kode Barang</th>
                        <th class="pb-4 text-center">Sisa Stok</th>
                        <th class="pb-4 text-center">Batas Min</th>
                        <th class="pb-4 text-center">Status</th>
                        <th class="pb-4 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($lowStockAlerts as $alert)
                    <tr class="text-sm group">
                        <td class="py-4 font-bold text-slate-700">{{ $alert->nama }}</td>
                        <td class="py-4 text-slate-400 font-medium">{{ $alert->sku }}</td>
                        <td class="py-4 font-black text-red-500 text-center">{{ $alert->stok }}</td>
                        <td class="py-4 text-slate-400 font-medium text-center">{{ $alert->stok_minimum }}</td>
                        <td class="py-4 text-center">
                            @if($alert->stok == 0)
                                <span class="px-2 py-0.5 bg-rose-100 text-rose-700 text-[9px] font-black uppercase rounded">KOSONG</span>
                            @elseif($alert->stok <= $alert->stok_minimum / 2)
                                <span class="px-2 py-0.5 bg-red-50 text-red-600 text-[9px] font-black uppercase rounded">KRITIS</span>
                            @else
                                <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase rounded">SEDIKIT</span>
                            @endif
                        </td>
                        <td class="py-4 text-right">
                            <a href="{{ route('transaksi.index') }}" class="text-blue-600 font-bold text-xs hover:underline">Tambah Stok</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-slate-400 font-semibold text-sm">Semua barang memiliki stok yang aman!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="col-span-4 bg-white rounded-3xl border border-slate-200 shadow-sm p-8 flex flex-col">
            <div class="mb-8">
                <h4 class="font-bold text-slate-800">Transaksi Terakhir Toko</h4>
                <p class="text-[10px] text-slate-400 font-medium mt-1">Riwayat aktivitas masuk & keluar barang secara langsung</p>
            </div>

            <div class="flex-1 space-y-6">
                @forelse($recentTransactions as $row)
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ strtolower($row->tipe) === 'masuk' ? 'bg-green-50 text-green-600' : 'bg-rose-50 text-rose-600' }}">
                        <i class="fas {{ strtolower($row->tipe) === 'masuk' ? 'fa-sign-in-alt' : 'fa-sign-out-alt' }}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 truncate">{{ $row->kode }}</p>
                        <p class="text-[9px] font-black uppercase {{ strtolower($row->tipe) === 'masuk' ? 'text-green-500' : 'text-rose-500' }}">
                            {{ strtolower($row->tipe) === 'masuk' ? 'Barang Masuk' : 'Barang Keluar' }}
                        </p>
                    </div>
                    <span class="text-[10px] text-slate-300 font-bold uppercase">{{ $row->tanggal->format('d M') }}</span>
                </div>
                @empty
                <div class="text-center py-6 text-slate-400 font-medium text-xs">Belum ada transaksi dicatat.</div>
                @endforelse
            </div>

            <a href="{{ route('transaksi.index') }}" class="w-full block bg-slate-50 text-slate-500 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest mt-8 hover:bg-slate-100 transition-all text-center">
                Lihat Semua Transaksi
            </a>
        </div>
    </div>
</div>
@endsection
