@extends('layouts.app')

@section('title', 'StockInfo - Data Produk')

@section('content')
<div class="space-y-8">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-emerald-50 text-emerald-700 text-sm font-semibold border border-emerald-200 flex items-center gap-3 shadow-sm">
            <i class="fas fa-check-circle text-emerald-500 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 rounded-xl bg-rose-50 text-rose-700 text-sm font-semibold border border-rose-200 space-y-2 shadow-sm">
            <div class="flex items-center gap-3 font-bold">
                <i class="fas fa-exclamation-circle text-rose-500 text-lg"></i>
                <span>Terjadi Kesalahan Validasi:</span>
            </div>
            <ul class="list-disc pl-8 space-y-1 font-medium text-xs">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Page Title Card -->
    <div class="bg-[#1e40af] rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-blue-900/10">
        <div class="relative z-10 flex items-center gap-6">
            <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-md">
                <i class="fas fa-box text-3xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Data Produk</h2>
                <div class="flex items-center gap-2 text-blue-100 text-xs mt-1">
                    <i class="fas fa-home"></i>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="font-bold uppercase tracking-wider">Produk</span>
                    <i class="fas fa-chevron-right text-[8px]"></i>
                    <span class="font-bold text-white uppercase tracking-wider">Data Produk</span>
                </div>
            </div>
        </div>
        <!-- Decorative Background Icon -->
        <i class="fas fa-box absolute -right-8 -bottom-10 text-[180px] opacity-10 rotate-12"></i>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                <i class="fas fa-boxes-stacked text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total SKU</p>
                <p class="text-2xl font-bold">{{ number_format($totalSKU, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600">
                <i class="fas fa-exclamation-triangle text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Stok Rendah</p>
                <p class="text-2xl font-bold">{{ $stokRendahCount }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600">
                <i class="fas fa-truck text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Dalam Proses</p>
                <p class="text-2xl font-bold">{{ $dalamTransit }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                <i class="fas fa-hand-holding-dollar text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nilai Inventaris</p>
                <p class="text-2xl font-bold">Rp {{ number_format($invValue, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden" x-data="{ openFilter: false, openKategori: false }">
        <!-- Table Toolbar -->
        <div class="p-4 md:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 flex-1 w-full">
                <!-- Search Form -->
                <form method="GET" action="{{ route('produk.index') }}" class="flex flex-row items-center gap-2 flex-1 w-full sm:max-w-md">
                    @if(request('filter'))
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                    @endif
                    @if(request('kategori_id'))
                        <input type="hidden" name="kategori_id" value="{{ request('kategori_id') }}">
                    @endif
                    <div class="relative flex-1">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari SKU atau Nama Produk..." class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    </div>
                    <button type="submit" class="bg-[#1e40af] hover:bg-blue-800 text-white px-5 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 transition-all">
                        <i class="fas fa-search"></i>
                        <span class="hidden sm:inline">Cari</span>
                    </button>
                </form>
                
                <!-- Category Filter Dropdown -->
                <div class="relative w-full sm:w-auto">
                    <button @click="openKategori = !openKategori" class="w-full sm:w-auto px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold flex items-center justify-between sm:justify-start gap-2 hover:bg-slate-100 transition-all">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-tags text-slate-400"></i>
                            @php
                                $selectedKategori = $kategoris->firstWhere('id', request('kategori_id'));
                            @endphp
                            @if($selectedKategori)
                                Kategori: {{ $selectedKategori->nama }}
                            @else
                                Semua Kategori
                            @endif
                        </span>
                        <i class="fas fa-chevron-down text-[10px] transition-transform" :class="openKategori ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openKategori" @click.away="openKategori = false" x-cloak class="absolute left-0 mt-2 w-full sm:w-60 bg-white border border-slate-100 rounded-2xl shadow-xl z-30 overflow-hidden max-h-60 overflow-y-auto">
                        <a href="{{ route('produk.index', ['search' => request('search'), 'filter' => request('filter')]) }}" class="block px-6 py-3 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors {{ !request('kategori_id') ? 'bg-blue-50 text-blue-600' : '' }}">Semua Kategori</a>
                        @foreach($kategoris as $kat)
                            <a href="{{ route('produk.index', ['search' => request('search'), 'filter' => request('filter'), 'kategori_id' => $kat->id]) }}" class="block px-6 py-3 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors {{ request('kategori_id') == $kat->id ? 'bg-blue-50 text-blue-600' : '' }}">{{ $kat->nama }}</a>
                        @endforeach
                    </div>
                </div>

                <!-- Filter Dropdown -->
                <div class="relative w-full sm:w-auto">
                    <button @click="openFilter = !openFilter" class="w-full sm:w-auto px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold flex items-center justify-between sm:justify-start gap-2 hover:bg-slate-100 transition-all">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-sort-amount-down text-slate-400"></i>
                            @if(request('filter') === 'tinggi_rendah')
                                Stok: Tinggi ke Rendah
                            @elseif(request('filter') === 'rendah_tinggi')
                                Stok: Rendah ke Tinggi
                            @elseif(request('filter') === 'kritis')
                                Stok: Kritis (Low)
                            @else
                                Urutkan Stok
                            @endif
                        </span>
                        <i class="fas fa-chevron-down text-[10px] transition-transform" :class="openFilter ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openFilter" @click.away="openFilter = false" x-cloak class="absolute left-0 mt-2 w-full sm:w-56 bg-white border border-slate-100 rounded-2xl shadow-xl z-30 overflow-hidden">
                        <a href="{{ route('produk.index', ['search' => request('search'), 'kategori_id' => request('kategori_id'), 'filter' => 'tinggi_rendah']) }}" class="block px-6 py-3 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors {{ request('filter') === 'tinggi_rendah' ? 'bg-blue-50 text-blue-600' : '' }}">Tinggi ke Rendah</a>
                        <a href="{{ route('produk.index', ['search' => request('search'), 'kategori_id' => request('kategori_id'), 'filter' => 'rendah_tinggi']) }}" class="block px-6 py-3 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors {{ request('filter') === 'rendah_tinggi' ? 'bg-blue-50 text-blue-600' : '' }}">Rendah ke Tinggi</a>
                        <a href="{{ route('produk.index', ['search' => request('search'), 'kategori_id' => request('kategori_id'), 'filter' => 'kritis']) }}" class="block px-6 py-3 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-colors {{ request('filter') === 'kritis' ? 'bg-blue-50 text-blue-600' : '' }}">Stok Rendah</a>
                        @if(request('filter'))
                            <div class="border-t border-slate-100">
                                <a href="{{ route('produk.index', ['search' => request('search'), 'kategori_id' => request('kategori_id')]) }}" class="block px-6 py-3 text-xs font-bold text-rose-500 hover:bg-rose-50 transition-colors">Reset Urutan</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            @if(auth()->user()->isAdmin())
            <button @click="$dispatch('open-product-modal', { mode: 'add', action: '{{ route('produk.store') }}' })" class="w-full md:w-auto bg-[#1e40af] hover:bg-blue-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold flex items-center justify-center gap-2 shadow-lg shadow-blue-200 transition-all">
                <i class="fas fa-plus"></i>
                <span>Produk Baru</span>
            </button>
            @endif
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-[#1e40af] text-white text-[10px] font-black uppercase tracking-widest text-left">
                        <th class="px-6 py-4 rounded-tl-2xl">No</th>
                        <th class="px-6 py-4">Gambar</th>
                        <th class="px-6 py-4">SKU</th>
                        <th class="px-6 py-4">Nama Produk</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Stok</th>
                        <th class="px-6 py-4">Harga</th>
                        @if(auth()->user()->isAdmin())
                        <th class="px-6 py-4 text-center rounded-tr-2xl">Aksi</th>
                        @else
                        <th class="rounded-tr-2xl"></th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($produks as $index => $produk)
                     <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-5 text-slate-400 text-sm">{{ str_pad($index + 1 + ($produks->currentPage() - 1) * $produks->perPage(), 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-5">
                            <div class="w-24 h-24 bg-slate-100 flex items-center justify-center overflow-hidden border border-slate-200 rounded-2xl shadow-sm flex-shrink-0 group relative cursor-pointer"
                                 @if ($produk->gambar)
                                 @click="$dispatch('open-image-modal', { url: '{{ asset('storage/' . $produk->gambar) }}', title: '{{ $produk->nama }}' })"
                                 title="Klik untuk memperbesar gambar"
                                 @endif>
                                @if ($produk->gambar)
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                    <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <i class="fas fa-search-plus text-white text-lg drop-shadow-md"></i>
                                    </div>
                                @else
                                    <i class="far fa-image text-slate-300 text-xl"></i>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-5 font-bold text-slate-700 text-sm">{{ $produk->sku }}</td>
                        <td class="px-6 py-5 text-sm font-bold text-slate-800">{{ $produk->nama }}</td>
                        <td class="px-6 py-5 text-sm text-slate-600 font-medium">{{ $produk->kategori->nama ?? 'Umum' }}</td>
                        <td class="px-6 py-5">
                            @if ($produk->isLowStock())
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-rose-600">{{ $produk->stok }}</span>
                                    <span class="px-2 py-0.5 bg-rose-50 text-rose-600 text-[9px] font-bold uppercase rounded">Low</span>
                                </div>
                            @else
                                <span class="text-sm font-bold text-slate-700">{{ $produk->stok }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-sm font-bold text-slate-700">Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        @if(auth()->user()->isAdmin())
                        <td class="px-6 py-5">
                            <div class="flex justify-center gap-2">
                                <button @click="$dispatch('open-product-modal', {
                                    mode: 'edit',
                                    id: '{{ $produk->id }}',
                                    nama: '{{ $produk->nama }}',
                                    sku: '{{ $produk->sku }}',
                                    kategori_id: '{{ $produk->kategori_id }}',
                                    stok: '{{ $produk->stok }}',
                                    harga: '{{ (int)$produk->harga }}',
                                    stok_minimum: '{{ $produk->stok_minimum }}',
                                    gambar: '{{ $produk->gambar }}',
                                    action: '{{ route('produk.update', $produk->id) }}'
                                })" class="p-2 text-slate-400 hover:text-blue-600 transition-colors">
                                    <i class="far fa-edit"></i>
                                </button>
                                <button @click="showDeleteModal = true; deleteTarget = '{{ $produk->nama }}'; deleteAction = '{{ route('produk.destroy', $produk->id) }}'" class="p-2 text-slate-400 hover:text-rose-600 transition-colors">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                        @else
                        <td></td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-slate-400 font-medium">Tidak ada produk ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider">
                Menampilkan {{ $produks->firstItem() ?? 0 }}-{{ $produks->lastItem() ?? 0 }} dari {{ $produks->total() }} Produk
            </div>
            <div class="flex items-center gap-2">
                @if ($produks->onFirstPage())
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $produks->appends(request()->query())->previousPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Sebelumnya</a>
                @endif

                @if ($produks->hasMorePages())
                    <a href="{{ $produks->appends(request()->query())->nextPageUrl() }}" class="px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">Selanjutnya</a>
                @else
                    <span class="px-4 py-2 border border-slate-100 rounded-xl text-xs font-bold text-slate-300 cursor-not-allowed">Selanjutnya</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal-content')
<div x-show="modalType === 'add-product'" 
     x-data="{ 
        mode: 'add',
        productId: '',
        nama: '',
        sku: '',
        kategori_id: '',
        stok: '',
        harga: '',
        stok_minimum: '',
        action: '{{ route('produk.store') }}',
        fileName: '',
        gambar: '',
        previewUrl: '',
        useCamera: false,
        cameraStream: null,
        existingSkus: window.existingSkus || [],

        init() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('open_add')) {
                const prefilledNama = urlParams.get('nama') || '';
                this.$nextTick(() => {
                    this.$dispatch('open-product-modal', { 
                        mode: 'add', 
                        action: '{{ route('produk.store') }}',
                        nama: prefilledNama 
                    });
                });
            }
        },

        isSkuDup() {
            if (!this.sku) return false;
            const cleanSku = this.sku.trim().toLowerCase();
            return this.existingSkus.some(item => 
                item.sku.trim().toLowerCase() === cleanSku && 
                item.id != this.productId
            );
        },
        
        async startCamera() {
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                console.warn('MediaDevices API not supported or insecure HTTP context, falling back to native capture');
                document.getElementById('camera-fallback-upload').click();
                return;
            }
            try {
                this.useCamera = true;
                const constraints = {
                    video: { facingMode: 'environment' }
                };
                this.cameraStream = await navigator.mediaDevices.getUserMedia(constraints);
                this.$nextTick(() => {
                    const videoEl = this.$refs.video;
                    if (videoEl) {
                        videoEl.srcObject = this.cameraStream;
                        videoEl.play();
                    }
                });
            } catch (err) {
                console.warn('Camera stream failed, falling back to native capture:', err);
                document.getElementById('camera-fallback-upload').click();
                this.useCamera = false;
            }
        },
        stopCamera() {
            if (this.cameraStream) {
                this.cameraStream.getTracks().forEach(track => track.stop());
                this.cameraStream = null;
            }
            this.useCamera = false;
        },
        capturePhoto() {
            if (!this.cameraStream) return;
            const videoEl = this.$refs.video;
            const canvas = document.createElement('canvas');
            canvas.width = videoEl.videoWidth || 640;
            canvas.height = videoEl.videoHeight || 480;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(videoEl, 0, 0, canvas.width, canvas.height);
            
            canvas.toBlob((blob) => {
                const file = new File([blob], 'camera_capture_' + Date.now() + '.jpg', { type: 'image/jpeg' });
                
                const inputEl = document.getElementById('file-upload');
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                inputEl.files = dataTransfer.files;
                
                this.fileName = file.name;
                this.previewUrl = URL.createObjectURL(file);
                this.stopCamera();
            }, 'image/jpeg', 0.9);
        },
        clearImage() {
            const inputEl = document.getElementById('file-upload');
            if (inputEl) inputEl.value = '';
            this.fileName = '';
            this.previewUrl = '';
        }
     }"
     @open-product-modal.window="
        showModal = true;
        modalType = 'add-product';
        mode = $event.detail.mode;
        productId = $event.detail.id || '';
        nama = $event.detail.nama || '';
        sku = $event.detail.sku || '';
        kategori_id = $event.detail.kategori_id || '';
        stok = $event.detail.mode === 'add' ? 0 : ($event.detail.stok || 0);
        harga = $event.detail.harga || '';
        stok_minimum = $event.detail.stok_minimum || '';
        action = $event.detail.action || '{{ route('produk.store') }}';
        fileName = '';
        gambar = $event.detail.gambar || '';
        previewUrl = gambar ? '/storage/' + gambar : '';
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
            cameraStream = null;
        }
        useCamera = false;
     ">
    <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6" x-text="mode === 'add' ? 'Tambah Produk Baru' : 'Edit Produk'"></h2>
    
    <form :action="action" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <template x-if="mode === 'edit'">
            <input type="hidden" name="_method" value="PUT">
        </template>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Nama Produk</label>
                <input type="text" name="nama" x-model="nama" required placeholder="Besi Beton Polos 10mm (12m)" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">No. SKU</label>
                <input type="text" name="sku" x-model="sku" required placeholder="ST-BPN-10-001" 
                       :class="isSkuDup() ? 'border-rose-300 focus:ring-rose-500 focus:border-rose-400 bg-rose-50/20 text-rose-700' : 'border-slate-200 focus:ring-blue-500 focus:border-blue-400'"
                       class="w-full px-4 py-3 bg-slate-50 border rounded-xl text-sm text-slate-600 focus:outline-none transition-all">
                <template x-if="isSkuDup()">
                    <p class="text-xs text-rose-600 font-semibold flex items-center gap-1.5 mt-1.5 animate-pulse">
                        <i class="fas fa-exclamation-circle text-rose-500"></i>
                        <span>No. SKU ini sudah pernah digunakan oleh produk lain!</span>
                    </p>
                </template>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Kategori</label>
                <div class="relative">
                    <select name="kategori_id" x-model="kategori_id" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Kategori...</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ strtoupper($kategori->nama) }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
                </div>
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Jumlah Produk (Stok)</label>
                <input type="number" name="stok" x-model="stok" readonly class="w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-sm text-slate-400 cursor-not-allowed focus:outline-none transition-all">
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Harga (Rp)</label>
                <input type="number" name="harga" x-model="harga" required placeholder="95000" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Jumlah Minimum Produk</label>
                <input type="number" name="stok_minimum" x-model="stok_minimum" required placeholder="50" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>

        </div>

        <!-- Live Camera Stream -->
        <div x-show="useCamera" class="relative bg-slate-900 rounded-2xl overflow-hidden p-2 flex flex-col items-center gap-3">
            <video x-ref="video" class="w-full h-48 bg-black rounded-xl object-cover" autoplay playsinline></video>
            <div class="flex gap-3">
                <button type="button" @click="stopCamera()" class="px-5 py-2 bg-rose-500 hover:bg-rose-600 text-white rounded-md text-xs font-bold flex items-center gap-2 transition-all">
                    <i class="fas fa-times"></i>
                    <span>Batal</span>
                </button>
                 <button type="button" @click="capturePhoto()" class="px-5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-md text-xs font-bold flex items-center gap-2 shadow-lg transition-all">
                    <i class="fas fa-camera"></i>
                    <span>Foto</span>
                </button>
            </div>
        </div>

        <!-- Image Upload and Preview Container -->
        <div x-show="!useCamera" class="space-y-2">
            <label class="text-[10px] font-black text-slate-800 uppercase tracking-wider">Foto Produk</label>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Upload/Camera Toggles -->
                <div class="space-y-3">
                    <input type="file" name="gambar" id="file-upload" class="hidden" accept="image/*" 
                           @change="
                               const file = $event.target.files[0];
                               if (file) {
                                   fileName = file.name;
                                   previewUrl = URL.createObjectURL(file);
                               } else {
                                   fileName = '';
                                   previewUrl = gambar ? '/storage/' + gambar : '';
                               }
                           ">
                    <!-- Native camera capture fallback for insecure HTTP / local wifi connections -->
                    <input type="file" id="camera-fallback-upload" class="hidden" accept="image/*" capture="environment" 
                           @change="
                               const file = $event.target.files[0];
                               if (file) {
                                   fileName = file.name;
                                   previewUrl = URL.createObjectURL(file);
                                   
                                   const inputEl = document.getElementById('file-upload');
                                   const dataTransfer = new DataTransfer();
                                   dataTransfer.items.add(file);
                                   inputEl.files = dataTransfer.files;
                               }
                           ">
                    <label for="file-upload" class="w-full h-24 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50 flex items-center justify-center flex-col gap-2 hover:bg-slate-100 transition-all cursor-pointer group">
                        <i class="far fa-image text-slate-400 text-xl group-hover:text-blue-500 transition-colors"></i>
                        <span class="text-[11px] font-semibold text-slate-500" x-text="fileName || 'Upload Image'">Upload Image</span>
                    </label>
                    
                    <button type="button" @click="startCamera()" class="w-full py-2 bg-slate-50 border border-slate-200 hover:bg-slate-100 rounded-xl text-xs font-bold text-slate-600 flex items-center justify-center gap-2 transition-all">
                        <i class="fas fa-camera text-slate-400"></i>
                        <span>Gunakan Kamera</span>
                    </button>
                </div>

                <!-- Preview Box -->
                <div class="relative w-full h-36 border border-slate-200 rounded-2xl bg-slate-50 flex items-center justify-center overflow-hidden">
                    <template x-if="previewUrl">
                        <div class="w-full h-full relative group">
                            <img :src="previewUrl" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button type="button" @click="clearImage()" class="p-2 bg-rose-500 hover:bg-rose-600 text-white rounded-full transition-colors shadow-lg">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                    <template x-if="!previewUrl">
                        <div class="flex flex-col items-center gap-1 text-slate-400">
                            <i class="far fa-image text-xl"></i>
                            <span class="text-[9px] font-bold uppercase tracking-wider">Belum Ada Gambar</span>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <button type="button" @click="showModal = false" class="px-8 py-2.5 bg-slate-100 text-slate-800 rounded-xl text-sm font-bold hover:bg-slate-200 transition-all">Batal</button>
            <button type="submit" 
                    :disabled="isSkuDup()"
                    :class="isSkuDup() ? 'opacity-50 cursor-not-allowed bg-rose-400 hover:bg-rose-400 shadow-none' : 'bg-[#2d46b9] hover:bg-blue-800 shadow-lg shadow-blue-200'"
                    class="px-8 py-2.5 text-white rounded-xl text-sm font-bold transition-all">Simpan</button>
        </div>
    </form>
</div>

<!-- Image Viewer Modal Popup -->
<div x-show="modalType === 'view-image'" 
     x-data="{ imageUrl: '', imageTitle: '' }"
     @open-image-modal.window="
        showModal = true;
        modalType = 'view-image';
        imageUrl = $event.detail.url;
        imageTitle = $event.detail.title;
     "
     x-cloak
     class="space-y-4">
    <div class="flex justify-between items-center pb-2 border-b border-slate-100">
        <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest" x-text="imageTitle"></h3>
        <button type="button" @click="showModal = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-400 hover:text-slate-600 hover:bg-slate-200 transition-colors">
            <i class="fas fa-times text-sm"></i>
        </button>
    </div>
    <div class="w-full flex items-center justify-center overflow-hidden bg-transparent">
        <img :src="imageUrl" class="w-full max-h-[75vh] object-contain rounded-2xl shadow-xl">
    </div>
    <div class="flex justify-end pt-2">
        <button type="button" @click="showModal = false" class="px-6 py-2 bg-slate-100 text-slate-800 rounded-xl text-xs font-bold hover:bg-slate-200 transition-all">Tutup</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.existingSkus = {!! $existingSkus->toJson() !!};
</script>
@endpush

