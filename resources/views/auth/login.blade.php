@extends('layouts.app')

@section('title', 'Login Admin - Rating Kampus')

@section('content')
<style>
    .login-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: slideUp 0.6s ease-out;
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .input-group {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .input-group input {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        border: 2px solid #e2e8f0;
        border-radius: 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }
    
    .input-group input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }
    
    .input-group input.error {
        border-color: #f56565;
    }
    
    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        transition: all 0.3s ease;
        z-index: 10;
    }
    
    .input-group input:focus + .input-icon {
        color: #667eea;
    }
    
    .toggle-password {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #a0aec0;
        transition: all 0.3s ease;
        z-index: 10;
    }
    
    .toggle-password:hover {
        color: #667eea;
    }
    
    .login-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1rem;
        border-radius: 1rem;
        font-weight: 600;
        font-size: 1.1rem;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        border: none;
        width: 100%;
        cursor: pointer;
    }
    
    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.5);
    }
    
    .login-btn:active {
        transform: translateY(0);
    }
    
    .login-btn::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(30deg) translate(-20%, 0);
        transition: transform 0.5s ease;
    }
    
    .login-btn:hover::after {
        transform: rotate(30deg) translate(30%, -20%);
    }
    
    .login-btn.loading {
        pointer-events: none;
        opacity: 0.8;
    }
    
    .login-btn.loading span {
        opacity: 0;
    }
    
    .login-btn.loading::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 24px;
        height: 24px;
        margin: -12px 0 0 -12px;
        border: 3px solid white;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        z-index: 10;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    .floating-label {
        position: absolute;
        left: 3rem;
        top: 50%;
        transform: translateY(-50%);
        background: white;
        padding: 0 0.25rem;
        color: #a0aec0;
        transition: all 0.3s ease;
        pointer-events: none;
        font-size: 1rem;
    }
    
    .input-group input:focus ~ .floating-label,
    .input-group input:not(:placeholder-shown) ~ .floating-label {
        top: 0;
        transform: translateY(-50%) scale(0.85);
        color: #667eea;
        font-weight: 500;
    }
    
    .error-message {
        color: #f56565;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        padding-left: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        animation: shake 0.5s ease-in-out;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .remember-me {
        display: flex;
        align-items: center;
        margin: 1.5rem 0;
        cursor: pointer;
    }
    
    .remember-me input {
        width: 1.2rem;
        height: 1.2rem;
        margin-right: 0.75rem;
        cursor: pointer;
        accent-color: #667eea;
    }
    
    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 1.5rem 0;
        color: #a0aec0;
    }
    
    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .divider::before {
        margin-right: 1rem;
    }
    
    .divider::after {
        margin-left: 1rem;
    }
    
    .back-to-home {
        display: inline-flex;
        align-items: center;
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        margin-top: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .back-to-home:hover {
        color: #764ba2;
        transform: translateX(-5px);
    }
    
    .back-to-home i {
        margin-right: 0.5rem;
        transition: transform 0.3s ease;
    }
    
    .back-to-home:hover i {
        transform: translateX(-3px);
    }
    
    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .login-header .icon-wrapper {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7); }
        70% { box-shadow: 0 0 0 15px rgba(102, 126, 234, 0); }
        100% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0); }
    }
    
    .login-header h2 {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.5rem;
    }
    
    .login-header p {
        color: #718096;
        font-size: 0.95rem;
    }
    
    .info-badge {
        background: linear-gradient(135deg, #f6e05e 0%, #fbbf24 100%);
        color: #744210;
        padding: 0.75rem 1rem;
        border-radius: 1rem;
        margin-top: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.9rem;
        animation: slideInRight 0.6s ease-out 0.3s both;
    }
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Login Card -->
        <div class="login-card rounded-3xl shadow-2xl p-8">
            <!-- Header dengan Animasi -->
            <div class="login-header">
                <div class="icon-wrapper">
                    <i class="fas fa-user-shield text-white text-3xl"></i>
                </div>
                <h2>Selamat Datang Kembali</h2>
                <p>Silakan login untuk mengakses dashboard admin</p>
            </div>

            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                
                <!-- Email Field -->
                <div class="input-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" 
                           name="email" 
                           id="email"
                           value="{{ old('email') }}" 
                           required 
                           autofocus
                           placeholder=" "
                           class="@error('email') error @enderror">
                    <label for="email" class="floating-label">Alamat Email</label>
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <i class="fas fa-check-circle text-green-500 @if(!old('email') || $errors->has('email')) hidden @endif"></i>
                    </div>
                </div>
                @error('email')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </div>
                @enderror

                <!-- Password Field -->
                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" 
                           name="password" 
                           id="password"
                           required 
                           placeholder=" "
                           class="@error('email') error @enderror">
                    <label for="password" class="floating-label">Kata Sandi</label>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="text-sm text-gray-600">Ingat saya</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="text-sm text-purple-600 hover:text-purple-800 transition duration-300">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <button type="submit" class="login-btn mt-6" id="loginBtn">
                    <span>Masuk ke Dashboard</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </button>

                <!-- Divider -->
                <div class="divider">
                    <span>atau</span>
                </div>
                <!-- Back to Home -->
                <div class="text-center">
                    <a href="{{ route('home') }}" class="back-to-home">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </form>
        </div>

        <!-- Additional Info -->
        <div class="text-center mt-8 text-white/80 text-sm animate__animated animate__fadeInUp animate__delay-1s">
            <p>© {{ date('Y') }} Rating Kampus. All rights reserved.</p>
            <p class="mt-2">
                <i class="fas fa-shield-alt mr-1"></i>
                Aman dan Terpercaya
            </p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Toggle Password Visibility
    function togglePassword() {
        const password = document.getElementById('password');
        const toggleIcon = document.querySelector('.toggle-password');
        
        if (password.type === 'password') {
            password.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            password.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    // Form Submission with Loading State
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        if (!email || !password) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Email dan password harus diisi!',
                confirmButtonColor: '#667eea',
                background: 'white',
                backdrop: `rgba(102, 126, 234, 0.3)`
            });
            return;
        }
        
        const btn = document.getElementById('loginBtn');
        btn.classList.add('loading');
        btn.disabled = true;
    });

    // Auto-fill demo credentials (optional - untuk development)
    document.addEventListener('keydown', function(e) {
        // Press Ctrl/Cmd + D to fill demo credentials
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

    // Show/Hide validation icon
    document.getElementById('email').addEventListener('input', function() {
        const icon = this.nextElementSibling.nextElementSibling;
        if (this.value) {
            icon.classList.remove('hidden');
        } else {
            icon.classList.add('hidden');
        }
    });

    // Animasi floating label
    document.querySelectorAll('.input-group input').forEach(input => {
        // Set initial state jika ada value
        if (input.value) {
            input.classList.add('has-value');
        }
        
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });

    // Smooth scroll to error
    @error('email')
        document.getElementById('email').scrollIntoView({ 
            behavior: 'smooth', 
            block: 'center' 
        });
    @enderror

    // Prevent form resubmission on page refresh
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    // Add floating animation to icon wrapper
    setInterval(() => {
        const iconWrapper = document.querySelector('.icon-wrapper');
        if (iconWrapper) {
            iconWrapper.style.transform = 'scale(1.05)';
            setTimeout(() => {
                iconWrapper.style.transform = 'scale(1)';
            }, 200);
        }
    }, 3000);
</script>

<!-- SweetAlert2 untuk notifikasi yang lebih cantik -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Auto-show notifikasi jika ada session tertentu -->
@if(session('message'))
<script>
    Swal.fire({
        icon: 'info',
        title: 'Informasi',
        text: '{{ session('message') }}',
        confirmButtonColor: '#667eea',
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
        confirmButtonColor: '#667eea',
        background: 'white'
    });
</script>
@endif
@endpush