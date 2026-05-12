@extends('layouts.app')

@section('title', 'StockInfo - Kategori Produk')

@section('content')
<div class="p-8 space-y-8">
    <div class="bg-[#1e40af] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-blue-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-tags text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Kategori Produk</h2>
                <div class="flex items-center gap-2 text-blue-100 text-[10px] mt-1 font-bold">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase">MASTER DATA</span>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="text-white uppercase font-black tracking-widest">KATEGORI</span>
                </div>
            </div>
        </div>
        <i class="fas fa-tag absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-1">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sticky top-24">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Tambah Kategori</h3>
                <form class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Kategori</label>
                        <input type="text" placeholder="Masukkan nama kategori..." class="w-full px-5 py-3 bg-[#f8fafc] border border-slate-100 rounded-xl text-sm font-medium outline-none focus:border-blue-500 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kode Kategori</label>
                        <input type="text" placeholder="KAT-001" class="w-full px-5 py-3 bg-[#f8fafc] border border-slate-100 rounded-xl text-sm font-medium outline-none focus:border-blue-500 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Keterangan</label>
                        <textarea placeholder="Deskripsi singkat..." class="w-full px-5 py-3 bg-[#f8fafc] border border-slate-100 rounded-xl text-sm font-medium outline-none focus:border-blue-500 transition-all h-24 resize-none"></textarea>
                    </div>
                    <button class="w-full bg-[#2d46b9] hover:bg-blue-800 text-white py-3 rounded-xl text-sm font-bold flex items-center justify-center gap-2 shadow-lg shadow-blue-200 transition-all mt-4">
                        <i class="fas fa-plus text-xs"></i>
                        Simpan Kategori
                    </button>
                </form>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">Daftar Kategori</h3>
                    <div class="relative w-64">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                        <input type="text" placeholder="Cari kategori..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-100 rounded-lg text-xs outline-none">
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-[#f8fafc] text-slate-400 text-[10px] font-black uppercase tracking-widest">
                                <th class="px-6 py-4">No</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4">Kode</th>
                                <th class="px-6 py-4">Jumlah Produk</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @php
                                $categories = [
                                    ['no' => 1, 'name' => 'Material Dasar', 'code' => 'MAT', 'count' => 450],
                                    ['no' => 2, 'name' => 'Hardware & Tools', 'code' => 'HRD', 'count' => 1200],
                                    ['no' => 3, 'name' => 'Cat & Pelapis', 'code' => 'PNT', 'count' => 150],
                                    ['no' => 4, 'name' => 'Plumbing', 'code' => 'PLB', 'count' => 300],
                                    ['no' => 5, 'name' => 'Electrical', 'code' => 'ELC', 'count' => 85],
                                ];
                            @endphp
                            @foreach($categories as $c)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-5 text-sm text-slate-400 font-medium">{{ $c['no'] }}</td>
                                <td class="px-6 py-5 text-sm font-extrabold text-slate-800">{{ $c['name'] }}</td>
                                <td class="px-6 py-5">
                                    <span class="px-2 py-1 bg-slate-100 text-slate-600 text-[10px] font-black rounded-md">{{ $c['code'] }}</span>
                                </td>
                                <td class="px-6 py-5 text-sm font-black text-[#2d46b9]">{{ $c['count'] }} <span class="text-[10px] text-slate-400 font-bold ml-1">Produk</span></td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button class="text-slate-300 hover:text-amber-500 transition-colors"><i class="fas fa-edit"></i></button>
                                        <button class="text-slate-300 hover:text-rose-500 transition-colors"><i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
