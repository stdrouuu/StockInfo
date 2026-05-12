@extends('layouts.app')

@section('title', 'StockInfo - Kategori Produk')

@section('content')
<div class="space-y-8">
    <div class="bg-[#3b59bc] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-blue-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-box text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Kategori Produk</h2>
                <div class="flex items-center gap-2 text-blue-100 text-xs mt-1">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span>DATA PRODUK</span>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="font-bold text-white">KATEGORI</span>
                </div>
            </div>
        </div>
        <i class="fas fa-box-open absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 flex items-center justify-between gap-4">
            <div class="relative w-full max-w-md">
                <input type="text" placeholder="Cari Kategori Produk" class="w-full px-5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all" />
            </div>
            <button @click="showModal = true; modalType = 'add-category'" class="bg-[#1e40af] hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 shadow-lg shadow-blue-200 transition-all">
                <i class="fas fa-plus"></i>
                Kategori baru
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-[#0038a8] text-white text-[11px] font-bold uppercase tracking-widest text-left">
                        <th class="px-8 py-4 w-20">No</th>
                        <th class="px-8 py-4 text-center">Nama Kategori</th>
                        <th class="px-8 py-4 text-right w-32">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php
                        $categories = [
                            "Semen & Mortar", "Besi & Baja", "Cat & Pelapis", "Kayu & Papan",
                            "Atap & Plafon", "Lantai & Keramik", "Pipa & Sanitasi", "Perkakas",
                            "Listrik", "Alat Pelindung Diri"
                        ];
                    @endphp
                    @foreach($categories as $index => $category)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-8 py-5 text-slate-400 text-sm font-medium">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-8 py-5 text-center font-bold text-slate-700 text-sm">{{ $category }}</td>
                        <td class="px-8 py-5">
                            <div class="flex justify-end gap-2.5">
                                <button @click="showModal = true; modalType = 'add-category'" class="flex items-center justify-center p-1 text-slate-400 hover:text-blue-600 transition-all">
                                    <i class="far fa-edit text-sm"></i>
                                </button>
                                <button @click="showDeleteModal = true; deleteTarget = '{{ $category }}'" class="flex items-center justify-center p-1 text-slate-400 hover:text-red-600 transition-all">
                                    <i class="far fa-trash-alt text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100 flex items-center justify-between">
            <button class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-400 hover:bg-slate-50 transition-all">Sebelumnya</button>
            <div class="flex items-center gap-2">
                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#0038a8] text-white text-xs font-bold shadow-md">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-500 text-xs font-bold">2</button>
            </div>
            <button class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Selanjutnya</button>
        </div>
    </div>
</div>
@endsection

@section('modal-content')
<div x-show="modalType === 'add-category'">
    <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Tambah & Edit Kategori</h2>
    <form class="space-y-5">
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Nama Kategori</label>
            <input type="text" placeholder="Masukkan nama kategori baru" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
        </div>
        <div class="flex justify-end gap-3 pt-4">
            <button type="button" @click="showModal = false" class="px-8 py-2.5 bg-slate-100 text-slate-800 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">Batal</button>
            <button type="submit" class="px-8 py-2.5 bg-[#2d46b9] text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-200 hover:bg-blue-800 transition-all">Simpan</button>
        </div>
    </form>
</div>
@endsection
