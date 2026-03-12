<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Rating Layanan Kampus - Berikan penilaian Anda untuk meningkatkan kualitas layanan">
    <meta name="keywords" content="rating kampus, layanan kampus, penilaian akademik">
    <meta name="author" content="Rating Kampus">
    
    <title>@yield('title', 'Rating Kampus - Tingkatkan Kualitas Layanan Bersama')</title>
    
    <!-- Tailwind CSS dengan custom colors -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Google Fonts - Poppins untuk tampilan modern -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Animate.css untuk animasi tambahan -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,170.7C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.1;
            pointer-events: none;
        }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .alert {
            animation: slideInDown 0.5s ease-out;
            border-radius: 15px;
            border-left-width: 4px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
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
        
        .floating-shape {
            position: fixed;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            pointer-events: none;
            z-index: -1;
        }
        
        .shape-1 {
            width: 300px;
            height: 300px;
            top: -150px;
            right: -150px;
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            animation: float 20s infinite;
        }
        
        .shape-2 {
            width: 200px;
            height: 200px;
            bottom: -100px;
            left: -100px;
            background: linear-gradient(45deg, #48dbfb, #1dd1a1);
            animation: float 15s infinite reverse;
        }
        
        .shape-3 {
            width: 150px;
            height: 150px;
            bottom: 50%;
            right: 10%;
            background: linear-gradient(45deg, #f368e0, #ff9ff3);
            animation: float 12s infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -50px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.5);
        }
        
        .btn-gradient::after {
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
        
        .btn-gradient:hover::after {
            transform: rotate(30deg) translate(30%, -20%);
        }
        
        .user-avatar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: 2px solid white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .user-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }
        
        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: rgba(255, 71, 87, 0.9);
            border-color: rgba(255, 71, 87, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 71, 87, 0.4);
        }
        
        .main-container {
            position: relative;
            z-index: 1;
            animation: fadeInUp 1s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Loading animation untuk button */
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.8;
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
    </style>
    
    @stack('styles')
</head>
<body class="antialiased">
    <!-- Floating Shapes untuk background effect -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>
    <div class="floating-shape shape-3"></div>
    
    <!-- Modern Navigation -->
    <nav class="glass-nav text-gray-800 p-4 sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo dengan animasi -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl flex items-center justify-center transform group-hover:rotate-12 transition duration-300">
                    <i class="fas fa-star text-white text-xl"></i>
                </div>
                <div>
                    <span class="text-2xl font-bold gradient-text">Rating Kampus</span>
                    <span class="block text-xs text-gray-500">Tingkatkan Kualitas Layanan</span>
                </div>
            </a>
            
            <!-- User Menu -->
            <div class="flex items-center space-x-4">
                @auth
                    <div class="flex items-center space-x-3">
                        <!-- User Info -->
                        <div class="text-right hidden md:block">
                            <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                        
                        <!-- Avatar dengan inisial -->
                        <div class="user-avatar w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        
                        <!-- Logout Button dengan konfirmasi -->
                        <form method="POST" action="{{ route('logout') }}" class="inline" id="logout-form">
                            @csrf
                            <button type="button" onclick="confirmLogout()" 
                                    class="logout-btn text-white px-5 py-2.5 rounded-xl font-semibold flex items-center space-x-2 transition duration-300">
                                <i class="fas fa-sign-out-alt"></i>
                                <span class="hidden md:inline">Keluar</span>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" 
                       class="btn-gradient text-white px-6 py-3 rounded-xl font-semibold flex items-center space-x-2 shadow-lg">
                        <i class="fas fa-lock"></i>
                        <span>Login Admin</span>
                        <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content dengan container yang lebih menarik -->
    <main class="container mx-auto px-4 py-8 main-container">
        <!-- Alert Messages dengan icon -->
        @if(session('success'))
            <div class="alert bg-green-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-xl mb-6 flex items-center shadow-lg" role="alert">
                <div class="bg-green-500 rounded-full p-2 mr-4">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-xl mb-6 flex items-center shadow-lg" role="alert">
                <div class="bg-red-500 rounded-full p-2 mr-4">
                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="font-bold">Oops!</p>
                    <p>{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert bg-blue-50 border-l-4 border-blue-500 text-blue-700 px-6 py-4 rounded-xl mb-6 flex items-center shadow-lg" role="alert">
                <div class="bg-blue-500 rounded-full p-2 mr-4">
                    <i class="fas fa-info-circle text-white text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="font-bold">Informasi</p>
                    <p>{{ session('info') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-blue-700 hover:text-blue-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 px-6 py-4 rounded-xl mb-6 shadow-lg">
                <div class="flex items-center mb-2">
                    <div class="bg-yellow-500 rounded-full p-2 mr-4">
                        <i class="fas fa-exclamation-circle text-white text-xl"></i>
                    </div>
                    <p class="font-bold">Perhatikan!</p>
                </div>
                <ul class="list-disc list-inside ml-14">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Content Area dengan efek fade -->
        <div class="animate__animated animate__fadeIn">
            @yield('content')
        </div>
    </main>

    <!-- Footer sederhana -->
    <footer class="text-center py-6 text-white/50 text-sm">
        <p>&copy; {{ date('Y') }} Rating Kampus. Bersama Tingkatkan Kualitas Layanan.</p>
    </footer>

    <!-- Scripts -->
    <script>
        // Fungsi konfirmasi logout dengan animasi
        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                background: 'white',
                backdrop: `rgba(102, 126, 234, 0.4)`,
                customClass: {
                    popup: 'rounded-2xl shadow-2xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        // Smooth scroll untuk anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Loading state untuk form submission
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if(submitBtn && !submitBtn.classList.contains('btn-loading')) {
                    submitBtn.classList.add('btn-loading');
                    submitBtn.disabled = true;
                }
            });
        });

        // Auto-hide alerts setelah 5 detik
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                if(alert) {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }
            }, 5000);
        });

        // Menambahkan efek parallax pada floating shapes
        document.addEventListener('mousemove', function(e) {
            const shapes = document.querySelectorAll('.floating-shape');
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;
            
            shapes.forEach((shape, index) => {
                const speed = (index + 1) * 20;
                const x = (mouseX * speed) - (speed / 2);
                const y = (mouseY * speed) - (speed / 2);
                shape.style.transform = `translate(${x}px, ${y}px)`;
            });
        });
    </script>

    <!-- SweetAlert2 untuk notifikasi yang lebih cantik -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @stack('scripts')
</body>
</html>