@extends('layouts.guest')

@section('title', 'Masuk - Toko Bangunan')

@section('content')
<main class="flex min-h-screen">
    <!-- Left Side: Hero Image (Industrial Aesthetic) -->
    <section class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-blue-900">
        <div class="absolute inset-0 z-10 bg-gradient-to-t from-blue-900/80 via-transparent to-blue-900/20"></div>
        <img
            alt="Industrial Warehouse Background"
            class="absolute inset-0 object-cover w-full h-full mix-blend-overlay grayscale opacity-60"
            src="{{ asset('storage/images/tokobangunan2.jpg') }}"
        />
        <div class="relative z-20 flex flex-col justify-end p-16 w-full text-white">
            <div class="mb-8">
                <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-xl mb-6">
                    <i class="fas fa-warehouse text-blue-400"></i>
                    <span class="font-bold tracking-tight text-blue-400">StockInfo</span>
                </div>
                <h1 class="text-5xl font-extrabold leading-tight mb-4 tracking-tighter">
                    Kelola Stok <br /> Jadi Lebih Mudah
                </h1>
                <p class="text-blue-100 text-lg max-w-md font-medium leading-relaxed">
                    Atur inventaris, pantau keluar-masuk barang, dan buat operasional gudang jadi lebih efisien secara real-time.
                </p>
            </div>
            <div class="flex gap-8 pt-8 border-t border-white/10">
            </div>
        </div>
    </section>

    <!-- Right Side: Login Form -->
    <section class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
        <div class="max-w-md w-full">
            <!-- Mobile Branding (Hidden on Desktop) -->
            <div class="lg:hidden flex items-center gap-2 mb-12">
                <i class="fas fa-warehouse text-blue-600 text-3xl"></i>
                <span class="font-extrabold text-2xl tracking-tighter text-slate-800">StockInfo</span>
            </div>

            <!-- Welcome Text -->
            <div class="mb-10">
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-2">
                    Selamat Datang
                </h2>
                <p class="text-slate-500 font-medium">
                    Masuk untuk mengelola sistem operasional Mitra Bangunan.
                </p>
            </div>

            <!-- Session Status / Errors -->
            @if (session('status'))
                <div class="mb-4 p-4 rounded-xl bg-blue-50 text-blue-700 text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 rounded-xl bg-red-50 text-red-700 text-sm font-medium">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Role Selection -->
                <div class="space-y-3">
                    <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider">
                        Pilih Peran
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative flex cursor-pointer group">
                            <input
                                {{ old('role', 'admin') === 'admin' ? 'checked' : '' }}
                                class="peer sr-only"
                                name="role"
                                type="radio"
                                value="admin"
                            />
                            <div class="w-full text-center py-3 px-2 rounded-xl border-2 border-slate-100 bg-slate-50 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition-all">
                                <i class="fas fa-user-shield block mb-1 text-xl"></i>
                                <span class="text-xs font-bold">Admin</span>
                            </div>
                        </label>
                        <label class="relative flex cursor-pointer group">
                            <input
                                {{ old('role') === 'staff' ? 'checked' : '' }}
                                class="peer sr-only"
                                name="role"
                                type="radio"
                                value="staff"
                            />
                            <div class="w-full text-center py-3 px-2 rounded-xl border-2 border-slate-100 bg-slate-50 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition-all">
                                <i class="fas fa-user-tie block mb-1 text-xl"></i>
                                <span class="text-xs font-bold">Staff</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Username Input -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider" for="username">
                        Username
                    </label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <input
                            class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white text-slate-700 transition-all outline-none"
                            id="username"
                            name="username"
                            placeholder="Masukkan username"
                            type="text"
                            value="{{ old('username') }}"
                            required
                            autofocus
                        />
                    </div>
                    @error('username')
                        <p class="text-red-600 text-sm font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="block text-sm font-bold text-slate-700 uppercase tracking-wider" for="password">
                            Password
                        </label>
                    </div>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <input
                            class="w-full pl-12 pr-12 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-600 focus:bg-white text-slate-700 transition-all outline-none"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            type="password"
                            required
                        />
                        <button
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600 transition-colors"
                            type="button"
                            id="toggle-password"
                        >
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-sm font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Login Button -->
                <button
                    class="w-full py-4 bg-blue-600 text-white font-bold text-lg rounded-xl shadow-lg shadow-blue-200 hover:bg-blue-700 active:scale-[0.98] transition-all flex items-center justify-center gap-2"
                    type="submit"
                    id="login-button"
                >
                    Masuk ke Dashboard
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <!-- Footer Links -->
            <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-sm text-slate-400 font-medium">
                    © {{ date('Y') }} StockInfo Sistem.
                </p>
                <div class="flex gap-6">
                </div>
            </div>
        </div>
    </section>
</main>

@endsection

@push('scripts')
<script>
    // Toggle password visibility
    document.getElementById('toggle-password')?.addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');
        if (passwordInput && passwordIcon) {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
    });
</script>
@endpush
