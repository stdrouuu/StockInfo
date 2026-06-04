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
    deleteTarget: '',
    deleteAction: '',
    sidebarOpen: false,
    showProfileModal: {{ session('password_success') || session('password_error') ? 'true' : 'false' }},
    showEmail: false
}">

    <div class="flex min-h-screen relative overflow-x-hidden">
        <!-- Backdrop Overlay (visible only on mobile/tablet when sidebar is open) -->
        <div x-show="sidebarOpen" 
             x-cloak 
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm z-30 lg:hidden transition-opacity duration-300"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 p-4 sm:p-6 lg:p-10 min-w-0 transition-all duration-300">
            <!-- Mobile Header Bar -->
            <div class="flex lg:hidden items-center justify-between bg-white border border-slate-200/60 px-4 py-3 rounded-2xl mb-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="w-10 h-10 flex items-center justify-center bg-[#eff6ff] text-[#1e40af] rounded-xl hover:bg-blue-100 transition-colors">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <span class="font-extrabold text-slate-800 tracking-tight text-base">StockInfo</span>
                </div>
                <div @click="showProfileModal = true; showEmail = false" class="flex items-center gap-3 cursor-pointer hover:opacity-80 transition-opacity">
                    <img src="{{ asset('storage/images/tokobangunan2.jpg') }}" class="w-8 h-8 rounded-lg shadow-sm border border-white object-cover">
                </div>
            </div>

            <!-- Top Header (Desktop) -->
            <div class="hidden lg:flex justify-between items-center mb-10">
               <div>
                    <!-- Date -->
                    <h2 class="text-sm font-bold text-slate-500 flex items-center gap-2">
                        <i class="far fa-calendar-alt text-slate-400"></i>
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                    </h2>
                </div>
                <div class="flex items-center gap-8">
                    <div @click="showProfileModal = true; showEmail = false" class="flex items-center gap-3 cursor-pointer hover:opacity-80 transition-opacity">
                        <div class="text-right">
                            <p class="text-sm font-extrabold text-slate-800">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ auth()->user()->role }}</p>
                        </div>
                        <img src="{{ asset('storage/images/tokobangunan2.jpg') }}" class="w-10 h-10 rounded-xl shadow-md border-2 border-white object-cover">
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
             :class="modalType === 'add-transaction' || modalType === 'add-proses' || modalType === 'view-image' ? 'max-w-4xl' : 'max-w-2xl'"
             class="bg-white w-full rounded-[32px] shadow-2xl flex flex-col max-h-[90vh] overflow-hidden transition-all duration-300"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
            
            <div class="p-6 sm:p-8 overflow-y-auto hide-scrollbar">
                @yield('modal-content')
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
                <form :action="deleteAction" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-3 bg-rose-500 text-white rounded-xl font-bold hover:bg-rose-600 shadow-lg shadow-rose-100 transition-all">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Profile Info Modal -->
    <div x-show="showProfileModal" 
         x-cloak
         class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm z-[55] flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
         
        <div @click.away="showProfileModal = false" 
             class="bg-white/95 backdrop-blur-md w-full max-w-md rounded-[2.5rem] shadow-[0_25px_60px_-15px_rgba(30,64,175,0.15)] border border-slate-100/80 overflow-hidden transition-all duration-300 relative"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">
             
            <!-- Close Button -->
            <button @click="showProfileModal = false" class="absolute top-6 right-6 w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-400 hover:text-slate-600 hover:bg-slate-200 transition-colors">
                <i class="fas fa-times text-sm"></i>
            </button>
            
            <!-- Modal Body -->
            <div class="p-8 text-center" x-data="{ editingPassword: {{ session('password_success') || session('password_error') ? 'true' : 'false' }} }">
                <!-- Session status for profile password update -->
                @if(session('password_success'))
                    <div class="mb-4 p-3.5 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl text-xs font-bold text-center">
                        {{ session('password_success') }}
                    </div>
                @endif
                @if(session('password_error'))
                    <div class="mb-4 p-3.5 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl text-xs font-bold text-center">
                        {{ session('password_error') }}
                    </div>
                @endif

                <!-- Avatar & Header info -->
                <div class="relative inline-block mb-4 mt-4">
                    <img src="{{ asset('storage/images/tokobangunan2.jpg') }}" class="w-24 h-24 rounded-[2rem] object-cover shadow-lg shadow-blue-200/50 border border-slate-100">
                    <span class="absolute bottom-0 right-0 w-5 h-5 bg-emerald-500 rounded-full border-4 border-white"></span>
                </div>
                
                <h3 class="text-2xl font-extrabold text-slate-800">{{ auth()->user()->name }}</h3>
                <div class="flex items-center justify-center gap-2 mt-1.5">
                    <span class="text-xs text-slate-400 font-extrabold uppercase tracking-widest">{{ auth()->user()->role }}</span>
                </div>
                
                <!-- Information Fields -->
                <div class="mt-8 space-y-4 text-left">
                    <div class="bg-slate-50/60 p-4 rounded-2xl border border-slate-100/50">
                        <label class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Nama Lengkap</label>
                        <p class="text-sm font-bold text-slate-700">{{ auth()->user()->name }}</p>
                    </div>

                    <div class="bg-slate-50/60 p-4 rounded-2xl border border-slate-100/50">
                        <label class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Username</label>
                        <p class="text-sm font-bold text-slate-700">{{ auth()->user()->username }}</p>
                    </div>
                    
                    <div class="bg-slate-50/60 p-4 rounded-2xl border border-slate-100/50">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Password</label>
                                <p x-show="!editingPassword" class="text-sm font-bold text-slate-700 tracking-wider">••••••••</p>
                            </div>
                            <button type="button" @click="editingPassword = !editingPassword" class="text-xs font-bold text-blue-600 hover:underline">
                                <span x-show="!editingPassword">Ubah</span>
                                <span x-show="editingPassword" x-cloak>Batal</span>
                            </button>
                        </div>
                        
                        <form x-show="editingPassword" x-cloak action="{{ route('profile.password.update') }}" method="POST" class="mt-3 space-y-3">
                            @csrf
                            @method('PUT')
                            <div class="space-y-1">
                                <label class="text-[8px] font-bold text-slate-400 uppercase tracking-wider block ml-1">Password Saat Ini</label>
                                <input type="password" name="current_password" required placeholder="Masukkan password saat ini" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs outline-none focus:ring-2 focus:ring-blue-500 font-medium text-slate-700">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[8px] font-bold text-slate-400 uppercase tracking-wider block ml-1">Password Baru</label>
                                <input type="password" name="password" required placeholder="Masukkan password baru" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs outline-none focus:ring-2 focus:ring-blue-500 font-medium text-slate-700">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[8px] font-bold text-slate-400 uppercase tracking-wider block ml-1">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" required placeholder="Ulangi password baru" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs outline-none focus:ring-2 focus:ring-blue-500 font-medium text-slate-700">
                            </div>
                            <button type="submit" class="w-full py-3 bg-[#1e40af] hover:bg-blue-800 text-white rounded-xl text-xs font-bold shadow-md shadow-blue-100 hover:shadow-lg transition-all mt-2 uppercase tracking-wider">
                                Simpan Password
                            </button>
                        </form>
                    </div>
                    
                    <div class="bg-slate-50/60 p-4 rounded-2xl border border-slate-100/50">
                        <label class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest block mb-1">Hak Akses</label>
                        <p class="text-sm font-bold text-slate-700 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stack('modals')
    @stack('scripts')
</body>
</html>