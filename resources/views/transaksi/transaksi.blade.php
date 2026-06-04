@extends('layouts.app')

@section('title', 'StockInfo - Data Transaksi Inventory')

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

    <!-- Header Section -->
    <div class="bg-[#064e3b] rounded-3xl p-6 sm:p-8 text-white relative overflow-hidden shadow-xl shadow-emerald-900/10">
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                    <i class="fas fa-exchange-alt text-3xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold">Transaksi Masuk & Keluar</h2>
                    <div class="flex items-center gap-2 text-emerald-100 text-xs mt-1">
                        <i class="fas fa-home"></i>
                        <i class="fas fa-chevron-right text-[8px]"></i>
                        <span class="font-bold text-white uppercase tracking-wider">Transaksi</span>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-4 w-full lg:w-auto">
                <button @click="showModal = true; modalType = 'add-transaction'" class="w-full lg:w-auto bg-[#10b981] hover:bg-emerald-400 text-white px-6 py-2.5 rounded-xl text-sm font-bold flex items-center justify-center gap-2 shadow-lg shadow-emerald-900/20 transition-all">
                    <i class="fas fa-plus text-xs"></i>
                    <span>TAMBAH TRANSAKSI</span>
                </button>
            </div>
        </div>
        
        <!-- Decorative Background Icon -->
        <i class="fas fa-exchange-alt absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12 pointer-events-none"></i>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5 group hover:border-emerald-200 transition-all">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <i class="fas fa-arrow-down text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Stok Masuk</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">{{ number_format($stockMasukCount, 0, ',', '.') }} <span class="text-xs font-bold text-slate-400">Items</span></h4>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5 group hover:border-rose-200 transition-all">
            <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <i class="fas fa-arrow-up text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Stok Keluar</p>
                <h4 class="text-2xl font-black text-slate-800 mt-1">{{ number_format($stockKeluarCount, 0, ',', '.') }} <span class="text-xs font-bold text-slate-400">Items</span></h4>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-[40px] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden" x-data="{ openFilter: false }">
        <!-- Filter Bar -->
        <div class="p-4 sm:p-8 border-b border-slate-50 flex flex-col xl:flex-row xl:items-center justify-between gap-6">
            <div class="flex flex-col lg:flex-row items-stretch lg:items-center gap-4 flex-1 w-full">
                <!-- Search Form -->
                <form method="GET" action="{{ route('transaksi.index') }}" class="flex items-center gap-3 flex-1 group w-full">
                    @if(request('filter'))
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                    @endif
                    <div class="relative flex-1 w-full">
                        <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode transaksi, tujuan, atau supplier..." class="w-full pl-12 pr-6 py-3.5 bg-slate-50 border-none rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-500 outline-none transition-all placeholder:text-slate-400">
                    </div>
                    <button type="submit" class="bg-[#064e3b] hover:bg-emerald-800 text-white px-6 py-3.5 rounded-2xl text-sm font-bold flex items-center gap-2 transition-all">
                        <i class="fas fa-search"></i>
                        <span>Cari</span>
                    </button>
                </form>
 
                <div class="flex bg-slate-50 p-1.5 rounded-2xl w-full lg:w-auto overflow-x-auto justify-start sm:justify-center">
                    <a href="{{ route('transaksi.index', ['search' => request('search'), 'filter' => 'Semua']) }}" class="flex-1 lg:flex-none text-center px-4 sm:px-6 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all {{ request('filter', 'Semua') === 'Semua' ? 'bg-white shadow-md text-blue-600' : 'text-slate-500 hover:text-slate-700' }}">Semua</a>
                    <a href="{{ route('transaksi.index', ['search' => request('search'), 'filter' => 'Masuk']) }}" class="flex-1 lg:flex-none text-center px-4 sm:px-6 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all {{ request('filter') === 'Masuk' ? 'bg-white shadow-md text-emerald-600' : 'text-slate-500 hover:text-slate-700' }}">Masuk</a>
                    <a href="{{ route('transaksi.index', ['search' => request('search'), 'filter' => 'Keluar']) }}" class="flex-1 lg:flex-none text-center px-4 sm:px-6 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all {{ request('filter') === 'Keluar' ? 'bg-white shadow-md text-rose-600' : 'text-slate-500 hover:text-slate-700' }}">Keluar</a>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-separate border-spacing-0">
                <thead>
                    <tr class="bg-[#2d46b9] text-white text-[10px] font-black uppercase tracking-[0.2em] text-left">
                        <th class="px-8 py-6 rounded-tl-2xl">No</th>
                        <th class="px-8 py-6">Kode Transaksi</th>
                        <th class="px-8 py-6 text-center">Tipe</th>
                        <th class="px-8 py-6">Asal / Tujuan</th>
                        <th class="px-8 py-6 text-center">Total Item</th>
                        <th class="px-8 py-6">Total Nilai</th>
                        <th class="px-8 py-6">Tanggal</th>
                        <th class="px-8 py-6">Keterangan</th>
                        <th class="px-8 py-6 text-center rounded-tr-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($transaksis as $index => $trx)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-7 text-sm font-bold text-slate-400">{{ str_pad($index + 1 + ($transaksis->currentPage() - 1) * $transaksis->perPage(), 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-8 py-7 text-sm font-black text-slate-800 group-hover:text-blue-600 transition-colors">
                            {{ $trx->kode }}
                        </td>
                        <td class="px-8 py-7 text-center">
                            <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ strtolower($trx->tipe) === 'masuk' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">{{ $trx->tipe }}</span>
                        </td>
                        <td class="px-8 py-7 text-sm font-semibold text-slate-600">
                            {{ strtolower($trx->tipe) === 'masuk' ? ($trx->supplier->nama ?? '-') : $trx->tujuan }}
                        </td>

                        {{-- untuk menampilkan produk apa aja yang masuk dan keluar di kolom total item pada transaksi  --}}
                        <td class="px-8 py-7 text-center text-sm">
                            <div x-data="{ open: false }" class="relative inline-block text-center">
                                <button @click="open = !open" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 hover:bg-slate-100 border border-slate-200/60 rounded-xl text-xs font-bold text-slate-700 transition-colors focus:outline-none">
                                    <span>{{ number_format($trx->total_qty, 0, ',', '.') }}</span>
                                    <i class="fas fa-info-circle text-slate-400 text-[10px]"></i>
                                </button>
                                <div x-show="open" 
                                     @click.away="open = false" 
                                     x-cloak 
                                     x-transition 
                                     class="absolute z-20 left-1/2 -translate-x-1/2 mt-2 w-72 bg-white border border-slate-200/80 rounded-2xl shadow-xl p-4 text-left">
                                    <div class="max-h-48 overflow-y-auto space-y-2.5 divide-y divide-slate-100 custom-scrollbar pr-1">
                                        @foreach($trx->items as $item)
                                            <div class="flex items-start justify-between gap-3 text-xs pt-2 first:pt-0">
                                                <div class="flex-1 min-w-0">
                                                    <span class="text-slate-700 font-bold block truncate" title="{{ $item->produk->nama ?? 'Produk Terhapus' }}">{{ $item->produk->nama ?? 'Produk Terhapus' }}</span>
                                                    <span class="text-[10px] text-slate-400 font-medium block mt-0.5">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="text-right shrink-0">
                                                    <span class="text-slate-800 font-black">{{ $item->qty }}</span>
                                                    <span class="text-[10px] text-slate-400 font-medium block mt-0.5">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-7 text-sm font-black text-slate-800">Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}</td>
                        <td class="px-8 py-7 text-sm font-medium text-slate-500">{{ $trx->tanggal->locale('id')->isoFormat('DD MMM YYYY') }}</td>
                        <td class="px-8 py-7 text-sm font-medium text-slate-500 max-w-xs truncate" title="{{ $trx->keterangan ?? '-' }}">
                            {{ $trx->keterangan ?? '-' }}
                        </td>
                        <td class="px-8 py-7">
                            <div class="flex items-center justify-center gap-2">
                                @if(strtolower($trx->tipe) === 'keluar')
                                <a href="{{ route('transaksi.cetak-surat-jalan', $trx->id) }}" target="_blank" title="Cetak Surat Jalan & Kirim" class="p-2 text-slate-400 hover:text-emerald-600 transition-colors">
                                    <i class="fas fa-shipping-fast"></i>
                                </a>
                                @else
                                <div class="w-8"></div> <!-- Spacer to keep all delete icons perfectly aligned vertically -->
                                @endif
                                @if(auth()->user()->isAdmin())
                                <button @click="showDeleteModal = true; deleteTarget = '{{ $trx->kode }}'; deleteAction = '{{ route('transaksi.destroy', $trx->id) }}'" class="p-2 text-slate-400 hover:text-rose-600 transition-colors" title="Hapus Transaksi">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-8 py-8 text-center text-slate-400 font-medium">Tidak ada transaksi ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-8 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left border-t border-slate-100">
            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                Menampilkan {{ $transaksis->firstItem() ?? 0 }}-{{ $transaksis->lastItem() ?? 0 }} dari {{ $transaksis->total() }} Transaksi
            </div>
            <div class="flex items-center gap-2">
                @if ($transaksis->onFirstPage())
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $transaksis->appends(request()->query())->previousPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Sebelumnya</a>
                @endif

                @if ($transaksis->hasMorePages())
                    <a href="{{ $transaksis->appends(request()->query())->nextPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Selanjutnya</a>
                @else
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Selanjutnya</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal-content')
<!-- Input Transaksi Modal -->
<div x-show="modalType === 'add-transaction'" x-data="transaksiModal">
    <div class="flex items-center justify-between mb-10">
        <div>
            <h2 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.25em] mb-1">Pencatatan Transaksi</h2>
            <h3 class="text-2xl font-extrabold text-slate-800" x-text="type === 'Masuk' ? 'Tambah Transaksi Masuk' : 'Tambah Transaksi Keluar'"></h3>
        </div>
    </div>

    <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-8">
        @csrf
        <input type="hidden" name="tipe" :value="type">
        
        <!-- Step 1: Basic Info -->
        <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div class="md:col-span-2">
                    <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1 mb-3">Tipe Transaksi</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="relative cursor-pointer group">
                            <input type="radio" value="Masuk" x-model="type" class="peer hidden">
                            <div class="flex items-center gap-4 px-6 py-4 rounded-2xl bg-slate-50 border-2 border-transparent peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all group-hover:bg-slate-100">
                                <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-emerald-600">
                                    <i class="fas fa-download"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-800">Barang Masuk</p>
                                </div>
                            </div>
                        </label>
                        <label class="relative cursor-pointer group">
                            <input type="radio" value="Keluar" x-model="type" class="peer hidden">
                            <div class="flex items-center gap-4 px-6 py-4 rounded-2xl bg-slate-50 border-2 border-transparent peer-checked:border-rose-500 peer-checked:bg-rose-50 transition-all group-hover:bg-slate-100">
                                <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-rose-600">
                                    <i class="fas fa-upload"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-800">Barang Keluar</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Tanggal Transaksi</label>
                    <input type="date" name="tanggal" x-model="tanggal" required class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
                
                <div class="space-y-2">
                    <!-- Dynamic Label based on transaction type -->
                    <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1" x-text="type === 'Masuk' ? 'Supplier / Pengirim' : 'Penerima / Proyek'"></label>
                    
                    <!-- Supplier select list if Masuk -->
                    <div x-show="type === 'Masuk'" class="flex items-center gap-3">
                        <div class="relative flex-1">
                            <select name="supplier_id" id="supplier_select" x-model="supplier_id" :required="type === 'Masuk'" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 outline-none transition-all appearance-none">
                                <option value="">Pilih Supplier...</option>
                                @foreach($suppliers as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->nama }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                        </div>
                        <button type="button" @click="openQuickAddSupplierModal()" class="w-[52px] h-[52px] flex items-center justify-center bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl transition-all shadow-md shadow-emerald-100 shrink-0" title="Tambah Supplier Baru">
                            <i class="fas fa-plus text-sm"></i>
                        </button>
                    </div>

                    <!-- Destination Text Input if Keluar -->
                    <div x-show="type === 'Keluar'" class="space-y-4">
                        <input type="text" name="tujuan" x-model="tujuan" :required="type === 'Keluar'" placeholder="Contoh: Proyek Bendungan A" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                        
                        <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Alamat (Khusus Proyek) </label>
                        <textarea name="alamat" x-model="alamat" :required="type === 'Keluar'" placeholder="Masukkan alamat lengkap pengiriman..." rows="2" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 outline-none transition-all resize-none"></textarea>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-2">
                    <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Keterangan (Opsional)</label>
                    <textarea name="keterangan" x-model="keterangan" placeholder="Catatan tambahan untuk transaksi ini..." rows="3" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 outline-none transition-all resize-none"></textarea>
                </div>
            </div>
        </div>

        <!-- Step 2: Items -->
        <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-6">
            <div class="flex items-center justify-between">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Daftar Barang</h4>
                <button type="button" @click="addItem()" class="text-[#2d46b9] hover:text-blue-800 text-xs font-black flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    TAMBAH BARANG
                </button>
            </div>

            <div class="space-y-4">
                <template x-for="(item, index) in items" :key="item.id">
                    <div class="p-5 rounded-2xl border border-slate-100 bg-slate-50/50 flex flex-col gap-4 relative group transition-all duration-300">
                        
                        <!-- Inputs Grid/Row -->
                        <div class="flex flex-col md:flex-row items-stretch md:items-end gap-4 w-full">
                            <!-- Searchable Dropdown -->
                            <div class="flex-1 min-w-[200px] relative" 
                                 x-data="{ 
                                    searchQuery: '', 
                                    openDropdown: false,
                                    init() {
                                        if (item.produk_id && productsList[item.produk_id]) {
                                            this.searchQuery = productsList[item.produk_id].nama;
                                        }
                                        this.$watch('item.produk_id', value => {
                                            if (!value) {
                                                this.searchQuery = '';
                                            } else if (productsList[value]) {
                                                this.searchQuery = productsList[value].nama;
                                            }
                                        });
                                    },
                                    get filteredProducts() {
                                        const all = Object.values(productsList);
                                        if (!this.searchQuery || (item.produk_id && productsList[item.produk_id] && this.searchQuery === productsList[item.produk_id].nama)) {
                                            return all;
                                        }
                                        const query = this.searchQuery.toLowerCase();
                                        return all.filter(p => p.nama.toLowerCase().includes(query));
                                    }
                                 }" 
                                 @click.away="openDropdown = false; if (!item.produk_id) { searchQuery = '' }">
                                 
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block ml-1">Nama Barang</label>
                                <input type="hidden" :name="'items[' + index + '][produk_id]'" x-model="item.produk_id" required>
                                
                                <div class="relative mt-2">
                                    <input type="text" 
                                           placeholder="Cari & Pilih Barang..." 
                                           class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-400 pr-10 transition-all"
                                           x-model="searchQuery"
                                           @focus="openDropdown = true"
                                           @input="openDropdown = true; item.produk_id = ''; item.price = 0"
                                           @keydown.escape="openDropdown = false"
                                           required>
                                           
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-1.5 text-slate-400">
                                        <template x-if="item.produk_id">
                                            <button type="button" @click="item.produk_id = ''; item.price = 0; searchQuery = ''; openDropdown = false" class="hover:text-rose-500 p-1 transition-colors">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        </template>
                                        <template x-if="!item.produk_id">
                                            <i class="fas fa-search text-xs"></i>
                                        </template>
                                    </div>
                                </div>
                                
                                <!-- Floating Dropdown Results -->
                                <div x-show="openDropdown" 
                                     x-cloak 
                                     class="absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-xl shadow-xl max-h-60 overflow-y-auto py-1.5 custom-scrollbar">
                                    <template x-for="p in filteredProducts" :key="p.id">
                                        <button type="button" 
                                                @click="item.produk_id = p.id; item.price = p.harga; searchQuery = p.nama; openDropdown = false; updatePrice(item)"
                                                class="w-full text-left px-4 py-2.5 hover:bg-slate-50 text-sm font-semibold flex items-center justify-between transition-colors border-b border-slate-50 last:border-0">
                                            <div class="truncate mr-2 flex-1 min-w-0">
                                                <span class="text-slate-800 font-bold block truncate" x-text="p.nama"></span>
                                                <span class="text-[10px] text-slate-400 block font-normal mt-0.5" x-text="'Harga: Rp ' + new Intl.NumberFormat('id-ID').format(p.harga)"></span>
                                            </div>
                                            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-lg shrink-0 ml-2" x-text="'Stok: ' + p.stok"></span>
                                        </button>
                                    </template>
                                    <template x-if="filteredProducts.length === 0">
                                        <div class="px-4 py-3 text-center text-slate-400 text-xs font-semibold">
                                            Barang tidak ditemukan...
                                        </div>
                                    </template>
                                </div>
                            </div>
                            
                            <!-- Qty -->
                            <div class="w-full md:w-24 shrink-0 space-y-2">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block ml-1">Qty</label>
                                <input type="number" 
                                       :name="'items[' + index + '][qty]'" 
                                       x-model="item.qty" 
                                       required 
                                       min="1" 
                                       :class="type === 'Keluar' && item.produk_id && productsList[item.produk_id] && parseInt(item.qty || 0) > productsList[item.produk_id].stok ? 'border-rose-300 focus:ring-rose-500 focus:border-rose-400 bg-rose-50/20 text-rose-700' : 'border-slate-200 focus:ring-blue-500 focus:border-blue-400'"
                                       class="w-full px-4 py-2.5 bg-white border rounded-xl text-sm font-semibold outline-none transition-all text-left md:text-center">
                            </div>
                            
                            <!-- Harga Satuan -->
                            <div class="w-full md:w-48 shrink-0 space-y-2">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block ml-1">Harga Satuan</label>
                                <div class="relative">
                                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">Rp</span>
                                    <input type="number" :name="'items[' + index + '][harga_satuan]'" x-model="item.price" required min="0" class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                </div>
                            </div>
                            
                            <!-- Action / Trash Button -->
                            <div class="flex items-center justify-end md:block shrink-0">
                                <button type="button" @click="removeItem(index)" class="w-full md:w-10 h-10 flex items-center justify-center gap-2 md:gap-0 rounded-xl bg-slate-100 hover:bg-rose-50 text-slate-400 hover:text-rose-500 border border-slate-200 md:border-transparent hover:border-rose-100 transition-all shadow-sm px-4 md:px-0 py-2 md:py-0">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                    <span class="text-xs font-bold md:hidden">Hapus Barang</span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Real-time Stock Check Alert (Outbound transactions only, inline document flow to push content down) -->
                        <template x-if="type === 'Keluar' && item.produk_id && productsList[item.produk_id] && parseInt(item.qty || 0) > productsList[item.produk_id].stok">
                            <div class="text-xs text-rose-600 font-bold flex items-center gap-2 bg-rose-50 p-3.5 rounded-xl border border-rose-100 w-full transition-all duration-300">
                                <i class="fas fa-exclamation-circle text-sm text-rose-500 shrink-0"></i>
                                <span>Stok tidak cukup! Stok tersedia saat ini hanya <span class="font-black text-rose-700" x-text="productsList[item.produk_id].stok"></span>.</span>
                            </div>
                        </template>
                    </div>
                </template>
            </div>

            <div class="p-6 bg-blue-50 rounded-2xl flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Estimasi Total</p>
                    <p class="text-xl font-black text-blue-600" x-text="formatRupiah(calculateTotal())"></p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Total Qty</p>
                    <p class="text-xl font-black text-blue-600" x-text="items.reduce((acc, curr) => acc + parseInt(curr.qty || 0), 0)"></p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-6 border-t border-slate-50">
            <button type="button" @click="showModal = false" class="px-8 py-4 text-slate-400 hover:text-slate-600 text-sm font-bold transition-colors">Batal</button>
            <div class="flex gap-3">
                <button type="button" x-show="step === 2" @click="step = 1" class="px-8 py-4 bg-slate-100 hover:bg-slate-200 text-slate-800 text-sm font-black rounded-2xl transition-all">Kembali</button>
                <button type="button" x-show="step === 1" @click="step = 2" class="px-10 py-4 bg-[#2d46b9] hover:bg-blue-800 text-white text-sm font-black rounded-2xl shadow-xl shadow-blue-200 transition-all flex items-center gap-3">
                    Lanjutkan
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </button>
                <button type="submit" 
                        x-show="step === 2" 
                        :disabled="hasInvalidStock()"
                        :class="hasInvalidStock() ? 'opacity-50 cursor-not-allowed bg-rose-400 hover:bg-rose-400 shadow-none' : 'bg-emerald-500 hover:bg-emerald-600 shadow-xl shadow-emerald-100'"
                        class="px-10 py-4 text-white text-sm font-black rounded-2xl transition-all">
                    Simpan Transaksi
                </button>
            </div>
        </div>
    </form>

    <!-- Quick Add Supplier Modal Overlay -->
    <div x-show="showQuickSupplierModal" 
         x-cloak
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-[3px] z-[80] flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div @click.away="showQuickSupplierModal = false" 
             class="bg-white w-full max-w-lg rounded-[28px] shadow-2xl flex flex-col max-h-[90vh] overflow-hidden transition-all duration-300 border border-slate-100"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            
            <div class="p-6 sm:p-8 overflow-y-auto hide-scrollbar">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Quick Add</h4>
                        <h3 class="text-xl font-extrabold text-slate-800">Tambah Supplier Baru</h3>
                    </div>
                    <button type="button" @click="showQuickSupplierModal = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div x-show="quickSupplierError" x-cloak class="mb-4 p-3 bg-rose-50 border border-rose-100 text-rose-600 rounded-xl text-xs font-bold" x-text="quickSupplierError"></div>

                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Nama Supplier</label>
                        <input type="text" x-model="quickSupplier.nama" required placeholder="Contoh: PT. Semen Berdikari" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Kontak Person</label>
                            <input type="text" x-model="quickSupplier.kontak_person" required placeholder="Contoh: Budi Santoso" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">No. Telepon</label>
                            <input type="text" x-model="quickSupplier.telepon" required placeholder="Contoh: 08123456789" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Email</label>
                        <input type="email" x-model="quickSupplier.email" required placeholder="Contoh: supplier@mail.com" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Alamat Lengkap</label>
                        <textarea x-model="quickSupplier.alamat" required placeholder="Masukkan alamat lengkap..." rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-emerald-500 outline-none transition-all resize-none"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-50">
                        <button type="button" @click="showQuickSupplierModal = false" class="px-6 py-3 text-slate-400 hover:text-slate-600 text-xs font-bold transition-colors">Batal</button>
                        <button type="button" @click="submitQuickSupplier()" :disabled="quickSupplierLoading" class="px-8 py-3 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-black rounded-xl shadow-lg shadow-emerald-100 transition-all">
                            Simpan Supplier
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('transaksiModal', () => ({
            step: 1,
            type: 'Masuk',
            tanggal: '{{ date("Y-m-d") }}',
            supplier_id: '',
            tujuan: '',
            alamat: '',
            keterangan: '',
            items: [{id: 1, produk_id: '', qty: 1, price: 0}],
            productsList: {!! $produks->mapWithKeys(fn($p) => [$p->id => ['id' => $p->id, 'nama' => $p->nama, 'harga' => (int)$p->harga, 'stok' => (int)$p->stok]])->toJson() !!},
            suppliersList: {!! $suppliers->map(fn($s) => ['id' => $s->id, 'nama' => $s->nama])->toJson() !!},
            
            showQuickSupplierModal: false,
            
            quickSupplier: {
                nama: '',
                kontak_person: '',
                telepon: '',
                email: '',
                alamat: ''
            },
            quickSupplierLoading: false,
            quickSupplierError: '',

            openQuickAddSupplierModal() {
                this.quickSupplier = { nama: '', kontak_person: '', telepon: '', email: '', alamat: '' };
                this.quickSupplierError = '';
                this.showQuickSupplierModal = true;
            },

            async submitQuickSupplier() {
                this.quickSupplierLoading = true;
                this.quickSupplierError = '';
                try {
                    const response = await fetch('{{ route("supplier.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.quickSupplier)
                    });
                    const result = await response.json();
                    if (response.ok && result.success) {
                        this.suppliersList.unshift(result.data);
                        
                        // Append option to select tag programmatically
                        const selectEl = document.getElementById('supplier_select');
                        if (selectEl) {
                            const opt = document.createElement('option');
                            opt.value = result.data.id;
                            opt.text = result.data.nama;
                            selectEl.add(opt);
                        }

                        this.supplier_id = result.data.id;
                        this.showQuickSupplierModal = false;
                    } else {
                        this.quickSupplierError = result.message || 'Gagal menambahkan supplier. Periksa inputan Anda.';
                        if (result.errors) {
                            this.quickSupplierError = Object.values(result.errors).flat().join(' ');
                        }
                    }
                } catch (e) {
                    this.quickSupplierError = 'Terjadi kesalahan sistem.';
                } finally {
                    this.quickSupplierLoading = false;
                }
            },

            addItem() {
                this.items.push({id: Date.now(), produk_id: '', qty: 1, price: 0});
            },
            removeItem(index) {
                if (this.items.length !== 1) this.items.splice(index, 1);
            },
            updatePrice(item) {
                if (item.produk_id && this.productsList[item.produk_id]) {
                    item.price = this.productsList[item.produk_id].harga;
                } else {
                    item.price = 0;
                }
            },
            calculateTotal() {
                return this.items.reduce((acc, curr) => acc + (parseInt(curr.qty || 0) * parseFloat(curr.price || 0)), 0);
            },
            hasInvalidStock() {
                if (this.type !== 'Keluar') return false;
                return this.items.some(item => {
                    if (!item.produk_id || !this.productsList[item.produk_id]) return false;
                    return parseInt(item.qty || 0) > this.productsList[item.produk_id].stok;
                });
            },
            formatRupiah(number) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
            }
        }));
    });
</script>
@endpush
