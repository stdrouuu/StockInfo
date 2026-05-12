<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'StockInfo - Admin Panel')</title>
    
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        [x-cloak] { display: none !important; }
        
        .modal-enter { opacity: 0; transform: scale(0.95); }
        .modal-enter-active { opacity: 1; transform: scale(1); transition: all 0.3s ease-out; }
        .modal-leave { opacity: 1; transform: scale(1); }
        .modal-leave-active { opacity: 0; transform: scale(0.95); transition: all 0.2s ease-in; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-700" x-data="{ 
    showModal: false, 
    modalType: '',
    showLogoutModal: false,
    showDeleteModal: false,
    deleteTarget: ''
}">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-10">
            <!-- Top Header -->
            <div class="flex justify-between items-center mb-10">
               <div>
    <!-- Date -->
    <h2 class="text-sm font-bold text-slate-500 flex items-center gap-2">
        <i class="far fa-calendar-alt text-slate-400"></i>
        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
    </h2>
</div>
                <div class="flex items-center gap-8">
                    <div class="relative cursor-pointer group">
                        <i class="far fa-bell text-xl text-slate-400 group-hover:text-slate-600 transition-colors"></i>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </div>
                    <div class="flex items-center gap-3 pl-6 border-l border-slate-100">
                        <div class="text-right">
                            <p class="text-sm font-extrabold text-slate-800">{{ session('user.name', 'Administrator') }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Admin</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(session('user.name', 'Administrator')) }}&background=1e40af&color=fff" class="w-10 h-10 rounded-xl shadow-md cursor-pointer border-2 border-white">
                    </div>
                </div>
            </div>

            @yield('content')
        </main>
    </div>

    <!-- Global Modal Container -->
    <div x-show="showModal" 
         x-cloak
         class="fixed inset-0 bg-black/40 backdrop-blur-[2px] z-50 flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div @click.away="showModal = false" 
             class="bg-white w-full max-w-2xl rounded-[32px] shadow-2xl overflow-hidden"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            
            <div class="p-8">
                @yield('modal-content')

                <!-- Global Processes Modals -->
                <div x-show="modalType === 'add-proses'">
                    <h2 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.25em] mb-10">Tambah & Edit Proses</h2>
                    <form class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Nama Barang</label>
                                <input type="text" placeholder="Besi & Baja" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">No Surat Jalan</label>
                                <input type="text" placeholder="DO/2025/001" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all uppercase">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Status</label>
                                <input type="text" placeholder="On-Going" class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block ml-1">Kategori</label>
                                <div class="relative">
                                    <select class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 font-medium appearance-none focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all">
                                        <option>Construction</option>
                                        <option>Raw Material</option>
                                        <option>Finishing</option>
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end gap-3 pt-4">
                            <button type="button" @click="showModal = false" class="px-10 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-800 text-sm font-bold rounded-xl transition-colors">Batal</button>
                            <button type="submit" class="px-10 py-3.5 bg-[#2d46b9] hover:bg-blue-800 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-200 transition-all">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div x-show="showLogoutModal" 
         x-cloak
         class="fixed inset-0 bg-black/40 backdrop-blur-[2px] z-[60] flex items-center justify-center p-4">
        <div @click.away="showLogoutModal = false" 
             class="bg-white w-full max-w-md rounded-[32px] shadow-2xl overflow-hidden p-8 text-center">
            <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-sign-out-alt text-red-500 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Keluar Akun?</h3>
            <p class="text-slate-500 text-sm mb-8">Apakah Anda yakin ingin keluar dari sistem StockInfo?</p>
            <div class="flex gap-3">
                <button @click="showLogoutModal = false" class="flex-1 py-3 bg-slate-100 text-slate-800 rounded-xl font-bold hover:bg-slate-200 transition-all">Batal</button>
                <form action="{{ route('logout') }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 shadow-lg shadow-red-100 transition-all">Keluar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" 
         x-cloak
         class="fixed inset-0 bg-black/40 backdrop-blur-[2px] z-[60] flex items-center justify-center p-4">
        <div @click.away="showDeleteModal = false" 
             class="bg-white w-full max-w-md rounded-[32px] shadow-2xl overflow-hidden p-8 text-center">
            <div class="w-20 h-20 bg-rose-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-trash-alt text-rose-500 text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Hapus Data?</h3>
            <p class="text-slate-500 text-sm mb-8">Apakah Anda yakin ingin menghapus data <span class="font-bold text-slate-800" x-text="deleteTarget"></span>? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-3">
                <button @click="showDeleteModal = false" class="flex-1 py-3 bg-slate-100 text-slate-800 rounded-xl font-bold hover:bg-slate-200 transition-all">Batal</button>
                <button @click="showDeleteModal = false" class="flex-1 py-3 bg-rose-500 text-white rounded-xl font-bold hover:bg-rose-600 shadow-lg shadow-rose-100 transition-all">Hapus</button>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
