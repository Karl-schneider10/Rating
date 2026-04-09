@extends('layouts.app')

@section('title', 'Login Admin - Rating Kampus')

@section('content')
<style>
    /* ============================================ */
    /* DESAIN BARU 100% - TANPA MENGUBAH FUNGSI LOGIN */
    /* ============================================ */
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        font-family: 'Material Symbols Outlined';
        font-weight: normal;
        font-style: normal;
        font-size: 24px;
        line-height: 1;
        letter-spacing: normal;
        text-transform: none;
        display: inline-block;
        white-space: nowrap;
        word-wrap: normal;
        direction: ltr;
    }
    
    .glass-panel {
        background: rgba(248, 249, 250, 0.1);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }
    
    .card-shadow {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }
</style>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@700;800;900&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

<!-- Custom Tailwind Config -->
<script>
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "tertiary-fixed": "#8cf4e8",
                    "surface-tint": "#bb152c",
                    "surface-container-low": "#f3f4f5",
                    "on-secondary-fixed": "#001b3c",
                    "surface-container": "#edeeef",
                    "on-primary": "#ffffff",
                    "on-secondary-container": "#445a7f",
                    "inverse-primary": "#ffb3b1",
                    "secondary-container": "#bbd3fd",
                    "on-error": "#ffffff",
                    "error-container": "#ffdad6",
                    "background": "#f8f9fa",
                    "on-primary-container": "#fffbff",
                    "on-secondary": "#ffffff",
                    "primary-fixed": "#ffdad8",
                    "on-background": "#191c1d",
                    "on-tertiary-fixed": "#00201d",
                    "tertiary-container": "#008379",
                    "surface-bright": "#f8f9fa",
                    "tertiary-fixed-dim": "#6fd8cc",
                    "on-secondary-fixed-variant": "#30476a",
                    "on-primary-fixed": "#410007",
                    "outline-variant": "#e4bebc",
                    "surface-container-high": "#e7e8e9",
                    "primary-container": "#db313f",
                    "on-primary-fixed-variant": "#92001c",
                    "secondary": "#485f84",
                    "surface-variant": "#e1e3e4",
                    "primary-fixed-dim": "#ffb3b1",
                    "outline": "#8f6f6e",
                    "on-tertiary-fixed-variant": "#00504a",
                    "surface-dim": "#d9dadb",
                    "surface-container-lowest": "#ffffff",
                    "on-tertiary": "#ffffff",
                    "on-surface-variant": "#5b403f",
                    "tertiary": "#006860",
                    "secondary-fixed": "#d5e3ff",
                    "on-error-container": "#93000a",
                    "on-surface": "#191c1d",
                    "surface": "#f8f9fa",
                    "primary": "#b7102a",
                    "inverse-on-surface": "#f0f1f2",
                    "secondary-fixed-dim": "#b0c7f1",
                    "on-tertiary-container": "#f3fffc",
                    "error": "#ba1a1a",
                    "surface-container-highest": "#e1e3e4",
                    "inverse-surface": "#2e3132"
                },
                fontFamily: {
                    "headline": ["Epilogue"],
                    "body": ["Manrope"],
                    "label": ["Manrope"]
                },
                borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "2xl": "1.5rem", "3xl": "2.5rem", "full": "9999px"},
            },
        },
    }
</script>

