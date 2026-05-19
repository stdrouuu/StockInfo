@extends('layouts.app')

@section('title', 'StockInfo - Daftar Agen / Supplier')

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

    <div class="bg-[#a93cd4] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-purple-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-truck text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Daftar Agen & Supplier Toko</h2>
                <div class="flex items-center gap-2 text-purple-100 text-xs mt-1">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="font-bold text-white uppercase tracking-wider">AGEN / SUPPLIER</span>
                </div>
            </div>
        </div>
        <i class="fas fa-box-open absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6 space-y-6">
        <div class="flex items-center justify-between gap-4">
            <div class="flex flex-1 items-center gap-3 max-w-2xl">
                <!-- Search Form -->
                <form method="GET" action="{{ route('supplier.index') }}" class="relative flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama agen, sales, atau alamat..." class="w-full px-5 py-3 bg-[#f1f5f9] border-none rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-slate-400">
                </form>
            </div>
            <button @click="$dispatch('open-supplier-modal', { mode: 'add', action: '{{ route('supplier.store') }}' })" class="bg-[#1e40af] hover:bg-blue-800 text-white px-6 py-3 rounded-xl text-sm font-bold flex items-center gap-3 shadow-lg shadow-blue-200 transition-all">
                <i class="fas fa-user-plus"></i>
                + Tambah Agen Baru
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-[#2d46b9] text-white text-[10px] font-black uppercase tracking-widest text-left">
                        <th class="px-6 py-4 rounded-tl-2xl">No</th>
                        <th class="px-6 py-4">Nama Perusahaan / Agen</th>
                        <th class="px-6 py-4 text-center">Nama Sales (CP)</th>
                        <th class="px-6 py-4">No. WA / Telepon</th>
                        <th class="px-6 py-4">Alamat Agen</th>
                        <th class="px-6 py-4 text-center rounded-tr-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($suppliers as $index => $supplier)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-6 text-sm font-bold text-slate-800">{{ str_pad($index + 1 + ($suppliers->currentPage() - 1) * $suppliers->perPage(), 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-6 text-sm font-extrabold text-slate-800 uppercase tracking-tight">{!! nl2br(e($supplier->nama)) !!}</td>
                        <td class="px-6 py-6 text-sm text-slate-600 font-medium text-center leading-relaxed">{!! nl2br(e($supplier->kontak_person)) !!}</td>
                        <td class="px-6 py-6 text-sm text-slate-600 font-medium leading-relaxed">{{ $supplier->telepon }}</td>
                        <td class="px-6 py-6 text-sm text-slate-500 font-medium max-w-xs truncate" title="{{ $supplier->alamat }}">{{ $supplier->alamat }}</td>
                        <td class="px-6 py-8">
                            <div class="flex justify-center gap-3">
                                <button @click="$dispatch('open-supplier-modal', {
                                    mode: 'edit',
                                    id: '{{ $supplier->id }}',
                                    nama: '{{ $supplier->nama }}',
                                    kontak_person: '{{ $supplier->kontak_person }}',
                                    telepon: '{{ $supplier->telepon }}',
                                    email: '{{ $supplier->email }}',
                                    alamat: '{{ $supplier->alamat }}',
                                    action: '{{ route('supplier.update', $supplier->id) }}'
                                })" class="p-2 text-slate-400 hover:text-blue-600 transition-colors" title="Ubah data agen">
                                    <i class="far fa-edit text-sm"></i>
                                </button>
                                <button @click="showDeleteModal = true; deleteTarget = '{{ $supplier->nama }}'; deleteAction = '{{ route('supplier.destroy', $supplier->id) }}'" class="p-2 text-slate-400 hover:text-red-600 transition-colors" title="Hapus agen">
                                    <i class="far fa-trash-alt text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-400 font-medium">Belum ada agen terdaftar di toko.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-6 flex items-center justify-between">
            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">
                Menampilkan {{ $suppliers->firstItem() ?? 0 }}-{{ $suppliers->lastItem() ?? 0 }} dari {{ $suppliers->total() }} Supplier
            </div>
            <div class="flex items-center gap-2">
                @if ($suppliers->onFirstPage())
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $suppliers->appends(request()->query())->previousPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Sebelumnya</a>
                @endif

                @if ($suppliers->hasMorePages())
                    <a href="{{ $suppliers->appends(request()->query())->nextPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Selanjutnya</a>
                @else
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Selanjutnya</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal-content')
<div x-show="modalType === 'add-supplier'"
     x-data="{ 
        mode: 'add',
        nama: '',
        kontak_person: '',
        telepon: '',
        email: '',
        alamat: '',
        action: '{{ route('supplier.store') }}'
     }"
     @open-supplier-modal.window="
        showModal = true;
        modalType = 'add-supplier';
        mode = $event.detail.mode;
        nama = $event.detail.nama || '';
        kontak_person = $event.detail.kontak_person || '';
        telepon = $event.detail.telepon || '';
        email = $event.detail.email || '';
        alamat = $event.detail.alamat || '';
        action = $event.detail.action || '{{ route('supplier.store') }}';
     ">
    <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6" x-text="mode === 'add' ? 'Tambah Agen Baru Ke Toko' : 'Ubah Data Agen Toko'"></h2>
    <form :action="action" method="POST" class="space-y-5">
        @csrf
        <template x-if="mode === 'edit'">
            <input type="hidden" name="_method" value="PUT">
        </template>
        
        <div class="grid grid-cols-2 gap-5">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Nama Toko Agen / Perusahaan</label>
                <input type="text" name="nama" x-model="nama" required placeholder="Contoh: PT. Jaya Makmur Besi" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Nama Sales / Kontak Person</label>
                <input type="text" name="kontak_person" x-model="kontak_person" required placeholder="Contoh: Pak Eko (Sales)" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">No. Telepon / WhatsApp</label>
                <input type="text" name="telepon" x-model="telepon" required placeholder="Contoh: 08123456789" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Alamat Email (Boleh Kosong)</label>
                <input type="email" name="email" x-model="email" placeholder="Contoh: sales@jayamakmur.com" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
        </div>
        <div class="space-y-2">
            <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Alamat Lengkap Kantor / Toko</label>
            <textarea name="alamat" x-model="alamat" required placeholder="Masukkan alamat lengkap toko agen untuk mempermudah pemesanan..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all resize-none" rows="3"></textarea>
        </div>
        <div class="flex justify-end gap-3 pt-4">
            <button type="button" @click="showModal = false" class="px-8 py-2.5 bg-slate-100 text-slate-800 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">Batal</button>
            <button type="submit" class="px-8 py-2.5 bg-[#2d46b9] text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-200 hover:bg-blue-800 transition-all">Simpan Agen</button>
        </div>
    </form>
</div>
@endsection
