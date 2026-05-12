@extends('layouts.app')

@section('title', 'StockInfo - Data Transaksi Masuk')

@section('content')
<div class="space-y-8">
    <div class="bg-[#064e3b] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-emerald-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-chart-line text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Data Transaksi Masuk</h2>
                <div class="flex items-center gap-2 text-emerald-100 text-xs mt-1">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase tracking-wider">Transaksi Masuk</span>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="font-bold text-white uppercase tracking-wider">Data</span>
                </div>
            </div>
        </div>
        <i class="fas fa-arrow-trend-up absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-8 space-y-8">
        
        <div class="space-y-6">
            {{-- Removed Tambah Transaksi Masuk button --}}

            <div class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[200px] space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pengirim</label>
                    <input type="text" placeholder="Pengirim" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="flex-1 min-w-[200px] space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Awal</label>
                    <input type="text" placeholder="mm/dd/yyyy" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="flex-1 min-w-[200px] space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Akhir</label>
                    <input type="text" placeholder="mm/dd/yyyy" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="flex gap-2">
                    <button class="w-11 h-11 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:bg-slate-50 transition-all">
                        <i class="fas fa-search"></i>
                    </button>
              
                    <button class="bg-[#2d46b9] hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 transition-all">
                        <i class="fas fa-file-pdf text-xs"></i>
                        Ekspor PDF
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-separate border-spacing-0">
                <thead>
                    <tr class="bg-[#2d46b9] text-white text-[10px] font-black uppercase tracking-widest text-left">
                        <th class="px-6 py-4 rounded-tl-xl">No</th>
                        <th class="px-6 py-4">Nomor Transaksi</th>
                        <th class="px-6 py-4">Jumlah Barang</th>
                        <th class="px-6 py-4">Total Harga</th>
                        <th class="px-6 py-4 text-center">Pengirim</th>
                        <th class="px-6 py-4">Tanggal Transaksi</th>
                        <th class="px-6 py-4 text-center rounded-tr-xl">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @php
                        $transactions = [
                            ['no' => '1', 'id' => 'TM/20240520/001', 'qty' => '150', 'price' => 'Rp 9.750.000', 'from' => 'PT. Semen Merah Putih', 'date' => 'Senin, 20 Mei 2024'],
                            ['no' => '2', 'id' => 'TM/20240519/042', 'qty' => '85', 'price' => 'Rp 12.420.000', 'from' => 'CV. Baja Utama', 'date' => 'Kamis, 19 Mei 2024'],
                            ['no' => '3', 'id' => 'TM/20240519/041', 'qty' => '20', 'price' => 'Rp 4.500.000', 'from' => 'Distributor Cat Jotun', 'date' => 'Kamis, 19 Mei 2024'],
                            ['no' => '4', 'id' => 'TM/20240518/012', 'qty' => '300', 'price' => 'Rp 3.200.000', 'from' => 'Toko Inti Bangunan', 'date' => 'Rabu, 18 Mei 2024'],
                            ['no' => '5', 'id' => 'TM/20240518/011', 'qty' => '200', 'price' => 'Rp 11.000.000', 'from' => 'PT. Holcim Indonesia', 'date' => 'Rabu, 18 Mei 2024']
                        ];
                    @endphp
                    @foreach($transactions as $row)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 text-sm font-medium text-slate-400">{{ $row['no'] }}</td>
                        <td class="px-6 py-5 text-sm font-extrabold text-[#2d46b9]">{{ $row['id'] }}</td>
                        <td class="px-6 py-5 text-sm font-medium text-slate-700">{{ $row['qty'] }}</td>
                        <td class="px-6 py-5 text-sm font-extrabold text-slate-800">{{ $row['price'] }}</td>
                        <td class="px-6 py-5 text-sm font-medium text-slate-600 text-center">{{ $row['from'] }}</td>
                        <td class="px-6 py-5 text-sm font-medium text-slate-500">{{ $row['date'] }}</td>
                        <td class="px-6 py-5 text-center">
                            <button class="text-[#2d46b9] hover:text-blue-800">
                                <i class="far fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between">
            <button class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-400 hover:bg-slate-50 transition-all">Sebelumnya</button>
            <div class="flex items-center gap-2">
                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#2d46b9] text-white text-xs font-bold shadow-md">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-500 text-xs font-bold transition-all">2</button>
            </div>
            <button class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Selanjutnya</button>
        </div>
    </div>
</div>
@endsection