<body class="bg-inverse-surface text-on-surface font-body selection:bg-primary-fixed selection:text-on-primary-fixed min-h-screen relative flex items-center justify-center p-4">
    
    <!-- Dark Dramatic Background Image -->
    <div class="fixed inset-0 z-0">
        <img alt="Atmospheric abstract 3D render" class="w-full h-full object-cover opacity-70" src="https://i.pinimg.com/736x/74/5a/56/745a56e332b720687285ff151be63571.jpg"/>
        <div class="absolute inset-0 bg-gradient-to-tr from-black via-transparent to-primary/20 opacity-60"></div>
    </div>

    <!-- Main Container Matching Layout Style -->
    <div class="relative z-10 w-full max-w-6xl flex flex-col md:flex-row bg-white rounded-3xl overflow-hidden card-shadow">
        
        <!-- Left Visual Side (Dark Panel) -->
        <section class="hidden lg:flex lg:w-1/2 relative bg-neutral-900 overflow-hidden m-4 rounded-2xl">
            <img alt="Selected Works Visual" class="absolute inset-0 w-full h-full object-cover opacity-80" src="https://i.pinimg.com/736x/74/5a/56/745a56e332b720687285ff151be63571.jpg"/>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/80"></div>
            <div class="relative w-full h-full p-12 flex flex-col justify-between">
                <div>
                    <span class="text-surface-bright/70 font-bold text-sm tracking-widest uppercase">Rating Kampus</span>
                </div>
                <div class="space-y-6">
                    <div class="glass-panel p-8 rounded-2xl border border-white/10">
                        <span class="text-primary-fixed text-xs font-bold uppercase tracking-[0.2em] mb-4 block">Admin Portal</span>
                        <h2 class="text-3xl font-headline font-extrabold text-surface-bright leading-tight mb-4">Selamat Datang Administrator</h2>
                        <p class="text-surface-variant/80 font-medium text-sm">Kelola data kampus, rating, dan review dengan aman dan nyaman.</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-primary font-bold">
                            <i class="fas fa-university"></i>
                        </div>
                        <div>
                            <p class="text-white text-sm font-bold">Rating Kampus</p>
                            <p class="text-white/50 text-xs">Platform Rating Kampus Terpercaya</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Functional Login Area (Form TETAP ASLI) -->
        <section class="w-full lg:w-1/2 flex flex-col items-center justify-center p-8 md:p-12 lg:p-16 bg-white">
            <div class="w-full max-w-sm">
                <!-- Branding -->
                <div class="flex justify-between items-center mb-16">
                    <h1 class="text-2xl font-black font-headline tracking-tighter text-on-surface">Rating Kampus</h1>
                    <button class="text-xs font-bold border border-outline-variant rounded-full px-4 py-1.5 hover:bg-surface-container-low transition-colors flex items-center gap-2">
                        <span>🇮🇩 ID</span>
                        <span class="material-symbols-outlined text-[14px]">expand_more</span>
                    </button>
                </div>
                
                <header class="mb-10 text-center">
                    <h2 class="text-5xl font-headline font-extrabold text-on-surface tracking-tight mb-3">Login Admin</h2>
                    <p class="text-on-surface-variant font-medium">Masuk ke dashboard administrator</p>
                </header>
                
                <!-- ========== FORM LOGIN ASLI - TIDAK DIUBAH ========== -->
                <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-6">
                    @csrf
                    
                    <!-- Email Field -->
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-widest px-1" for="email">
                            Alamat Email
                        </label>
                        <input class="w-full px-5 py-3.5 rounded-xl bg-surface-container-lowest border border-outline-variant/30 focus:border-primary focus:ring-1 focus:ring-primary/20 transition-all duration-300 text-on-surface placeholder:text-on-surface-variant/30 text-sm @error('email') border-red-500 @enderror" 
                               id="email" 
                               name="email" 
                               type="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus
                               placeholder="admin@ratingkampus.com">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Password Field -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center px-1">
                            <label class="block text-[10px] font-bold text-on-surface-variant uppercase tracking-widest" for="password">
                                Kata Sandi
                            </label>
                            @if (Route::has('password.request'))
                                <a class="text-[10px] font-bold text-primary hover:underline transition-all tracking-tight" href="{{ route('password.request') }}">
                                    Lupa password?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <input class="w-full px-5 py-3.5 rounded-xl bg-surface-container-lowest border border-outline-variant/30 focus:border-primary focus:ring-1 focus:ring-primary/20 transition-all duration-300 text-on-surface placeholder:text-on-surface-variant/30 text-sm @error('password') border-red-500 @enderror" 
                                   id="password" 
                                   name="password" 
                                   type="password" 
                                   required 
                                   placeholder="••••••••">
                            <button class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant/40 hover:text-on-surface" type="button" onclick="togglePassword()">
                                <span class="material-symbols-outlined text-[18px]" id="toggleIcon">visibility</span>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="rounded border-outline-variant/30 text-primary focus:ring-primary/20">
                            <span class="text-sm text-on-surface-variant">Ingat saya</span>
                        </label>
                    </div>
                    
                    <!-- Divider -->
                    <div class="relative my-8 flex items-center">
                        <div class="flex-grow h-[1px] bg-surface-container-highest/50"></div>
                        <span class="px-3 text-[10px] font-bold text-on-surface-variant/40 uppercase tracking-widest">atau</span>
                        <div class="flex-grow h-[1px] bg-surface-container-highest/50"></div>
                    </div>
                    
                    
                    <!-- Primary Action (Tombol Login ASLI) -->
                    <div class="pt-4">
                        <button class="w-full bg-gradient-to-r from-primary to-primary-container text-on-primary font-bold py-4 px-8 rounded-xl shadow-lg shadow-primary/20 hover:shadow-primary/30 hover:brightness-110 active:scale-95 transition-all duration-300 flex items-center justify-center gap-2 group" type="submit" id="loginBtn">
                            <span class="text-sm">Masuk ke Dashboard</span>
                            <span class="material-symbols-outlined text-[18px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </button>
                    </div>
                </form>
                
                <!-- Footer Links -->
                <footer class="mt-10 text-center">
                    <p class="text-xs text-on-surface-variant font-medium">
                        Tidak punya akun? 
                        <a class="text-primary font-bold hover:underline underline-offset-4" href="{{ route('home') }}">Kembali ke Beranda</a>
                    </p>
                    <div class="flex justify-center gap-6 mt-10 opacity-40">
                        <span class="material-symbols-outlined text-xl">public</span>
                        <span class="material-symbols-outlined text-xl">share</span>
                        <span class="material-symbols-outlined text-xl">group</span>
                        <span class="material-symbols-outlined text-xl">photo_camera</span>
                    </div>
                    <p class="text-xs text-on-surface-variant/40 mt-6">
                        © {{ date('Y') }} Rating Kampus. All rights reserved.
                    </p>
                </footer>
            </div>
        </section>
    </div>
    
    <!-- Subtle branding elements -->
    <div class="fixed bottom-6 right-6 pointer-events-none opacity-5 z-20">
        <span class="text-8xl font-black font-headline tracking-tighter leading-none select-none">RK</span>
    </div>
