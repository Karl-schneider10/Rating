@extends('layouts.app')

@section('title', 'Admin Dashboard - Rating Kampus')

@section('content')
<style>
    /* Modern CampusPulse Theme */
    .stat-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 20px 40px rgba(21, 28, 39, 0.15);
    }
    
    .badge-rating-4 {
        background: #10b981;
    }
    
    .badge-rating-3 {
        background: #f59e0b;
    }
    
    .badge-rating-2 {
        background: #ef4444;
    }
    
    .badge-rating-1 {
        background: #6b7280;
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
        background: #fef3e8;
        border-left: 4px solid #F45B26;
        border-radius: 1rem;
        animation: fadeIn 0.5s ease-out;
    }
    
    .filter-btn {
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        background: #f1f5f9;
        color: #475569;
    }
    
    .filter-btn:hover {
        background: #F45B26;
        color: white;
    }
    
    .filter-btn.active {
        background: #F45B26;
        color: white;
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
        background: #F45B26;
    }
    
    .quick-action {
        background: white;
        border-radius: 1rem;
        padding: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 1px solid #e5e7eb;
    }
    
    .quick-action:hover {
        border-color: #F45B26;
        transform: translateY(-3px);
        box-shadow: 0px 20px 40px rgba(21, 28, 39, 0.08);
    }
    
    /* Real-time clock */
    #realtime-clock-container {
        background: #F45B26;
        padding: 15px 25px;
        border-radius: 50px;
        display: inline-block;
        margin-top: 15px;
        box-shadow: 0px 20px 40px rgba(244, 91, 38, 0.25);
    }
    
    #realtime-clock {
        font-family: 'Courier New', monospace;
        font-size: 2rem;
        font-weight: bold;
        color: white;
        letter-spacing: 3px;
    }
    
    #realtime-date {
        color: rgba(255,255,255,0.9);
        font-size: 0.875rem;
        margin-top: 5px;
    }
    
    .live-badge {
        background: #dc2626;
        color: white;
        padding: 5px 15px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        animation: blink 1s infinite;
    }
    
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }
    
    .rating-item {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
        background: white;
        border-radius: 1rem;
        border: 1px solid #e5e7eb;
    }
    
    .rating-item:hover {
        transform: translateX(5px);
        border-left-color: #F45B26;
        box-shadow: 0px 20px 40px rgba(21, 28, 39, 0.08);
    }
</style>

