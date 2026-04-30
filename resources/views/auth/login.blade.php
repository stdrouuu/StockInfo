@extends('layouts.app')

@section('title', 'Masuk - Toko Bangunan')

@section('content')
<main class="flex min-h-screen">
    <!-- Left Side: Hero Image (Industrial Aesthetic) -->
    <section class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-primary-container">
        <div class="absolute inset-0 z-10 bg-gradient-to-t from-primary/80 via-transparent to-primary/20"></div>
        <img
            alt="Industrial Warehouse Background"
            class="absolute inset-0 object-cover w-full h-full mix-blend-overlay grayscale opacity-60"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAK2J2QrH8LWvrdgsc4_70LICqXgHo1UUgYJKJf0PDDOFguZS4LnMGobbyEpRErpT90E_mZ4xhOBfNd6zNyuXKSC6xokmaJCS0m7DVSpzHUBBeGX5efVKqzf002A2-rJ_-OaA-Rr1VZnDbiGCE_CX9IQJuaKAC9FADxSzbop1tn0IEgptCTeGcypZ_xPWlIttxCO4h7OawiHcCGimk885M8fCCvIeeLHiaRzeoxdcRO1jmAQvmCnCiHsHjtz1nm17hmJICCNUZHQog"
        />
        <div class="relative z-20 flex flex-col justify-end p-16 w-full text-white">
            <div class="mb-8">
                <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-2 rounded-xl mb-6">
                    <span class="material-symbols-outlined text-primary-fixed">foundation</span>
                    <span class="font-headline font-bold tracking-tight text-primary-fixed">Toko Bangunan</span>
                </div>
                <h1 class="text-5xl font-extrabold leading-tight mb-4 tracking-tighter">
                    Solusi Manajemen <br />Material Terintegrasi.
                </h1>
                <p class="text-on-primary-container text-lg max-w-md font-medium leading-relaxed">
                    Kelola inventaris, pantau mutasi stok, dan optimalkan operasional
                    gudang Anda dengan presisi industrial.
                </p>
            </div>
            <div class="flex gap-8 pt-8 border-t border-white/10">
                <div>
                    <div class="text-3xl font-bold">100%</div>
                    <div class="text-sm text-on-primary-container uppercase tracking-widest font-bold">
                        Akurasi Stok
                    </div>
                </div>
                <div>
                    <div class="text-3xl font-bold">Real-time</div>
                    <div class="text-sm text-on-primary-container uppercase tracking-widest font-bold">
                        Pelaporan
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Right Side: Login Form -->
    <section class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-surface">
        <div class="max-w-md w-full">
            <!-- Mobile Branding (Hidden on Desktop) -->
            <div class="lg:hidden flex items-center gap-2 mb-12">
                <span class="material-symbols-outlined text-primary text-3xl">foundation</span>
                <span class="font-headline font-extrabold text-2xl tracking-tighter">Toko Bangunan</span>
            </div>

            <!-- Welcome Text -->
            <div class="mb-10">
                <h2 class="text-3xl font-extrabold text-on-surface tracking-tight mb-2">
                    Selamat Datang
                </h2>
                <p class="text-on-surface-variant font-medium">
                    Masuk untuk mengelola sistem operasional Mitra Bangunan.
                </p>
            </div>

            <!-- Session Status / Errors -->
            @if (session('status'))
                <div class="mb-4 p-4 rounded-xl bg-primary-fixed text-on-primary-fixed text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 rounded-xl bg-error-container text-on-error-container text-sm font-medium">
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
                    <label class="block text-sm font-bold text-on-surface uppercase tracking-wider">
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
                            <div class="w-full text-center py-3 px-2 rounded-xl border border-transparent bg-surface-container-high peer-checked:bg-primary-container peer-checked:text-white transition-all">
                                <span class="material-symbols-outlined block mb-1">admin_panel_settings</span>
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
                            <div class="w-full text-center py-3 px-2 rounded-xl border border-transparent bg-surface-container-high peer-checked:bg-primary-container peer-checked:text-white transition-all">
                                <span class="material-symbols-outlined block mb-1">inventory</span>
                                <span class="text-xs font-bold">Staff</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Username Input -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface uppercase tracking-wider" for="username">
                        Username
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">
                            person
                        </span>
                        <input
                            class="w-full pl-12 pr-4 py-4 bg-surface-container-highest border-none rounded-xl focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest text-on-surface transition-all"
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
                        <p class="text-error text-sm font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="block text-sm font-bold text-on-surface uppercase tracking-wider" for="password">
                            Kata Sandi
                        </label>
                        <a class="text-sm font-semibold text-primary hover:underline" href="#">
                            Lupa Sandi?
                        </a>
                    </div>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">
                            lock
                        </span>
                        <input
                            class="w-full pl-12 pr-12 py-4 bg-surface-container-highest border-none rounded-xl focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest text-on-surface transition-all"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            type="password"
                            required
                        />
                        <button
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-primary transition-colors"
                            type="button"
                            id="toggle-password"
                        >
                            <span class="material-symbols-outlined" id="password-icon">visibility</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-error text-sm font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input
                        class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary cursor-pointer"
                        id="remember"
                        name="remember"
                        type="checkbox"
                        {{ old('remember') ? 'checked' : '' }}
                    />
                    <label class="ml-3 text-sm font-medium text-on-surface-variant cursor-pointer select-none" for="remember">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <!-- Login Button -->
                <button
                    class="w-full py-4 bg-primary text-white font-headline font-bold text-lg rounded-xl shadow-lg shadow-primary/20 hover:bg-primary-container active:scale-[0.98] transition-all flex items-center justify-center gap-2"
                    type="submit"
                    id="login-button"
                >
                    Masuk ke Dashboard
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </form>

            <!-- Footer Links -->
            <div class="mt-12 pt-8 border-t border-outline-variant/30 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-sm text-on-surface-variant font-medium">
                    © {{ date('Y') }} Toko Bangunan Sistem.
                </p>
                <div class="flex gap-6">
                    <a class="text-sm font-bold text-on-surface-variant hover:text-primary transition-colors" href="#">
                        Bantuan
                    </a>
                    <a class="text-sm font-bold text-on-surface-variant hover:text-primary transition-colors" href="#">
                        Privasi
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Support Bubble -->
<div class="fixed bottom-6 right-6">
    <button
        class="bg-surface-container-lowest text-primary p-4 rounded-full shadow-xl flex items-center justify-center hover:bg-primary hover:text-white transition-all active:scale-90 border border-outline-variant/20"
        id="support-bubble"
    >
        <span class="material-symbols-outlined">support_agent</span>
    </button>
</div>
@endsection

@push('scripts')
<script>
    // Toggle password visibility
    document.getElementById('toggle-password')?.addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.textContent = 'visibility_off';
        } else {
            passwordInput.type = 'password';
            passwordIcon.textContent = 'visibility';
        }
    });
</script>
@endpush
