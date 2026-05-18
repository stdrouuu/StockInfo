@extends('layouts.app')

@section('title', 'StockInfo - Proses')

@section('content')
<div class="space-y-8">
    <div class="bg-[#7c4335] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-orange-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-archive text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Proses</h2>
                <div class="flex items-center gap-2 text-orange-100 text-xs mt-1">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase tracking-wider font-bold text-white">Proses</span>
                </div>
            </div>
        </div>
        <i class="fas fa-file-alt absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6 space-y-6">
        <div class="flex items-center justify-between gap-4">
            <div class="flex flex-1 items-center gap-3 max-w-2xl">
                <div class="relative flex-1">
                    <input type="text" placeholder="Cari Supplier..." class="w-full px-5 py-3 bg-[#f1f5f9] border-none rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-slate-400">
                </div>
                <button class="w-11 h-11 flex items-center justify-center bg-white border border-slate-200 rounded-xl text-slate-400 hover:bg-slate-50 transition-all">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <button @click="showModal = true; modalType = 'add-proses'" class="bg-[#2d46b9] hover:bg-blue-800 text-white px-8 py-3 rounded-xl text-sm font-bold flex items-center gap-3 shadow-lg shadow-blue-200 transition-all">
                <i class="fas fa-plus"></i>
                Tambah
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-[#2d46b9] text-white text-[10px] font-black uppercase tracking-widest text-left">
                        <th class="px-6 py-4 rounded-tl-2xl">No</th>
                        <th class="px-6 py-4 text-center">Nama Barang</th>
                        <th class="px-6 py-4 text-center">No. Surat Jalan</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Kategori</th>
                        <th class="px-6 py-4 text-center rounded-tr-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @php
                        $processes = [
                            ['no' => '01', 'name' => 'Besi & Baja', 'sj' => 'DO/2025/001', 'status' => 'On-Going', 'cat' => 'Construction'],
                            ['no' => '02', 'name' => 'Semen Portland', 'sj' => 'DO/2025/042', 'status' => 'Pending', 'cat' => 'Raw Material'],
                            ['no' => '03', 'name' => 'Cat Tembok', 'sj' => 'DO/2025/089', 'status' => 'Completed', 'cat' => 'Finishing'],
                        ];
                    @endphp
                    @foreach($processes as $row)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-8 text-sm font-bold text-slate-800">{{ $row['no'] }}</td>
                        <td class="px-6 py-8 text-sm text-slate-600 font-medium text-center">{{ $row['name'] }}</td>
                        <td class="px-6 py-8 text-sm text-slate-600 font-medium text-center uppercase tracking-tight">{{ $row['sj'] }}</td>
                        <td class="px-6 py-8 text-sm text-slate-600 font-medium text-center">{{ $row['status'] }}</td>
                        <td class="px-6 py-8 text-center">
                            <span class="px-4 py-1.5 bg-[#f3e8ff] text-[#9333ea] text-[10px] font-black uppercase rounded-full">{{ $row['cat'] }}</span>
                        </td>
                        <td class="px-6 py-8">
                            <div class="flex justify-center gap-3">
                                <button @click="showModal = true; modalType = 'add-proses'" class="p-2 text-slate-400 hover:text-blue-600 transition-colors">
                                    <i class="far fa-edit text-sm"></i>
                                </button>
                                <button @click="showDeleteModal = true; deleteTarget = '{{ $row['name'] }}'" class="p-2 text-slate-400 hover:text-red-600 transition-colors">
                                    <i class="far fa-trash-alt text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pt-6 flex items-center justify-between">
            <button class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-400 hover:bg-slate-50 transition-all">Sebelumnya</button>
            <div class="flex items-center gap-2">
                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#0038a8] text-white text-xs font-bold shadow-md">1</button>
            </div>
            <button class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Selanjutnya</button>
        </div>
    </div>
</div>
@endsection