</body>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Toggle Password Visibility
    function togglePassword() {
        const password = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (password.type === 'password') {
            password.type = 'text';
            toggleIcon.textContent = 'visibility_off';
        } else {
            password.type = 'password';
            toggleIcon.textContent = 'visibility';
        }
    }

    // Form Submission with Loading State (TETAP ASLI)
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        if (!email || !password) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Email dan password harus diisi!',
                confirmButtonColor: '#b7102a',
                background: 'white'
            });
            return;
        }
        
        const btn = document.getElementById('loginBtn');
        btn.classList.add('opacity-70', 'cursor-not-allowed');
        btn.disabled = true;
        btn.innerHTML = '<span class="inline-block animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent mr-2"></span> Memproses...';
    });

    // Auto-fill demo credentials (Ctrl/Cmd + D)
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
            e.preventDefault();
            document.getElementById('email').value = 'admin@kampus.com';
            document.getElementById('password').value = 'password';
            
            Swal.fire({
                icon: 'success',
                title: 'Demo Credentials Filled!',
                text: 'Form telah diisi dengan data demo',
                timer: 2000,
                showConfirmButton: false,
                background: 'white'
            });
        }
    });

    // Prevent form resubmission on page refresh
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<!-- Auto-show notifikasi jika ada session -->
@if(session('message'))
<script>
    Swal.fire({
        icon: 'info',
        title: 'Informasi',
        text: '{{ session('message') }}',
        confirmButtonColor: '#b7102a',
        background: 'white'
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Login Gagal',
        text: '{{ session('error') }}',
        confirmButtonColor: '#b7102a',
        background: 'white'
    });
</script>
@endif

@if($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Login Gagal',
        text: 'Email atau password salah!',
        confirmButtonColor: '#b7102a',
        background: 'white'
    });
</script>
@endif
@endpush