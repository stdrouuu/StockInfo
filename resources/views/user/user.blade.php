@extends('layouts.app')

@section('title', 'StockInfo - Manajemen User')

@section('content')
<div class="space-y-8">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-semibold border border-emerald-200">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 rounded-xl bg-rose-50 text-rose-700 text-sm font-semibold border border-rose-200">
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 text-rose-700 text-sm font-semibold border border-rose-200">
            <ul class="list-disc pl-5 space-y-1 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-[#0891b2] rounded-3xl p-6 sm:p-8 text-white relative overflow-hidden shadow-xl shadow-cyan-900/10">
        <div class="relative z-10 flex items-center gap-4 sm:gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-users text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Manajemen User</h2>
                <div class="flex items-center gap-2 text-cyan-100 text-xs mt-1">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="font-bold text-white uppercase tracking-wider">Manajemen User</span>
                </div>
            </div>
        </div>
        <i class="fas fa-users absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex flex-1 items-center gap-3 w-full sm:max-w-2xl">
                <!-- Search Form -->
                <form method="GET" action="{{ route('user.index') }}" class="flex gap-2 flex-1">
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama atau Username..." class="w-full px-5 py-3 bg-[#f1f5f9] border-none rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-slate-400">
                    </div>
                    <button type="submit" class="bg-[#1e40af] hover:bg-blue-800 text-white px-5 sm:px-6 py-3 rounded-xl text-sm font-bold flex items-center gap-2 transition-all">
                        <i class="fas fa-search"></i>
                        <span>Cari</span>
                    </button>
                </form>
            </div>
            <button @click="$dispatch('open-user-modal', { mode: 'add', action: '{{ route('user.store') }}' })" class="w-full sm:w-auto bg-[#1e40af] hover:bg-blue-800 text-white px-6 py-3 rounded-xl text-sm font-bold flex items-center justify-center gap-3 shadow-lg shadow-blue-200 transition-all">
                <i class="fas fa-user-plus"></i>
                <span>User Baru</span>
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-[#2d46b9] text-white text-[10px] font-black uppercase tracking-widest text-left">
                        <th class="px-6 py-4 rounded-tl-2xl">No</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4 text-center">Hak Akses (Role)</th>
                        <th class="px-6 py-4 text-center">Tanggal Terdaftar</th>
                        <th class="px-6 py-4 text-center rounded-tr-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $index => $row)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-6 text-sm font-bold text-slate-800">{{ str_pad($index + 1 + ($users->currentPage() - 1) * $users->perPage(), 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-6 text-sm font-extrabold text-slate-800 tracking-tight">{{ $row->name }}</td>
                        <td class="px-6 py-6 text-sm text-slate-600 font-medium">{{ $row->username }}</td>
                        <td class="px-6 py-6 text-center">
                            @if($row->role === 'admin')
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold uppercase tracking-wider border border-blue-100">ADMIN</span>
                            @else
                                <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-bold uppercase tracking-wider border border-amber-100">STAFF</span>
                            @endif
                        </td>
                        <td class="px-6 py-6 text-sm text-slate-500 font-medium text-center">{{ $row->created_at->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}</td>
                        <td class="px-6 py-8">
                            <div class="flex justify-center gap-3">
                                <button @click="$dispatch('open-user-modal', {
                                    mode: 'edit',
                                    name: '{{ $row->name }}',
                                    username: '{{ $row->username }}',
                                    role: '{{ $row->role }}',
                                    action: '{{ route('user.update', $row->id) }}'
                                })" class="p-2 text-slate-400 hover:text-blue-600 transition-colors">
                                    <i class="far fa-edit text-sm"></i>
                                </button>
                                @if($row->id !== auth()->id())
                                <button @click="showDeleteModal = true; deleteTarget = '{{ $row->name }}'; deleteAction = '{{ route('user.destroy', $row->id) }}'" class="p-2 text-slate-400 hover:text-red-600 transition-colors">
                                    <i class="far fa-trash-alt text-sm"></i>
                                </button>
                                @else
                                <span class="p-2 text-slate-200 cursor-not-allowed" title="Anda tidak dapat menghapus akun Anda sendiri">
                                    <i class="far fa-trash-alt text-sm"></i>
                                </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-400 font-medium">Tidak ada user ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">
                Menampilkan {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} User
            </div>
            <div class="flex items-center gap-2">
                @if ($users->onFirstPage())
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $users->appends(request()->query())->previousPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Sebelumnya</a>
                @endif

                @if ($users->hasMorePages())
                    <a href="{{ $users->appends(request()->query())->nextPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Selanjutnya</a>
                @else
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Selanjutnya</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal-content')
<div x-show="modalType === 'add-user'"
     x-data="{ 
        mode: 'add',
        name: '',
        username: '',
        role: 'staff',
        password: '',
        action: '{{ route('user.store') }}'
     }"
     @open-user-modal.window="
        showModal = true;
        modalType = 'add-user';
        mode = $event.detail.mode;
        name = $event.detail.name || '';
        username = $event.detail.username || '';
        role = $event.detail.role || 'staff';
        password = '';
        action = $event.detail.action || '{{ route('user.store') }}';
     ">
    <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6" x-text="mode === 'add' ? 'Tambah User Baru' : 'Edit User'"></h2>
    <form :action="action" method="POST" class="space-y-5">
        @csrf
        <template x-if="mode === 'edit'">
            <input type="hidden" name="_method" value="PUT">
        </template>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Nama Lengkap</label>
                <input type="text" name="name" x-model="name" required placeholder="Nama Lengkap User" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Username</label>
                <input type="text" name="username" x-model="username" required placeholder="Username" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Hak Akses (Role)</label>
                <div class="relative">
                    <select name="role" x-model="role" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="admin">ADMIN</option>
                        <option value="staff">STAFF</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">
                    Password <span x-show="mode === 'edit'" class="text-[9px] text-slate-400 font-semibold lowercase">(kosongkan jika tidak diubah)</span>
                </label>
                <input type="password" name="password" x-model="password" :required="mode === 'add'" placeholder="Minimal 8 Karakter" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
        </div>
        
        <div class="flex justify-end gap-3 pt-4">
            <button type="button" @click="showModal = false" class="px-8 py-2.5 bg-slate-100 text-slate-800 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">Batal</button>
            <button type="submit" class="px-8 py-2.5 bg-[#2d46b9] text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-200 hover:bg-blue-800 transition-all">Simpan</button>
        </div>
    </form>
</div>
@endsection
