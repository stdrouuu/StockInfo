<aside class="w-64 bg-white border-r border-slate-200 flex flex-col fixed h-screen z-40 transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:z-20 lg:transform-none"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    <div class="p-6 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="bg-[#1e40af] p-2 rounded-lg text-white shadow-md shadow-blue-100">
                <i class="fas fa-warehouse text-xl"></i>
            </div>
            <div>
                <h1 class="font-extrabold text-lg leading-tight tracking-tight text-slate-800">StockInfo</h1>
                <p class="text-[10px] text-slate-400 uppercase tracking-[0.1em] font-bold">{{ auth()->user()->role }}</p>
            </div>
        </div>
        <button @click="sidebarOpen = false" class="lg:hidden w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>

    <nav class="flex-1 px-4 space-y-1 mt-4 overflow-y-auto hide-scrollbar flex flex-col" x-data="{ 
        activeMenu: '{{ (Request::segment(1) === 'produk' && Request::segment(2) === 'kategori') || request()->routeIs('kategori.*') ? 'kategori' : (Request::segment(1) ?: 'dashboard') }}',
        openSub: '{{ (Request::segment(1) === 'produk' && Request::segment(2) === 'kategori') || request()->routeIs('kategori.*') || Request::segment(1) === 'produk' ? 'produk' : (Request::segment(1) === 'stok-opname' ? 'stok-opname' : '') }}'
    }">
        <!-- Dashboard -->
        <a href="{{ route('dashboard.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group"
           :class="activeMenu === 'dashboard' ? 'bg-[#eff6ff] text-[#2563eb] shadow-sm' : 'text-slate-400 hover:bg-slate-50'">
            <i class="fas fa-th-large w-5 text-lg" :class="activeMenu === 'dashboard' ? 'text-[#2563eb]' : 'group-hover:text-slate-600'"></i>
            <span class="text-sm font-bold" :class="activeMenu === 'dashboard' ? '' : 'group-hover:text-slate-600'">Dashboard</span>
        </a>

        <!-- Data Produk -->
        <div class="space-y-1">
            <button @click="openSub = (openSub === 'produk' ? '' : 'produk')" 
               class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all group"
               :class="activeMenu === 'produk' || activeMenu === 'kategori' ? 'bg-[#eff6ff] text-[#2563eb]' : 'text-slate-400 hover:bg-slate-50'">
                <div class="flex items-center gap-3">
                    <i class="fas fa-box w-5 text-lg" :class="activeMenu === 'produk' || activeMenu === 'kategori' ? 'text-[#2563eb]' : 'group-hover:text-slate-600'"></i>
                    <span class="text-sm font-bold" :class="activeMenu === 'produk' || activeMenu === 'kategori' ? '' : 'group-hover:text-slate-600'">Produk</span>
                </div>
                <i class="fas fa-chevron-down text-[10px] transition-transform duration-200" :class="openSub === 'produk' ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="openSub === 'produk'" x-cloak class="pl-12 pr-4 space-y-1 pb-2">
                <a href="{{ route('produk.index') }}" class="block py-2 text-sm font-semibold transition-colors"
                   :class="activeMenu === 'produk' ? 'text-[#2563eb]' : 'text-slate-400 hover:text-slate-600'">Data Produk</a>
                <a href="{{ route('kategori.index') }}" class="block py-2 text-sm font-semibold transition-colors"
                   :class="activeMenu === 'kategori' ? 'text-[#2563eb]' : 'text-slate-400 hover:text-slate-600'">Kategori Produk</a>
            </div>
        </div>

        <!-- Transaksi -->
        <a href="{{ route('transaksi.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group"
           :class="activeMenu === 'transaksi' ? 'bg-[#eff6ff] text-[#2563eb]' : 'text-slate-400 hover:bg-slate-50'">
            <i class="fas fa-exchange-alt w-5 text-lg" :class="activeMenu === 'transaksi' ? 'text-[#2563eb]' : 'group-hover:text-slate-600'"></i>
            <span class="text-sm font-bold" :class="activeMenu === 'transaksi' ? '' : 'group-hover:text-slate-600'">Transaksi</span>
        </a>


        <!-- Supplier -->
        <a href="{{ route('supplier.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group"
           :class="activeMenu === 'supplier' ? 'bg-[#eff6ff] text-[#2563eb]' : 'text-slate-400 hover:bg-slate-50'">
            <i class="fas fa-user-friends w-5 text-lg" :class="activeMenu === 'supplier' ? 'text-[#2563eb]' : 'group-hover:text-slate-600'"></i>
            <span class="text-sm font-bold" :class="activeMenu === 'supplier' ? '' : 'group-hover:text-slate-600'">Supplier</span>
        </a>

        <!-- Proses -->
        <a href="{{ route('proses.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group"
           :class="activeMenu === 'proses' ? 'bg-[#eff6ff] text-[#2563eb]' : 'text-slate-400 hover:bg-slate-50'">
            <i class="fas fa-truck w-5 text-lg" :class="activeMenu === 'proses' ? 'text-[#2563eb]' : 'group-hover:text-slate-600'"></i>
            <span class="text-sm font-bold" :class="activeMenu === 'proses' ? '' : 'group-hover:text-slate-600'">Proses</span>
        </a>

        <!-- Stok Opname -->
        <div class="space-y-1">
            <button @click="openSub = (openSub === 'stok-opname' ? '' : 'stok-opname')" 
               class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all group"
               :class="activeMenu === 'stok-opname' ? 'bg-[#eff6ff] text-[#2563eb]' : 'text-slate-400 hover:bg-slate-50'">
                <div class="flex items-center gap-3">
                    <i class="fas fa-clipboard-check w-5 text-lg" :class="activeMenu === 'stok-opname' ? 'text-[#2563eb]' : 'group-hover:text-slate-600'"></i>
                    <span class="text-sm font-bold" :class="activeMenu === 'stok-opname' ? '' : 'group-hover:text-slate-600'">Stok Opname</span>
                </div>
                <i class="fas fa-chevron-down text-[10px] transition-transform duration-200" :class="openSub === 'stok-opname' ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="openSub === 'stok-opname'" x-cloak class="pl-12 pr-4 space-y-1 pb-2">
                <a href="{{ route('stok.opname1') }}" class="block py-2 text-sm font-semibold transition-colors"
                   :class="activeMenu === 'stok-opname' && !window.location.href.includes('input') && !window.location.href.includes('laporan') ? 'text-[#2563eb]' : 'text-slate-400 hover:text-slate-600'">Periode Opname</a>
                <a href="{{ route('stok.opname2') }}" class="block py-2 text-sm font-semibold transition-colors"
                   :class="window.location.href.includes('input') ? 'text-[#2563eb]' : 'text-slate-400 hover:text-slate-600'">Input Opname</a>
                <a href="{{ route('stok.opname3') }}" class="block py-2 text-sm font-semibold transition-colors"
                   :class="window.location.href.includes('laporan') ? 'text-[#2563eb]' : 'text-slate-400 hover:text-slate-600'">Laporan Opname</a>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
        <!-- Laporan -->
        <a href="{{ route('laporan.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group"
           :class="activeMenu === 'laporan' ? 'bg-[#eff6ff] text-[#2563eb] shadow-sm' : 'text-slate-400 hover:bg-slate-50'">
            <i class="fas fa-chart-bar w-5 text-lg" :class="activeMenu === 'laporan' ? 'text-[#2563eb]' : 'group-hover:text-slate-600'"></i>
            <span class="text-sm font-bold" :class="activeMenu === 'laporan' ? '' : 'group-hover:text-slate-600'">Laporan</span>
        </a>

        <!-- Manajemen User -->
        <a href="{{ route('user.index') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group"
           :class="activeMenu === 'user' ? 'bg-[#eff6ff] text-[#2563eb] shadow-sm' : 'text-slate-400 hover:bg-slate-50'">
            <i class="fas fa-users w-5 text-lg" :class="activeMenu === 'user' ? 'text-[#2563eb]' : 'group-hover:text-slate-600'"></i>
            <span class="text-sm font-bold" :class="activeMenu === 'user' ? '' : 'group-hover:text-slate-600'">Manajemen User</span>
        </a>
        @endif
    </nav>

    <div class="p-4 border-t border-slate-100">
        <button @click="showLogoutModal = true" class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-50 rounded-xl transition-all group">
            <i class="fas fa-sign-out-alt w-5 text-lg group-hover:text-red-600"></i>
            <span class="text-sm font-bold group-hover:text-red-600">Keluar Akun</span>
        </button>
    </div>
</aside>
