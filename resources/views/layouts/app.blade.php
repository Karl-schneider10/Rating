<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Rating Layanan Kampus - Berikan penilaian Anda untuk meningkatkan kualitas layanan">
    <meta name="keywords" content="rating kampus, layanan kampus, penilaian akademik">
    <meta name="author" content="Rating Kampus">
    
    <title>@yield('title', 'Rating Kampus - Tingkatkan Kualitas Layanan Bersama')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Google Fonts - Plus Jakarta Sans (modern) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet">
    
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    
    <!-- Font Awesome 6 (opsional untuk fallback) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        body {
            background: #f9f9ff;
            min-height: 100vh;
        }
        
        /* Glass Navigation */
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0px 20px 40px rgba(21, 28, 39, 0.04);
        }
        
        /* Modern Link Style */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
            color: #64748b;
        }
        
        .nav-link:hover {
            color: #F45B26;
        }
        
        .nav-link.active {
            color: #F45B26;
            font-weight: 600;
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #F45B26;
            border-radius: 2px;
        }
        
        /* Alert Styles */
        .alert {
            animation: slideInDown 0.5s ease-out;
            border-radius: 1rem;
            border-left-width: 4px;
            box-shadow: 0px 20px 40px rgba(21, 28, 39, 0.04);
        }
        
        @keyframes slideInDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        /* User Avatar */
        .user-avatar {
            background: #F45B26;
            border: 2px solid white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .user-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(244, 91, 38, 0.3);
        }
        
        /* Logout Button */
        .logout-btn {
            background: rgba(244, 91, 38, 0.1);
            border: 1px solid rgba(244, 91, 38, 0.2);
            color: #F45B26;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: #F45B26;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(244, 91, 38, 0.3);
        }
        
        /* Main Container Animation */
        .main-container {
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Loading Animation */
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }
        
        .btn-loading::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #F45B26;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #d1430b;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-background text-on-surface antialiased">
    
    <!-- Modern Navigation - CampusPulse Style -->
    <nav class="glass-nav fixed top-0 w-full z-50">
        <div class="flex justify-between items-center px-8 h-16 w-full mx-auto max-w-[1440px]">
            <!-- Logo Area -->
            <div class="flex items-center gap-8">
                
                    <div class="w-9 h-9 bg-[#F45B26] rounded-xl flex items-center justify-center transform group-hover:scale-110 transition duration-300 shadow-md">
                        <span class="material-symbols-outlined text-white text-xl" style="font-variation-settings: 'FILL' 1;">home</span>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-[#F45B26]">My Rating</span>
                </a>
                
                
            </div>
            
            <!-- User Menu -->
            <div class="flex items-center gap-6">
                @auth
                    <div class="flex items-center gap-4">
                        <!-- User Info -->
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-slate-900 leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-slate-500 uppercase tracking-widest mt-1">{{ Auth::user()->email }}</p>
                        </div>
                        
                        <!-- Avatar -->
                        <div class="user-avatar w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        
                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}" class="inline" id="logout-form">
                            @csrf
                            <button type="button" onclick="confirmLogout()" 
                                    class="logout-btn px-4 py-2 rounded-full font-semibold text-sm flex items-center space-x-2 transition duration-300">
                                <span class="material-symbols-outlined text-sm">logout</span>
                                <span class="hidden md:inline">Keluar</span>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" 
                       class="bg-[#F45B26] hover:bg-[#d1430b] text-white px-5 py-2.5 rounded-full font-semibold flex items-center space-x-2 shadow-lg shadow-[#F45B26]/20 transition-all active:scale-[0.98]">
                        <span class="material-symbols-outlined text-sm">lock</span>
                        <span>Login Admin</span>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content with Top Padding for Fixed Nav -->
    <main class="pt-24 pb-16 px-8 max-w-[1440px] mx-auto main-container">
        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert bg-green-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-xl mb-6 flex items-center shadow-lg" role="alert">
                <div class="bg-green-500 rounded-full p-1.5 mr-4">
                    <span class="material-symbols-outlined text-white text-sm">check_circle</span>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-sm">Berhasil!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-xl mb-6 flex items-center shadow-lg" role="alert">
                <div class="bg-red-500 rounded-full p-1.5 mr-4">
                    <span class="material-symbols-outlined text-white text-sm">error</span>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-sm">Oops!</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert bg-blue-50 border-l-4 border-blue-500 text-blue-700 px-6 py-4 rounded-xl mb-6 flex items-center shadow-lg" role="alert">
                <div class="bg-blue-500 rounded-full p-1.5 mr-4">
                    <span class="material-symbols-outlined text-white text-sm">info</span>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-sm">Informasi</p>
                    <p class="text-sm">{{ session('info') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-blue-700 hover:text-blue-900">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 px-6 py-4 rounded-xl mb-6 shadow-lg">
                <div class="flex items-center mb-2">
                    <div class="bg-yellow-500 rounded-full p-1.5 mr-4">
                        <span class="material-symbols-outlined text-white text-sm">warning</span>
                    </div>
                    <p class="font-bold text-sm">Perhatikan!</p>
                </div>
                <ul class="list-disc list-inside ml-12 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Content Area -->
        @yield('content')
    </main>

    <!-- Simple Footer -->
    <footer class="text-center py-6 text-slate-400 text-xs border-t border-slate-100">
        <p>&copy; {{ date('Y') }} Rating Kampus. Bersama Tingkatkan Kualitas Layanan.</p>
    </footer>

    <!-- Scripts -->
    <script>
        // Confirmation logout with SweetAlert
        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#F45B26',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                background: 'white',
                customClass: {
                    popup: 'rounded-2xl shadow-2xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if(target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Loading state for form submission
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if(submitBtn && !submitBtn.classList.contains('btn-loading')) {
                    submitBtn.classList.add('btn-loading');
                    submitBtn.disabled = true;
                }
            });
        });

        // Auto-hide alerts after 5 seconds
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                if(alert && alert.parentElement) {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        if(alert.parentElement) alert.remove();
                    }, 500);
                }
            }, 5000);
        });
    </script>
    
    @stack('scripts')
</body>
</html>