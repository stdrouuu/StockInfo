@extends('layouts.app')

@section('title', 'StockInfo - Riwayat Transaksi Masuk')

@section('content')
<div class="p-8 space-y-8">
    <div class="bg-[#0f172a] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-slate-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-file-invoice text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Riwayat Transaksi Masuk</h2>
                <div class="flex items-center gap-2 text-slate-400 text-[10px] mt-1 font-bold">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase">TRANSAKSI</span>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="text-white uppercase font-black tracking-widest">RIWAYAT MASUK</span>
                </div>
            </div>
        </div>
        <i class="fas fa-file-import absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6">
        <div class="flex justify-between items-center mb-6">
            <div class="flex gap-4">
                <div class="relative w-64">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                    <input type="text" placeholder="Cari No. Transaksi / Supplier..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-100 rounded-xl text-xs outline-none focus:border-blue-500 transition-all">
                </div>
                <input type="date" class="px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl text-xs font-bold text-slate-600 outline-none">
            </div>
            <a href="{{ route('transaksi.create') }}" class="bg-[#2d46b9] hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 shadow-lg shadow-blue-200 transition-all">
                <i class="fas fa-plus text-xs"></i>
                Input Transaksi Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-[#2d46b9] text-white text-[10px] font-black uppercase tracking-widest">
                        <th class="px-6 py-4 rounded-tl-xl">No. Transaksi</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Supplier</th>
                        <th class="px-6 py-4 text-center">Item</th>
                        <th class="px-6 py-4 text-right">Total Transaksi</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 rounded-tr-xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @php
                        $transactions = [
                            ['id' => 'TRM-20260508-001', 'date' => '08 Mei 2026', 'supplier' => 'PT. Rimba Jaya Abadi', 'items' => 12, 'total' => 15450000, 'status' => 'Selesai'],
                            ['id' => 'TRM-20260507-045', 'date' => '07 Mei 2026', 'supplier' => 'CV. Bangunan Sejahtera', 'items' => 5, 'total' => 2100000, 'status' => 'Selesai'],
                            ['id' => 'TRM-20260507-012', 'date' => '07 Mei 2026', 'supplier' => 'Toko Cat Utama', 'items' => 8, 'total' => 4500000, 'status' => 'Pending'],
                            ['id' => 'TRM-20260506-089', 'date' => '06 Mei 2026', 'supplier' => 'PT. Semen Indonesia', 'items' => 1, 'total' => 34000000, 'status' => 'Selesai'],
                        ];
                    @endphp
                    @foreach($transactions as $t)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5">
                            <span class="text-sm font-black text-[#2d46b9]">{{ $t['id'] }}</span>
                        </td>
                        <td class="px-6 py-5 text-sm text-slate-500 font-medium">{{ $t['date'] }}</td>
                        <td class="px-6 py-5 text-sm font-extrabold text-slate-800">{{ $t['supplier'] }}</td>
                        <td class="px-6 py-5 text-center text-sm font-bold text-slate-500">{{ $t['items'] }} <span class="text-[10px] text-slate-300 uppercase ml-1">Items</span></td>
                        <td class="px-6 py-5 text-right text-sm font-black text-slate-800">Rp {{ number_format($t['total'], 0, ',', '.') }}</td>
                        <td class="px-6 py-5">
                            <span class="px-3 py-1 {{ $t['status'] === 'Selesai' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }} text-[10px] font-black uppercase rounded-full">{{ $t['status'] }}</span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <button class="text-slate-300 hover:text-slate-600 transition-colors"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
