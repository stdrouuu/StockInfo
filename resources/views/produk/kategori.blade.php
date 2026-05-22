@extends('layouts.app')

@section('title', 'StockInfo - Kategori Produk')

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

    <div class="bg-[#3b59bc] rounded-3xl p-6 sm:p-8 text-white relative overflow-hidden shadow-xl shadow-blue-900/10">
        <div class="relative z-10 flex items-center gap-4 sm:gap-6">
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
        <div class="p-4 md:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <!-- Search Form -->
            <form method="GET" action="{{ route('kategori.index') }}" class="flex items-center gap-2 w-full sm:max-w-md">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Kategori Produk..." class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all" />
                </div>
                <button type="submit" class="bg-[#1e40af] hover:bg-blue-800 text-white px-5 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 transition-all">
                    <i class="fas fa-search"></i>
                    <span>Cari</span>
                </button>
            </form>
            <button @click="$dispatch('open-category-modal', { mode: 'add', action: '{{ route('kategori.store') }}' })" class="w-full sm:w-auto bg-[#1e40af] hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold flex items-center justify-center gap-2 shadow-lg shadow-blue-200 transition-all">
                <i class="fas fa-plus"></i>
                <span>Kategori Baru</span>
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
                    @forelse($kategoris as $index => $category)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-8 py-5 text-slate-400 text-sm font-medium">{{ str_pad($index + 1 + ($kategoris->currentPage() - 1) * $kategoris->perPage(), 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-8 py-5 text-center font-bold text-slate-700 text-sm">{{ $category->nama }}</td>
                        <td class="px-8 py-5">
                            <div class="flex justify-end gap-2.5">
                                <button @click="$dispatch('open-category-modal', {
                                    mode: 'edit',
                                    nama: '{{ $category->nama }}',
                                    action: '{{ route('kategori.update', $category->id) }}'
                                })" class="flex items-center justify-center p-1 text-slate-400 hover:text-blue-600 transition-all">
                                    <i class="far fa-edit text-sm"></i>
                                </button>
                                <button @click="showDeleteModal = true; deleteTarget = '{{ $category->nama }}'; deleteAction = '{{ route('kategori.destroy', $category->id) }}'" class="flex items-center justify-center p-1 text-slate-400 hover:text-red-600 transition-all">
                                    <i class="far fa-trash-alt text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-8 text-center text-slate-400 font-medium">Tidak ada kategori ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">
                Menampilkan {{ $kategoris->firstItem() ?? 0 }}-{{ $kategoris->lastItem() ?? 0 }} dari {{ $kategoris->total() }} Kategori
            </div>
            <div class="flex items-center gap-2">
                @if ($kategoris->onFirstPage())
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $kategoris->appends(request()->query())->previousPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Sebelumnya</a>
                @endif

                @if ($kategoris->hasMorePages())
                    <a href="{{ $kategoris->appends(request()->query())->nextPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Selanjutnya</a>
                @else
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Selanjutnya</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal-content')
<div x-show="modalType === 'add-category'"
     x-data="{ 
        mode: 'add',
        nama: '',
        action: '{{ route('kategori.store') }}'
     }"
     @open-category-modal.window="
        showModal = true;
        modalType = 'add-category';
        mode = $event.detail.mode;
        nama = $event.detail.nama || '';
        action = $event.detail.action || '{{ route('kategori.store') }}';
     ">
    <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6" x-text="mode === 'add' ? 'Tambah Kategori' : 'Edit Kategori'"></h2>
    <form :action="action" method="POST" class="space-y-5">
        @csrf
        <template x-if="mode === 'edit'">
            <input type="hidden" name="_method" value="PUT">
        </template>
        
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Nama Kategori</label>
            <input type="text" name="nama" x-model="nama" required placeholder="Masukkan nama kategori baru" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
        </div>
        <div class="flex justify-end gap-3 pt-4">
            <button type="button" @click="showModal = false" class="px-8 py-2.5 bg-slate-100 text-slate-800 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">Batal</button>
            <button type="submit" class="px-8 py-2.5 bg-[#2d46b9] text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-200 hover:bg-blue-800 transition-all">Simpan</button>
        </div>
    </form>
</div>
@endsection
