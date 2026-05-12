@extends('layouts.app')

@section('title', 'StockInfo - Laporan Stok Opname')

@section('content')
<div class="p-8 space-y-8">
    <div class="bg-[#2d46b9] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-blue-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-file-contract text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Laporan Periode Stok Opname</h2>
                <div class="flex items-center gap-2 text-blue-100 text-[10px] mt-1 font-bold">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase">STOK OPNAME</span>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="text-white uppercase font-black tracking-widest">LAPORAN</span>
                </div>
            </div>
        </div>
        <i class="fas fa-clipboard-list absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
            <div>
                <h3 class="text-xl font-black text-slate-800">Filter Laporan</h3>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Pilih periode untuk melihat detail selisih</p>
            </div>
            <div class="flex gap-4">
                <select class="px-6 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-600 outline-none focus:border-blue-500 transition-all">
                    <option>Pilih Periode</option>
                    <option selected>1 Okt 2025 s/d 30 Okt 2025</option>
                    <option>01 Sep 2025 s/d 29 Sep 2025</option>
                </select>
                <button class="bg-[#2d46b9] hover:bg-blue-800 text-white px-8 py-3 rounded-xl text-sm font-bold shadow-lg shadow-blue-200 transition-all">
                    Tampilkan
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-emerald-50 p-6 rounded-2xl border border-emerald-100">
                <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">Total Item Sesuai</p>
                <h4 class="text-3xl font-black text-emerald-700">145 <span class="text-sm font-bold opacity-60">Barang</span></h4>
            </div>
            <div class="bg-rose-50 p-6 rounded-2xl border border-rose-100">
                <p class="text-[10px] font-black text-rose-600 uppercase tracking-widest mb-1">Total Item Selisih</p>
                <h4 class="text-3xl font-black text-rose-700">5 <span class="text-sm font-bold opacity-60">Barang</span></h4>
            </div>
            <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100">
                <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1">Akurasi Stok</p>
                <h4 class="text-3xl font-black text-blue-700">96.7%</h4>
            </div>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-slate-100">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4 text-center">Stok Sistem</th>
                        <th class="px-6 py-4 text-center">Stok Fisik</th>
                        <th class="px-6 py-4 text-center">Selisih</th>
                        <th class="px-6 py-4">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @php
                        $items = [
                            ['no' => 1, 'name' => 'Cat Tembok Putih 5Kg', 'sku' => 'SKU-CAT-WHT-05', 'sys' => 120, 'phys' => 120, 'diff' => 0, 'note' => 'Cocok'],
                            ['no' => 2, 'name' => 'Semen Padang 40Kg', 'sku' => 'SKU-SEM-PDG-40', 'sys' => 500, 'phys' => 498, 'diff' => -2, 'note' => 'Kemasan Rusak'],
                            ['no' => 3, 'name' => 'Baut Baja M8 x 50', 'sku' => 'SKU-BT-M8-50', 'sys' => 2500, 'phys' => 2503, 'diff' => 3, 'note' => 'Kelebihan Kirim'],
                        ];
                    @endphp
                    @foreach($items as $i)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 text-sm text-slate-400 font-medium">{{ $i['no'] }}</td>
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-extrabold text-slate-800">{{ $i['name'] }}</span>
                                <span class="text-[10px] text-slate-400 font-bold tracking-widest">{{ $i['sku'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center text-sm font-bold text-slate-600">{{ $i['sys'] }}</td>
                        <td class="px-6 py-5 text-center text-sm font-black text-slate-800">{{ $i['phys'] }}</td>
                        <td class="px-6 py-5 text-center">
                            <span class="text-sm font-black {{ $i['diff'] == 0 ? 'text-slate-400' : ($i['diff'] < 0 ? 'text-rose-600' : 'text-emerald-600') }}">
                                {{ $i['diff'] > 0 ? '+' : '' }}{{ $i['diff'] }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-xs font-bold text-slate-400 italic">{{ $i['note'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-8 flex justify-end">
            <button class="bg-white border-2 border-slate-100 text-slate-600 px-8 py-3 rounded-xl text-sm font-bold flex items-center gap-3 hover:bg-slate-50 transition-all">
                <i class="fas fa-print"></i> Cetak Laporan
            </button>
        </div>
    </div>
</div>
@endsection
