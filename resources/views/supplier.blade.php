@extends('layouts.app')

@section('title', 'StockInfo - Supplier')

@section('content')
<div class="p-8 space-y-8">
    <div class="bg-[#1e40af] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-blue-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-user-friends text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Data Supplier</h2>
                <div class="flex items-center gap-2 text-blue-100 text-[10px] mt-1 font-bold">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="uppercase">MASTER DATA</span>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="text-white uppercase font-black tracking-widest">SUPPLIER</span>
                </div>
            </div>
        </div>
        <i class="fas fa-truck-fast absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6">
        <div class="flex justify-between items-center mb-6">
            <button class="bg-[#2d46b9] hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 shadow-lg shadow-blue-200 transition-all">
                <i class="fas fa-plus text-xs"></i>
                Tambah Supplier
            </button>
            <div class="relative w-64">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                <input type="text" placeholder="Cari Supplier..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-100 rounded-xl text-xs outline-none focus:border-blue-500 transition-all">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $suppliers = [
                    ['name' => 'PT. Rimba Jaya Abadi', 'contact' => 'Hendra Setiawan', 'phone' => '0812-3456-7890', 'address' => 'Jl. Industri No. 12, Bekasi', 'email' => 'hendra@rimbajaya.com'],
                    ['name' => 'CV. Bangunan Sejahtera', 'contact' => 'Siti Aminah', 'phone' => '0821-9876-5432', 'address' => 'Kawasan Pergudangan Blok C, Tangerang', 'email' => 'siti@bangunansejahtera.com'],
                    ['name' => 'Toko Cat Utama', 'contact' => 'Budi Hartono', 'phone' => '0811-5555-4444', 'address' => 'Jl. Raya Bogor KM 24, Jakarta Timur', 'email' => 'budi@catutama.id'],
                    ['name' => 'PT. Semen Indonesia', 'contact' => 'Rizky Pratama', 'phone' => '0813-0000-1111', 'address' => 'Gedung Wisma Semen, Jakarta Selatan', 'email' => 'rizky@semenindonesia.com'],
                ];
            @endphp
            @foreach($suppliers as $s)
            <div class="bg-slate-50 rounded-[2rem] p-6 border border-slate-100 hover:shadow-xl hover:shadow-blue-900/5 transition-all group">
                <div class="flex items-start justify-between mb-6">
                    <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-[#2d46b9] group-hover:text-white transition-all">
                        <i class="fas fa-building text-2xl"></i>
                    </div>
                    <div class="flex gap-2">
                        <button class="text-slate-300 hover:text-amber-500 transition-colors"><i class="fas fa-edit"></i></button>
                        <button class="text-slate-300 hover:text-rose-500 transition-colors"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">{{ $s['name'] }}</h3>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-4">Supplier Resmi</p>
                
                <div class="space-y-3 pt-4 border-t border-slate-200/50">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-user text-blue-600 text-[10px]"></i>
                        <span class="text-xs font-bold text-slate-600">{{ $s['contact'] }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fas fa-phone text-blue-600 text-[10px]"></i>
                        <span class="text-xs font-bold text-slate-600">{{ $s['phone'] }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fas fa-envelope text-blue-600 text-[10px]"></i>
                        <span class="text-xs font-bold text-slate-600">{{ $s['email'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
