@extends('layouts.app')

@section('title', 'StockInfo - Pengaturan')

@section('content')
<div class="max-w-4xl">
    <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-8">Pengaturan</h2>

    <div class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm">
        <div class="flex items-center gap-8">
            <div class="relative">
                <div class="w-24 h-24 bg-[#1e40af] rounded-[2rem] flex items-center justify-center text-white text-3xl font-bold shadow-lg shadow-blue-100 uppercase">
                    {{ substr($user->name ?? session('user.name', 'Administrator'), 0, 2) }}
                </div>
            </div>

            <div class="flex-1">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-extrabold text-slate-800">{{ $user->name ?? session('user.name', 'Administrator') }}</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-sm text-slate-400 font-medium capitalize">{{ $user->role ?? session('user.role', 'admin') }}</span>
                            <span class="text-slate-300 text-xs">•</span>
                            <span class="text-[10px] bg-emerald-100 text-emerald-600 px-2 py-0.5 rounded-lg font-bold uppercase tracking-wider">Akun Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 pt-10 border-t border-slate-50">
            <div class="max-w-sm">
                <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.2em] mb-3 block">Nama Lengkap</label>
                <p class="text-lg font-bold text-slate-700 border-b border-slate-100 pb-2">{{ $user->name ?? session('user.name', 'Administrator') }}</p>
            </div>
            <div class="max-w-sm mt-6">
                <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.2em] mb-3 block">Alamat Email</label>
                <p class="text-lg font-bold text-slate-700 border-b border-slate-100 pb-2">{{ $user->email ?? session('user.email', 'admin@stockinfo.com') }}</p>
            </div>
            <div class="max-w-sm mt-6">
                <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.2em] mb-3 block">Hak Akses</label>
                <p class="text-lg font-bold text-slate-700 border-b border-slate-100 pb-2 capitalize">{{ $user->role ?? session('user.role', 'admin') }}</p>
            </div>
        </div>
    </div>

    <div class="mt-6 bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex justify-between items-center px-10">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-red-500">
                <i class="fas fa-power-off"></i>
            </div>
            <p class="font-bold text-slate-800">Sesi Akun</p>
        </div>
        <button @click="showLogoutModal = true" class="text-red-500 font-extrabold text-sm hover:underline">
            Sign Out dari Perangkat Ini
        </button>
    </div>
</div>
@endsection
