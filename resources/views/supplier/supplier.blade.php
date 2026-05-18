@extends('layouts.app')

@section('title', 'StockInfo - Supplier')

@section('content')
<div class="space-y-8">
    <div class="bg-[#a93cd4] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-purple-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-box text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Supplier</h2>
                <div class="flex items-center gap-2 text-purple-100 text-xs mt-1">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="font-bold text-white uppercase tracking-wider">Supplier</span>
                </div>
            </div>
        </div>
        <i class="fas fa-box-open absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
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
            <button @click="showModal = true; modalType = 'add-supplier'" class="bg-[#1e40af] hover:bg-blue-800 text-white px-6 py-3 rounded-xl text-sm font-bold flex items-center gap-3 shadow-lg shadow-blue-200 transition-all">
                <i class="fas fa-user-plus"></i>
                Supplier Baru
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-[#2d46b9] text-white text-[10px] font-black uppercase tracking-widest text-left">
                        <th class="px-6 py-4 rounded-tl-2xl">No</th>
                        <th class="px-6 py-4">Kontak Person</th>
                        <th class="px-6 py-4 text-center">Nama Supplier</th>
                        <th class="px-6 py-4">No. Telepon</th>
                        <th class="px-6 py-4">Alamat</th>
                        <th class="px-6 py-4 text-center rounded-tr-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @php
                        $suppliers = [
                            ['no' => '01', 'person' => "Budi Santoso", 'name' => "PT. Semen Merah Putih", 'phone' => "+62 811-2222-3333", 'address' => "Jl. Sudirman No. 12, Jakarta"],
                            ['no' => '02', 'person' => "Siti Aminah", 'name' => "CV. Baja Utama", 'phone' => "+62 812-4444-5555", 'address' => "Kawasan Industri Jababeka"],
                            ['no' => '03', 'person' => "Andi Wijaya", 'name' => "Distributor Cat Jotun", 'phone' => "+62 813-6666-7777", 'address' => "Jl. Gatot Subroto Kav. 45"]
                        ];
                    @endphp
                    @foreach($suppliers as $supplier)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-6 text-sm font-bold text-slate-800">{{ $supplier['no'] }}</td>
                        <td class="px-6 py-6 text-sm text-slate-600 font-medium leading-relaxed">{!! nl2br($supplier['person']) !!}</td>
                        <td class="px-6 py-6 text-sm font-extrabold text-slate-800 text-center uppercase tracking-tight">{!! nl2br($supplier['name']) !!}</td>
                        <td class="px-6 py-6 text-sm text-slate-600 font-medium leading-relaxed">{{ $supplier['phone'] }}</td>
                        <td class="px-6 py-6 text-sm text-slate-500 font-medium max-w-xs truncate">{{ $supplier['address'] }}</td>
                        <td class="px-6 py-8">
                            <div class="flex justify-center gap-3">
                                <button @click="showModal = true; modalType = 'add-supplier'" class="p-2 text-slate-400 hover:text-blue-600 transition-colors">
                                    <i class="far fa-edit text-sm"></i>
                                </button>
                                <button @click="showDeleteModal = true; deleteTarget = '{{ $supplier['name'] }}'" class="p-2 text-slate-400 hover:text-red-600 transition-colors">
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

@section('modal-content')
<div x-show="modalType === 'add-supplier'">
    <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Tambah & Edit Supplier</h2>
    <form class="space-y-5">
        <div class="grid grid-cols-2 gap-5">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Nama Supplier</label>
                <input type="text" placeholder="PT. Jaya Abadi" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Kontak Person</label>
                <input type="text" placeholder="Nama Lengkap" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">No. Telepon</label>
                <input type="text" placeholder="0812xxxx" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Email</label>
                <input type="email" placeholder="supplier@example.com" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
        </div>
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Alamat Lengkap</label>
            <textarea placeholder="Masukkan alamat lengkap supplier" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all resize-none" rows="3"></textarea>
        </div>
        <div class="flex justify-end gap-3 pt-4">
            <button type="button" @click="showModal = false" class="px-8 py-2.5 bg-slate-100 text-slate-800 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">Batal</button>
            <button type="submit" class="px-8 py-2.5 bg-[#2d46b9] text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-200 hover:bg-blue-800 transition-all">Simpan</button>
        </div>
    </form>
</div>
@endsection
