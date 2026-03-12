@extends('layouts.app')

@section('title', 'Admin Dashboard - Rating Kampus')

@section('content')
<style>
    /* CSS yang sama persis seperti sebelumnya */
    .stat-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(45deg) translate(-20%, 0);
        transition: transform 0.6s ease;
    }
    
    .stat-card:hover::before {
        transform: rotate(45deg) translate(20%, 0);
    }
    
    .rating-item {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    
    .rating-item:hover {
        transform: translateX(5px);
        border-left-color: #667eea;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    .badge-rating-4 {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    }
    
    .badge-rating-3 {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    }
    
    .badge-rating-2 {
        background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
    }
    
    .badge-rating-1 {
        background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
    }
    
    .reply-form {
        animation: slideDown 0.3s ease-out;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .admin-reply {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        border-left: 4px solid #667eea;
        animation: fadeIn 0.5s ease-out;
    }
    
    .filter-btn {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .filter-btn::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    
    .filter-btn:hover::after,
    .filter-btn.active::after {
        transform: scaleX(1);
    }
    
    .filter-btn.active {
        color: #667eea;
        font-weight: 600;
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        backdrop-filter: blur(5px);
    }
    
    .rating-progress {
        height: 8px;
        border-radius: 4px;
        background: #e2e8f0;
        overflow: hidden;
    }
    
    .rating-progress-bar {
        height: 100%;
        border-radius: 4px;
        transition: width 0.3s ease;
    }
    
    .quick-action {
        background: white;
        border-radius: 15px;
        padding: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid transparent;
    }
    
    .quick-action:hover {
        border-color: #667eea;
        transform: translateY(-3px);
        box-shadow: 0 15px 20px -10px rgba(102, 126, 234, 0.4);
    }
    
    /* Style SIMPLE untuk real-time clock */
    #realtime-clock-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 15px 25px;
        border-radius: 50px;
        display: inline-block;
        margin-top: 15px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }
    
    #realtime-clock {
        font-family: 'Courier New', monospace;
        font-size: 2.5rem;
        font-weight: bold;
        color: white;
        text-shadow: 0 0 10px rgba(255,255,255,0.5);
        letter-spacing: 5px;
    }
    
    #realtime-date {
        color: rgba(255,255,255,0.9);
        font-size: 1rem;
        margin-top: 5px;
    }
    
    .live-badge {
        background: #ff4444;
        color: white;
        padding: 5px 15px;
        border-radius: 30px;
        font-size: 0.9rem;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-left: 15px;
        animation: blink 1s infinite;
    }
    
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>

<!-- Header Dashboard -->
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                Dashboard Admin
            </h1>
            <p class="text-gray-600 mt-1">Kelola dan pantau semua rating layanan kampus</p>
            
            <!-- REAL TIME CLOCK - VERSION SEDERHANA TAPI PASTI JALAN -->
            <div id="realtime-clock-container">
                <div style="display: flex; align-items: center; gap: 20px;">
                    <div>
                        <div id="realtime-clock">--:--:--</div>
                        <div id="realtime-date">--, -- --- ----</div>
                    </div>
                    <div class="live-badge">
                        <i class="fas fa-circle"></i>
                        <span>LIVE</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.units') }}" 
               class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-xl font-semibold flex items-center space-x-2 shadow-lg hover:shadow-xl transition duration-300">
                <i class="fas fa-building"></i>
                <span>Kelola Unit & Pelayanan</span>
                <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>
    </div>
</div>

<!-- Statistik Cards dengan Desain Modern -->
@php
    // Set timezone ke WIB untuk semua operasi tanggal
    Carbon\Carbon::setLocale('id');
    
    // Hitung rating counts sekali untuk digunakan di beberapa tempat
    $ratingCounts = [
        4 => $ratings->where('rating', 4)->count(),
        3 => $ratings->where('rating', 3)->count(),
        2 => $ratings->where('rating', 2)->count(),
        1 => $ratings->where('rating', 1)->count(),
    ];
    
    // Cari rating tertinggi (bukan hanya bintang 4)
    $highestRating = 0;
    $highestRatingCount = 0;
    foreach([4,3,2,1] as $star) {
        if($ratingCounts[$star] > $highestRatingCount) {
            $highestRatingCount = $ratingCounts[$star];
            $highestRating = $star;
        }
    }
    
    $totalRatingsCount = array_sum($ratingCounts);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Rating Card -->
    <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-semibold uppercase tracking-wider">Total Rating</p>
                <h3 class="text-4xl font-bold mt-2">{{ $totalRatings }}</h3>
                <p class="text-blue-200 text-sm mt-2 flex items-center">
                    <i class="fas fa-arrow-up mr-1"></i>
                    {{ $ratings->total() }} tampil
                </p>
            </div>
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
        </div>
    </div>
    
    <!-- Rata-rata Rating Card -->
    <div class="stat-card bg-gradient-to-br from-green-500 to-green-600 text-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-semibold uppercase tracking-wider">Rata-rata Rating</p>
                <h3 class="text-4xl font-bold mt-2">{{ number_format($averageRating, 1) }}</h3>
                <p class="text-green-200 text-sm mt-2 flex items-center">
                    <i class="fas fa-chart-line mr-1"></i>
                    dari maksimal 4.0
                </p>
            </div>
            <div class="stat-icon">
                <i class="fas fa-chart-bar"></i>
            </div>
        </div>
    </div>
    
    <!-- Total Unit Card -->
    <div class="stat-card bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-semibold uppercase tracking-wider">Total Unit</p>
                <h3 class="text-4xl font-bold mt-2">{{ $totalUnits ?? $ratings->groupBy('unit_id')->count() }}</h3>
                <p class="text-purple-200 text-sm mt-2 flex items-center">
                    <i class="fas fa-building mr-1"></i>
                    unit layanan
                </p>
            </div>
            <div class="stat-icon">
                <i class="fas fa-building"></i>
            </div>
        </div>
    </div>
    
    <!-- Rating Tertinggi Card -->
    <div class="stat-card bg-gradient-to-br from-yellow-500 to-yellow-600 text-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-100 text-sm font-semibold uppercase tracking-wider">Rating Tertinggi</p>
                <h3 class="text-4xl font-bold mt-2">{{ $highestRating }} ★</h3>
                <p class="text-yellow-200 text-sm mt-2 flex items-center">
                    <i class="fas fa-star mr-1"></i>
                    {{ $highestRatingCount }} rating
                </p>
            </div>
            <div class="stat-icon">
                <i class="fas fa-crown"></i>
            </div>
        </div>
    </div>
</div>

<!-- Distribusi Rating -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Grafik Distribusi -->
    <div class="bg-white rounded-2xl shadow-lg p-6 lg:col-span-1">
        <h3 class="text-lg font-semibold mb-4 flex items-center">
            <i class="fas fa-chart-pie text-purple-600 mr-2"></i>
            Distribusi Rating
        </h3>
        
        @foreach([4,3,2,1] as $star)
        <div class="mb-4">
            <div class="flex items-center justify-between mb-1">
                <div class="flex items-center">
                    <span class="text-yellow-400 mr-2">{{ $star }} ★</span>
                    <span class="text-sm text-gray-600">{{ $ratingCounts[$star] }} rating</span>
                </div>
                <span class="text-sm font-semibold text-gray-700">
                    {{ $totalRatingsCount > 0 ? round(($ratingCounts[$star] / $totalRatingsCount) * 100) : 0 }}%
                </span>
            </div>
            <div class="rating-progress">
                <div class="rating-progress-bar bg-gradient-to-r from-yellow-400 to-yellow-500" 
                     style="width: {{ $totalRatingsCount > 0 ? ($ratingCounts[$star] / $totalRatingsCount) * 100 : 0 }}%"></div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-lg p-6 lg:col-span-2">
        <h3 class="text-lg font-semibold mb-4 flex items-center">
            <i class="fas fa-bolt text-yellow-500 mr-2"></i>
            Aksi Cepat
        </h3>
        
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <div class="quick-action text-center" onclick="window.location.href='{{ route('admin.units') }}'">
                <div class="bg-purple-100 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <i class="fas fa-building text-purple-600 text-xl"></i>
                </div>
                <span class="text-sm font-semibold text-gray-700">Kelola Unit</span>
            </div>
            
            <div class="quick-action text-center" onclick="window.location.href='#latest-ratings'">
                <div class="bg-blue-100 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <i class="fas fa-star text-blue-600 text-xl"></i>
                </div>
                <span class="text-sm font-semibold text-gray-700">Rating Baru</span>
            </div>
            
            <div class="quick-action text-center" onclick="refreshData()">
                <div class="bg-yellow-100 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <i class="fas fa-sync-alt text-yellow-600 text-xl"></i>
                </div>
                <span class="text-sm font-semibold text-gray-700">Refresh</span>
            </div>
        </div>
        
        <!-- Informasi Tambahan -->
        <div class="mt-6 p-4 bg-blue-50 rounded-xl">
            <div class="flex items-center space-x-3">
                <div class="bg-blue-500 w-10 h-10 rounded-lg flex items-center justify-center text-white">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total unit yang telah menerima rating:</p>
                    <p class="text-lg font-bold text-blue-600">{{ $ratings->groupBy('unit_id')->count() }} Unit</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Rating dengan Filter -->
<div class="bg-white rounded-2xl shadow-lg p-6" id="latest-ratings">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
            Daftar Rating
        </h2>
        
        <!-- Filter Buttons -->
        <div class="flex space-x-2 mt-3 md:mt-0 overflow-x-auto pb-2">
            <button class="filter-btn active px-4 py-2 text-sm font-semibold" data-filter="all">
                Semua
            </button>
            <button class="filter-btn px-4 py-2 text-sm font-semibold" data-filter="4">
                4 ★
            </button>
            <button class="filter-btn px-4 py-2 text-sm font-semibold" data-filter="3">
                3 ★
            </button>
            <button class="filter-btn px-4 py-2 text-sm font-semibold" data-filter="2">
                2 ★
            </button>
            <button class="filter-btn px-4 py-2 text-sm font-semibold" data-filter="1">
                1 ★
            </button>
            <button class="filter-btn px-4 py-2 text-sm font-semibold" data-filter="unreplied">
                <i class="far fa-comment mr-1"></i>Belum Dibalas
            </button>
        </div>
    </div>
    
    <div class="space-y-4" id="ratings-container">
        @forelse($ratings as $rating)
        <div class="rating-item bg-gray-50 rounded-xl p-6 border border-gray-200" 
             data-rating="{{ $rating->rating }}"
             data-replied="{{ $rating->balasans->count() > 0 ? 'yes' : 'no' }}">
            
            <!-- Header Rating -->
            <div class="flex flex-col md:flex-row justify-between items-start mb-4">
                <div class="flex items-start space-x-4">
                    <div class="bg-gradient-to-br from-purple-600 to-pink-600 w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                        {{ strtoupper(substr($rating->nama, 0, 2)) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $rating->nama }}</h3>
                        <div class="flex items-center flex-wrap gap-2 mt-1">
                            <span class="text-sm text-gray-500">
                                <i class="far fa-envelope mr-1"></i>{{ $rating->email }}
                            </span>
                            <span class="text-sm text-gray-400">•</span>
                            <span class="text-sm text-gray-500 flex items-center">
                                <i class="far fa-calendar mr-1"></i>
                                <!-- Tampilan waktu dalam WIB -->
                                {{ $rating->created_at->timezone('Asia/Jakarta')->isoFormat('DD MMM Y HH:mm') }} 
                                <span class="ml-1 text-xs bg-gray-200 px-1.5 py-0.5 rounded">WIB</span>
                            </span>
                        </div>
                        <div class="flex items-center mt-2 space-x-2">
                            <span class="bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $rating->unit->nama_unit }}
                            </span>
                            <span class="bg-pink-100 text-pink-600 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $rating->pelayanan->nama_pelayanan }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Rating Badge -->
                <div class="mt-3 md:mt-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold text-white
                        @if($rating->rating == 4) badge-rating-4
                        @elseif($rating->rating == 3) badge-rating-3
                        @elseif($rating->rating == 2) badge-rating-2
                        @else badge-rating-1 @endif">
                        {{ $rating->rating }} ★
                    </span>
                </div>
            </div>
            
            <!-- Komentar -->
            <div class="mb-4 pl-16">
                <p class="text-gray-700 italic">"{{ $rating->komentar }}"</p>
            </div>
            
            <!-- Riwayat Balasan -->
            @foreach($rating->balasans as $balasan)
            <div class="admin-reply ml-16 mb-4 p-4 rounded-xl">
                <div class="flex items-start space-x-3">
                    <div class="bg-purple-600 w-8 h-8 rounded-lg flex items-center justify-center text-white text-sm font-bold">
                        A
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-semibold text-purple-600">Admin</span>
                            <span class="text-xs text-gray-500 flex items-center">
                                <!-- Waktu balasan dalam WIB -->
                                {{ $balasan->created_at->timezone('Asia/Jakarta')->diffForHumans() }}
                                <span class="ml-1 text-xs">(WIB)</span>
                            </span>
                        </div>
                        <p class="text-gray-700">{{ $balasan->balasan }}</p>
                    </div>
                </div>
            </div>
            @endforeach
            
            <!-- Form Balasan -->
            <form action="{{ route('admin.rating.balas', $rating) }}" method="POST" class="mt-4 ml-16 reply-form">
                @csrf
                <div class="flex flex-col space-y-3">
                    <textarea name="balasan" rows="2" 
                              placeholder="Tulis balasan Anda di sini..." 
                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-400 focus:outline-none transition duration-300"
                              required></textarea>
                    <div class="flex justify-end space-x-2">
                        <button type="button" 
                                onclick="this.closest('form').reset()"
                                class="px-4 py-2 text-gray-600 hover:text-gray-800 transition duration-300">
                            Batal
                        </button>
                        <button type="submit" 
                                class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-2 rounded-lg font-semibold flex items-center space-x-2 hover:shadow-lg transition duration-300">
                            <i class="fas fa-paper-plane"></i>
                            <span>Kirim Balasan</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @empty
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📊</div>
            <p class="text-gray-500 text-lg">Belum ada rating</p>
            <p class="text-sm text-gray-400">Rating akan muncul di sini setelah pengguna memberikan penilaian</p>
        </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div class="mt-6 flex justify-center">
        {{ $ratings->links() }}
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // FUNGSI SEDERHANA TAPI PASTI JALAN - UPDATE JAM SETIAP DETIK
    function updateClock() {
        // Buat object date baru setiap detik
        const now = new Date();
        
        // Ambil jam dalam format WIB
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        // Format tanggal Indonesia
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        const dayName = days[now.getDay()];
        const date = now.getDate();
        const month = months[now.getMonth()];
        const year = now.getFullYear();
        
        // Update elemen HTML
        document.getElementById('realtime-clock').innerHTML = `${hours}:${minutes}:${seconds} <span style="font-size:1rem; margin-left:5px;">WIB</span>`;
        document.getElementById('realtime-date').innerHTML = `${dayName}, ${date} ${month} ${year}`;
        
        // Log untuk debugging (bisa dihapus)
        console.log('Clock updated:', hours, minutes, seconds);
    }
    
    // JALANKAN FUNGSI UPDATE PERTAMA KALI
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Halaman dimuat, memulai real-time clock...');
        updateClock(); // Update segera
        
        // SET INTERVAL 1 DETIK - INI YANG MEMBUAT DETIK BERJALAN TERUS
        setInterval(updateClock, 1000);
    });
    
    // Filter functionality
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active button
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('active', 'text-purple-600');
            });
            this.classList.add('active', 'text-purple-600');
            
            const filter = this.dataset.filter;
            const ratings = document.querySelectorAll('.rating-item');
            
            ratings.forEach(rating => {
                let show = false;
                
                if (filter === 'all') {
                    show = true;
                } else if (filter === 'unreplied') {
                    show = rating.dataset.replied === 'no';
                } else {
                    show = rating.dataset.rating === filter;
                }
                
                if (show) {
                    rating.style.display = 'block';
                    setTimeout(() => {
                        rating.style.opacity = '1';
                        rating.style.transform = 'translateX(0)';
                    }, 50);
                } else {
                    rating.style.opacity = '0';
                    rating.style.transform = 'translateX(-10px)';
                    setTimeout(() => {
                        rating.style.display = 'none';
                    }, 300);
                }
            });
            
            // Show total filtered count
            const visibleCount = Array.from(ratings).filter(r => r.style.display !== 'none').length;
            Swal.fire({
                icon: 'info',
                title: 'Filter Diterapkan',
                text: `Menampilkan ${visibleCount} rating`,
                timer: 1500,
                showConfirmButton: false,
                position: 'top-end',
                toast: true
            });
        });
    });
    
    // Refresh data
    function refreshData() {
        Swal.fire({
            title: 'Memperbarui Data...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        setTimeout(() => {
            location.reload();
        }, 1500);
    }
    
    // Auto-hide success message
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false,
        position: 'top-end',
        toast: true
    });
    @endif
    
    // Smooth scroll untuk anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Auto-resize textarea
    document.querySelectorAll('textarea[name="balasan"]').forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });
</script>
@endpush