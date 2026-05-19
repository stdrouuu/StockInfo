@extends('layouts.app')

@section('title', 'StockInfo - Proses')

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
                <!-- Search Form -->
                <form method="GET" action="{{ route('proses.index') }}" class="relative flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Surat Jalan, Status, Kategori..." class="w-full px-5 py-3 bg-[#f1f5f9] border-none rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-slate-400">
                </form>
            </div>
            <button @click="$dispatch('open-proses-modal', { mode: 'add', action: '{{ route('proses.store') }}' })" class="bg-[#2d46b9] hover:bg-blue-800 text-white px-8 py-3 rounded-xl text-sm font-bold flex items-center gap-3 shadow-lg shadow-blue-200 transition-all">
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
                    @forelse($proses as $index => $row)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-8 text-sm font-bold text-slate-800">{{ str_pad($index + 1 + ($proses->currentPage() - 1) * $proses->perPage(), 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-8 text-sm text-slate-600 font-medium text-center">{{ $row->produk->nama ?? 'Tidak Ada' }}</td>
                        <td class="px-6 py-8 text-sm text-slate-600 font-medium text-center uppercase tracking-tight">{{ $row->no_surat_jalan }}</td>
                        <td class="px-6 py-8 text-sm font-semibold text-center">
                            @if($row->status === 'Completed')
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-bold uppercase">{{ $row->status }}</span>
                            @elseif($row->status === 'Pending')
                                <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-bold uppercase">{{ $row->status }}</span>
                            @else
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-bold uppercase">{{ $row->status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-8 text-center">
                            <span class="px-4 py-1.5 bg-[#f3e8ff] text-[#9333ea] text-[10px] font-black uppercase rounded-full">{{ $row->kategori_proses }}</span>
                        </td>
                        <td class="px-6 py-8">
                            <div class="flex justify-center gap-3">
                                <button @click="$dispatch('open-proses-modal', {
                                    mode: 'edit',
                                    produk_id: '{{ $row->produk_id }}',
                                    no_surat_jalan: '{{ $row->no_surat_jalan }}',
                                    status: '{{ $row->status }}',
                                    kategori_proses: '{{ $row->kategori_proses }}',
                                    keterangan: '{{ $row->keterangan }}',
                                    action: '{{ route('proses.update', $row->id) }}'
                                })" class="p-2 text-slate-400 hover:text-blue-600 transition-colors">
                                    <i class="far fa-edit text-sm"></i>
                                </button>
                                <button @click="showDeleteModal = true; deleteTarget = '{{ $row->no_surat_jalan }}'; deleteAction = '{{ route('proses.destroy', $row->id) }}'" class="p-2 text-slate-400 hover:text-red-600 transition-colors">
                                    <i class="far fa-trash-alt text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-400 font-medium">Tidak ada proses ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-6 flex items-center justify-between">
            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">
                Menampilkan {{ $proses->firstItem() ?? 0 }}-{{ $proses->lastItem() ?? 0 }} dari {{ $proses->total() }} Proses
            </div>
            <div class="flex items-center gap-2">
                @if ($proses->onFirstPage())
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $proses->appends(request()->query())->previousPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Sebelumnya</a>
                @endif

                @if ($proses->hasMorePages())
                    <a href="{{ $proses->appends(request()->query())->nextPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Selanjutnya</a>
                @else
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Selanjutnya</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal-content')
<div x-show="modalType === 'add-proses'"
     x-data="{ 
        mode: 'add',
        produk_id: '',
        no_surat_jalan: '',
        status: 'On-Going',
        kategori_proses: '',
        keterangan: '',
        action: '{{ route('proses.store') }}'
     }"
     @open-proses-modal.window="
        showModal = true;
        modalType = 'add-proses';
        mode = $event.detail.mode;
        produk_id = $event.detail.produk_id || '';
        no_surat_jalan = $event.detail.no_surat_jalan || '';
        status = $event.detail.status || 'On-Going';
        kategori_proses = $event.detail.kategori_proses || '';
        keterangan = $event.detail.keterangan || '';
        action = $event.detail.action || '{{ route('proses.store') }}';
     ">
    <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6" x-text="mode === 'add' ? 'Tambah Proses Baru' : 'Edit Proses'"></h2>
    <form :action="action" method="POST" class="space-y-5">
        @csrf
        <template x-if="mode === 'edit'">
            <input type="hidden" name="_method" value="PUT">
        </template>
        
        <div class="grid grid-cols-2 gap-5">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Nama Barang (Produk)</label>
                <div class="relative">
                    <select name="produk_id" x-model="produk_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Produk...</option>
                        @foreach ($produks as $produk)
                            <option value="{{ $produk->id }}">{{ $produk->nama }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">No. Surat Jalan</label>
                <input type="text" name="no_surat_jalan" x-model="no_surat_jalan" required placeholder="DO/2025/001" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Status</label>
                <div class="relative">
                    <select name="status" x-model="status" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="On-Going">On-Going</option>
                        <option value="Pending">Pending</option>
                        <option value="Completed">Completed</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Kategori Proses</label>
                <input type="text" name="kategori_proses" x-model="kategori_proses" required placeholder="Contoh: Construction" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
        </div>
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Keterangan</label>
            <textarea name="keterangan" x-model="keterangan" placeholder="Masukkan keterangan tambahan..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all resize-none" rows="3"></textarea>
        </div>
        <div class="flex justify-end gap-3 pt-4">
            <button type="button" @click="showModal = false" class="px-8 py-2.5 bg-slate-100 text-slate-800 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">Batal</button>
            <button type="submit" class="px-8 py-2.5 bg-[#2d46b9] text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-200 hover:bg-blue-800 transition-all">Simpan</button>
        </div>
    </form>
</div>
@endsection