<!-- Header Dashboard -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[#151c27]">
                Dashboard Admin
            </h1>
            <p class="text-slate-500 mt-1">Kelola dan pantau semua rating layanan kampus</p>
            
            <!-- REAL TIME CLOCK -->
            <div id="realtime-clock-container" class="mt-4">
                <div class="flex items-center gap-4 flex-wrap">
                    <div>
                        <div id="realtime-clock">--:--:--</div>
                        <div id="realtime-date">--, -- --- ----</div>
                    </div>
                    <div class="live-badge">
                        <span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">fiber_manual_record</span>
                        <span>LIVE</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.units') }}" 
               class="bg-[#F45B26] hover:bg-[#d1430b] text-white px-6 py-3 rounded-full font-semibold flex items-center space-x-2 shadow-lg shadow-[#F45B26]/20 transition-all active:scale-[0.98]">
                <span class="material-symbols-outlined text-lg">business</span>
                <span>Kelola Unit & Pelayanan</span>
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
@php
    Carbon\Carbon::setLocale('id');
    
    $ratingCounts = [
        4 => $ratings->where('rating', 4)->count(),
        3 => $ratings->where('rating', 3)->count(),
        2 => $ratings->where('rating', 2)->count(),
        1 => $ratings->where('rating', 1)->count(),
    ];
    
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

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Rating Card -->
    <div class="stat-card bg-white rounded-xl border border-[#E5E7EB] shadow-[0px_20px_40px_rgba(21,28,39,0.04)] p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Total Rating</p>
                <h3 class="text-3xl font-bold text-[#151c27] mt-2">{{ $totalRatings }}</h3>
                <p class="text-slate-400 text-xs mt-2 flex items-center">
                    <span class="material-symbols-outlined text-xs mr-1">trending_up</span>
                    {{ $ratings->total() }} tampil
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center">
                <span class="material-symbols-outlined text-[#F45B26] text-2xl" style="font-variation-settings: 'FILL' 1;">star</span>
            </div>
        </div>
    </div>
    
    <!-- Rata-rata Rating Card -->
    <div class="stat-card bg-white rounded-xl border border-[#E5E7EB] shadow-[0px_20px_40px_rgba(21,28,39,0.04)] p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Rata-rata Rating</p>
                <h3 class="text-3xl font-bold text-[#151c27] mt-2">{{ number_format($averageRating, 1) }}</h3>
                <p class="text-slate-400 text-xs mt-2 flex items-center">
                    <span class="material-symbols-outlined text-xs mr-1">show_chart</span>
                    dari maksimal 4.0
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center">
                <span class="material-symbols-outlined text-[#F45B26] text-2xl">bar_chart</span>
            </div>
        </div>
    </div>
    
    <!-- Total Unit Card -->
    <div class="stat-card bg-white rounded-xl border border-[#E5E7EB] shadow-[0px_20px_40px_rgba(21,28,39,0.04)] p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Total Unit</p>
                <h3 class="text-3xl font-bold text-[#151c27] mt-2">{{ $totalUnits ?? $ratings->groupBy('unit_id')->count() }}</h3>
                <p class="text-slate-400 text-xs mt-2 flex items-center">
                    <span class="material-symbols-outlined text-xs mr-1">apartment</span>
                    unit layanan
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center">
                <span class="material-symbols-outlined text-[#F45B26] text-2xl">corporate_fare</span>
            </div>
        </div>
    </div>
    
    <!-- Rating Tertinggi Card -->
    <div class="stat-card bg-white rounded-xl border border-[#E5E7EB] shadow-[0px_20px_40px_rgba(21,28,39,0.04)] p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Rating Tertinggi</p>
                <h3 class="text-3xl font-bold text-[#151c27] mt-2">{{ $highestRating }} ★</h3>
                <p class="text-slate-400 text-xs mt-2 flex items-center">
                    <span class="material-symbols-outlined text-xs mr-1">workspace_premium</span>
                    {{ $highestRatingCount }} rating
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center">
                <span class="material-symbols-outlined text-[#F45B26] text-2xl">military_tech</span>
            </div>
        </div>
    </div>
</div>

<!-- Distribusi Rating & Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Distribusi Rating -->
    <div class="bg-white rounded-xl border border-[#E5E7EB] shadow-[0px_20px_40px_rgba(21,28,39,0.04)] p-6">
        <h3 class="text-lg font-bold text-[#151c27] mb-4 flex items-center">
            <span class="material-symbols-outlined text-[#F45B26] mr-2">pie_chart</span>
            Distribusi Rating
        </h3>
        
        @foreach([4,3,2,1] as $star)
        <div class="mb-4">
            <div class="flex items-center justify-between mb-1">
                <div class="flex items-center">
                    <span class="text-[#F45B26] mr-2 font-bold">{{ $star }} ★</span>
                    <span class="text-sm text-slate-500">{{ $ratingCounts[$star] }} rating</span>
                </div>
                <span class="text-sm font-semibold text-slate-700">
                    {{ $totalRatingsCount > 0 ? round(($ratingCounts[$star] / $totalRatingsCount) * 100) : 0 }}%
                </span>
            </div>
            <div class="rating-progress">
                <div class="rating-progress-bar" 
                     style="width: {{ $totalRatingsCount > 0 ? ($ratingCounts[$star] / $totalRatingsCount) * 100 : 0 }}%"></div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-xl border border-[#E5E7EB] shadow-[0px_20px_40px_rgba(21,28,39,0.04)] p-6 lg:col-span-2">
        <h3 class="text-lg font-bold text-[#151c27] mb-4 flex items-center">
            <span class="material-symbols-outlined text-[#F45B26] mr-2">bolt</span>
            Aksi Cepat
        </h3>
        
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <div class="quick-action text-center" onclick="window.location.href='{{ route('admin.units') }}'">
                <div class="bg-orange-50 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <span class="material-symbols-outlined text-[#F45B26] text-2xl">business</span>
                </div>
                <span class="text-sm font-semibold text-slate-700">Kelola Unit</span>
            </div>
            
            <div class="quick-action text-center" onclick="window.location.href='#latest-ratings'">
                <div class="bg-orange-50 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <span class="material-symbols-outlined text-[#F45B26] text-2xl" style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
                <span class="text-sm font-semibold text-slate-700">Rating Baru</span>
            </div>
            
            <div class="quick-action text-center" onclick="refreshData()">
                <div class="bg-orange-50 w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <span class="material-symbols-outlined text-[#F45B26] text-2xl">refresh</span>
                </div>
                <span class="text-sm font-semibold text-slate-700">Refresh</span>
            </div>
        </div>
        
        <!-- Informasi Tambahan -->
        <div class="mt-6 p-4 bg-orange-50 rounded-xl">
            <div class="flex items-center space-x-3">
                <div class="bg-[#F45B26] w-10 h-10 rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-lg">info</span>
                </div>
                <div>
                    <p class="text-sm text-slate-600">Total unit yang telah menerima rating:</p>
                    <p class="text-lg font-bold text-[#F45B26]">{{ $ratings->groupBy('unit_id')->count() }} Unit</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Rating dengan Filter -->
<div class="bg-white rounded-xl border border-[#E5E7EB] shadow-[0px_20px_40px_rgba(21,28,39,0.04)] p-6" id="latest-ratings">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-[#151c27]">
            Daftar Rating
        </h2>
        
        <!-- Filter Buttons -->
        <div class="flex flex-wrap gap-2">
            <button class="filter-btn active" data-filter="all">Semua</button>
            <button class="filter-btn" data-filter="4">4 ★</button>
            <button class="filter-btn" data-filter="3">3 ★</button>
            <button class="filter-btn" data-filter="2">2 ★</button>
            <button class="filter-btn" data-filter="1">1 ★</button>
            <button class="filter-btn" data-filter="unreplied">
                <span class="material-symbols-outlined text-sm mr-1">chat</span>
                Belum Dibalas
            </button>
        </div>
    </div>
    
    <div class="space-y-4" id="ratings-container">
        @forelse($ratings as $rating)
        <div class="rating-item p-6" 
             data-rating="{{ $rating->rating }}"
             data-replied="{{ $rating->balasans->count() > 0 ? 'yes' : 'no' }}">
            
            <!-- Header Rating -->
            <div class="flex flex-col md:flex-row justify-between items-start mb-4 gap-4">
                <div class="flex items-start space-x-4">
                    <div class="bg-[#F45B26] w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-md">
                        {{ strtoupper(substr($rating->nama, 0, 2)) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-[#151c27]">{{ $rating->nama }}</h3>
                        <div class="flex items-center flex-wrap gap-2 mt-1">
                            <span class="text-sm text-slate-500 flex items-center">
                                <span class="material-symbols-outlined text-sm mr-1">email</span>
                                {{ $rating->email }}
                            </span>
                            <span class="text-slate-300">•</span>
                            <span class="text-sm text-slate-500 flex items-center">
                                <span class="material-symbols-outlined text-sm mr-1">calendar_today</span>
                                {{ $rating->created_at->timezone('Asia/Jakarta')->isoFormat('DD MMM Y HH:mm') }}
                                <span class="ml-1 text-xs bg-slate-100 px-1.5 py-0.5 rounded-full">WIB</span>
                            </span>
                        </div>
                        <div class="flex items-center mt-2 space-x-2 flex-wrap gap-2">
                            <span class="bg-orange-50 text-[#F45B26] px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $rating->unit->nama_unit }}
                            </span>
                            <span class="bg-orange-50 text-[#F45B26] px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $rating->pelayanan->nama_pelayanan }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Rating Badge -->
                <div>
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
                <p class="text-slate-600 italic">"{{ $rating->komentar }}"</p>
            </div>
            
            <!-- Riwayat Balasan -->
            @foreach($rating->balasans as $balasan)
            <div class="admin-reply ml-16 mb-4 p-4">
                <div class="flex items-start space-x-3">
                    <div class="bg-[#F45B26] w-8 h-8 rounded-lg flex items-center justify-center text-white text-sm font-bold">
                        A
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1 flex-wrap gap-2">
                            <span class="font-semibold text-[#F45B26]">Admin</span>
                            <span class="text-xs text-slate-400 flex items-center">
                                {{ $balasan->created_at->timezone('Asia/Jakarta')->diffForHumans() }}
                                <span class="ml-1 text-xs">(WIB)</span>
                            </span>
                        </div>
                        <p class="text-slate-700">{{ $balasan->balasan }}</p>
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
                              class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-[#F45B26]/20 transition-all placeholder:text-slate-400"
                              required></textarea>
                    <div class="flex justify-end space-x-2">
                        <button type="button" 
                                onclick="this.closest('form').reset()"
                                class="px-4 py-2 text-slate-500 hover:text-slate-700 transition duration-300 text-sm font-semibold">
                            Batal
                        </button>
                        <button type="submit" 
                                class="bg-[#F45B26] hover:bg-[#d1430b] text-white px-6 py-2 rounded-full font-semibold flex items-center space-x-2 transition-all">
                            <span class="material-symbols-outlined text-sm">send</span>
                            <span>Kirim Balasan</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @empty
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📊</div>
            <p class="text-slate-500 text-lg">Belum ada rating</p>
            <p class="text-sm text-slate-400">Rating akan muncul di sini setelah pengguna memberikan penilaian</p>
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
    // REAL-TIME CLOCK FUNCTION
    function updateClock() {
        const now = new Date();
        
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        const dayName = days[now.getDay()];
        const date = now.getDate();
        const month = months[now.getMonth()];
        const year = now.getFullYear();
        
        const clockElement = document.getElementById('realtime-clock');
        const dateElement = document.getElementById('realtime-date');
        
        if (clockElement) {
            clockElement.innerHTML = `${hours}:${minutes}:${seconds}`;
        }
        if (dateElement) {
            dateElement.innerHTML = `${dayName}, ${date} ${month} ${year}`;
        }
    }
    
    // Initialize clock
    document.addEventListener('DOMContentLoaded', function() {
        updateClock();
        setInterval(updateClock, 1000);
    });
    
    // Filter functionality
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('active');
            });
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            const ratings = document.querySelectorAll('.rating-item');
            let visibleCount = 0;
            
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
                    visibleCount++;
                } else {
                    rating.style.display = 'none';
                }
            });
            
            // Show toast notification
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
    
    // Refresh data function
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
    
    // Auto-resize textarea
    document.querySelectorAll('textarea[name="balasan"]').forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });
</script>
@endpush