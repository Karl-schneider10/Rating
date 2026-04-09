@extends('layouts.app')

@section('title', 'Beranda - Rating Kampus')

@section('content')
<style>
    /* Additional custom styles for modern UI */
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        font-family: 'Material Symbols Outlined';
        font-weight: normal;
        font-style: normal;
        line-height: 1;
        letter-spacing: normal;
        text-transform: none;
        display: inline-block;
        white-space: nowrap;
        word-wrap: normal;
        direction: ltr;
    }
    .star-filled {
        font-variation-settings: 'FILL' 1;
        color: #F45B26;
    }
    .star-outline {
        color: #e2e8f0;
    }
    /* Smooth transitions */
    .transition-transform {
        transition-property: transform;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }
    .group:hover .group-hover\:text-\[\#F45B26\] {
        color: #F45B26;
    }
    /* Custom scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #F45B26;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #d1430b;
    }
</style>

<main class="pt-24 pb-16 px-8 max-w-[1440px] mx-auto">
    <!-- Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Stat Card 1 -->
        <div class="bg-white p-6 rounded-xl border border-[#E5E7EB] shadow-[0px_20px_40px_rgba(21,28,39,0.04)] flex items-center gap-5 transition-transform hover:translate-y-[-4px]">
            <div class="w-14 h-14 rounded-xl bg-orange-50 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[#F45B26] text-3xl" style="font-variation-settings: 'FILL' 1;">star</span>
            </div>
            <div>
                <p class="text-slate-500 font-medium tracking-wide uppercase text-[10px]">Rating Rata-rata</p>
                <h3 class="text-3xl font-bold text-[#151c27]">{{ number_format($ratings->avg('rating') ?? 0, 1) }}</h3>
            </div>
        </div>
        <!-- Stat Card 2 -->
        <div class="bg-white p-6 rounded-xl border border-[#E5E7EB] shadow-[0px_20px_40px_rgba(21,28,39,0.04)] flex items-center gap-5 transition-transform hover:translate-y-[-4px]">
            <div class="w-14 h-14 rounded-xl bg-orange-50 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[#F45B26] text-3xl">forum</span>
            </div>
            <div>
                <p class="text-slate-500 font-medium tracking-wide uppercase text-[10px]">Total Rating</p>
                <h3 class="text-3xl font-bold text-[#151c27]">{{ $ratings->total() ?? 0 }}</h3>
            </div>
        </div>
        <!-- Stat Card 3 -->
        <div class="bg-white p-6 rounded-xl border border-[#E5E7EB] shadow-[0px_20px_40px_rgba(21,28,39,0.04)] flex items-center gap-5 transition-transform hover:translate-y-[-4px]">
            <div class="w-14 h-14 rounded-xl bg-orange-50 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[#F45B26] text-3xl">corporate_fare</span>
            </div>
            <div>
                <p class="text-slate-500 font-medium tracking-wide uppercase text-[10px]">Unit Layanan</p>
                <h3 class="text-3xl font-bold text-[#151c27]">{{ $units->count() }}</h3>
            </div>
        </div>
        <!-- Stat Card 4 -->
        <div class="bg-white p-6 rounded-xl border border-[#E5E7EB] shadow-[0px_20px_40px_rgba(21,28,39,0.04)] flex items-center gap-5 transition-transform hover:translate-y-[-4px]">
            <div class="w-14 h-14 rounded-xl bg-orange-50 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-[#F45B26] text-3xl">verified</span>
            </div>
            <div>
                <p class="text-slate-500 font-medium tracking-wide uppercase text-[10px]">Rating 4 Bintang</p>
                <h3 class="text-3xl font-bold text-[#151c27]">{{ $ratings->where('rating', 4)->count() }}</h3>
            </div>
        </div>
    </div>

    <!-- Main Content Split Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Left Column: Form Penilaian -->
        <div class="lg:col-span-5 bg-white p-8 rounded-xl border border-[#E5E7EB] shadow-[0px_20px_40px_rgba(21,28,39,0.04)]">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-[#151c27]">Form Penilaian</h2>
                <p class="text-slate-500 text-sm mt-1">Bagikan pengalaman Anda untuk membantu kami berkembang.</p>
            </div>
            <form action="{{ route('rating.store') }}" method="POST" id="ratingForm" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Nama Lengkap</label>
                        <input type="text" name="nama" required 
                            class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-[#F45B26]/20 transition-all placeholder:text-slate-400"
                            placeholder="Masukkan nama lengkap Anda">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Email</label>
                        <input type="email" name="email" required 
                            class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-[#F45B26]/20 transition-all placeholder:text-slate-400"
                            placeholder="nama@email.com">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Unit Layanan</label>
                        <select name="unit_id" id="unit_id" required 
                            class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-[#F45B26]/20 transition-all text-slate-600 appearance-none">
                            <option value="">Pilih Unit Layanan</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Pelayanan</label>
                        <select name="pelayanan_id" id="pelayanan_id" required 
                            class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-[#F45B26]/20 transition-all text-slate-600 appearance-none">
                            <option value="">Pilih Unit Terlebih Dahulu</option>
                        </select>
                    </div>
                </div>
                <div class="space-y-3">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Rating Layanan</label>
                    <div class="star-rating flex gap-2" id="starRatingContainer">
                        <button type="button" class="group" data-rating-value="4">
                            <span class="material-symbols-outlined text-3xl text-slate-200 transition-transform active:scale-90 star-icon" data-rating="4">star</span>
                        </button>
                        <button type="button" class="group" data-rating-value="3">
                            <span class="material-symbols-outlined text-3xl text-slate-200 transition-transform active:scale-90 star-icon" data-rating="3">star</span>
                        </button>
                        <button type="button" class="group" data-rating-value="2">
                            <span class="material-symbols-outlined text-3xl text-slate-200 transition-transform active:scale-90 star-icon" data-rating="2">star</span>
                        </button>
                        <button type="button" class="group" data-rating-value="1">
                            <span class="material-symbols-outlined text-3xl text-slate-200 transition-transform active:scale-90 star-icon" data-rating="1">star</span>
                        </button>
                    </div>
                    <input type="hidden" name="rating" id="ratingValue" required>
                    <p class="text-center text-sm text-slate-500" id="rating-text">Pilih rating Anda</p>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider ml-1">Komentar</label>
                    <textarea name="komentar" rows="4" required 
                        class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-[#F45B26]/20 transition-all placeholder:text-slate-400"
                        placeholder="Tulis pengalaman Anda menggunakan layanan ini..."></textarea>
                </div>
                <button type="submit" 
                    class="w-full py-4 bg-[#F45B26] hover:bg-[#d1430b] text-white font-bold rounded-full shadow-lg shadow-[#F45B26]/20 transition-all active:scale-[0.98]">
                    Kirim Rating
                </button>
            </form>
        </div>

        <!-- Right Column: Riwayat Rating -->
        <div class="lg:col-span-7 space-y-6">
            <!-- Filter Bar -->
            <div class="bg-white p-4 rounded-xl border border-[#E5E7EB] shadow-[0px_10px_30px_rgba(21,28,39,0.02)] flex items-center justify-between flex-wrap gap-2">
                <h3 class="font-bold text-[#151c27] ml-2">Riwayat Rating</h3>
                <div class="flex gap-2 flex-wrap">
                    <button class="filter-btn active px-4 py-1.5 bg-[#F45B26] text-white text-sm font-semibold rounded-full transition-colors" data-filter="all">Semua</button>
                    <button class="filter-btn px-4 py-1.5 bg-slate-50 text-slate-600 hover:bg-slate-100 text-sm font-semibold rounded-full transition-colors" data-filter="4">4 ★</button>
                    <button class="filter-btn px-4 py-1.5 bg-slate-50 text-slate-600 hover:bg-slate-100 text-sm font-semibold rounded-full transition-colors" data-filter="3">3 ★</button>
                    <button class="filter-btn px-4 py-1.5 bg-slate-50 text-slate-600 hover:bg-slate-100 text-sm font-semibold rounded-full transition-colors" data-filter="2">2 ★</button>
                    <button class="filter-btn px-4 py-1.5 bg-slate-50 text-slate-600 hover:bg-slate-100 text-sm font-semibold rounded-full transition-colors" data-filter="1">1 ★</button>
                </div>
            </div>

            <!-- Review Cards Container -->
            <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar" id="ratings-container">
                @forelse($ratings as $rating)
                <div class="rating-item bg-white p-6 rounded-xl border border-[#E5E7EB] shadow-[0px_20px_40px_rgba(21,28,39,0.04)] border-l-4 border-l-[#F45B26] group hover:translate-x-1 transition-transform" data-rating="{{ $rating->rating }}">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-[#F45B26] font-bold text-lg">
                                {{ strtoupper(substr($rating->nama, 0, 2)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-[#151c27] group-hover:text-[#F45B26] transition-colors">
                                    {{ $rating->nama }}
                                </h4>
                                <div class="flex flex-wrap items-center gap-2 mt-1">
                                    <span class="inline-block px-3 py-0.5 bg-slate-100 text-slate-500 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                        {{ $rating->unit->nama_unit }}
                                    </span>
                                    <span class="text-xs text-slate-400">•</span>
                                    <span class="text-xs text-slate-500">{{ $rating->pelayanan->nama_pelayanan }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 4; $i++)
                                @if($i <= $rating->rating)
                                    <span class="material-symbols-outlined text-lg text-[#F45B26]" style="font-variation-settings: 'FILL' 1;">star</span>
                                @else
                                    <span class="material-symbols-outlined text-lg text-slate-200">star</span>
                                @endif
                            @endfor
                        </div>
                    </div>
                    <p class="text-slate-600 leading-relaxed pl-16">{{ $rating->komentar }}</p>

                    <!-- Balasan -->
                    @if($rating->balasans->count() > 0)
                        <div class="ml-12 mt-3 space-y-2">
                            @foreach($rating->balasans as $balasan)
                            <div class="bg-gradient-to-r from-orange-50 to-amber-50 p-4 rounded-xl border-l-4 border-l-[#F45B26]">
                                <div class="flex items-center mb-2">
                                    <div class="bg-[#F45B26] w-6 h-6 rounded-full flex items-center justify-center text-white text-xs mr-2">
                                        A
                                    </div>
                                    <p class="text-sm font-semibold text-[#F45B26]">Admin Kampus</p>
                                </div>
                                <p class="text-slate-700">{{ $balasan->balasan }}</p>
                                <p class="text-xs text-slate-400 mt-2">{{ $balasan->created_at->diffForHumans() }}</p>
                            </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-4 pl-16 flex items-center gap-4">
                        <span class="text-[11px] text-slate-400 font-medium italic">{{ $rating->created_at->diffForHumans() }}</span>
                        <button class="reply-btn text-[11px] text-[#F45B26] font-bold hover:underline" data-rating-id="{{ $rating->id }}">Balas</button>
                    </div>
                </div>
                @empty
                <div class="bg-white p-12 rounded-xl border border-[#E5E7EB] text-center">
                    <div class="text-6xl mb-4">📝</div>
                    <p class="text-slate-500">Belum ada rating</p>
                    <p class="text-sm text-slate-400">Jadilah yang pertama memberikan rating!</p>
                </div>
                @endforelse
            </div>

            <div class="mt-6 flex justify-center">
                {{ $ratings->links() }}
            </div>
        </div>
    </div>
</main>

<!-- Floating Action Button -->
<button onclick="scrollToForm()" class="fixed bottom-8 right-8 bg-[#F45B26] text-white w-14 h-14 rounded-full shadow-2xl hover:shadow-3xl transform hover:scale-110 transition duration-300 flex items-center justify-center text-2xl z-40">
    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
</button>

<!-- Focus Float Action Bar (Optional - matches design) -->
<div class="fixed bottom-8 left-1/2 -translate-x-1/2 bg-white/70 backdrop-blur-xl border border-white/20 px-6 py-3 rounded-full shadow-2xl flex items-center gap-8 z-40 hidden md:flex">
    <button onclick="scrollToTop()" class="flex flex-col items-center gap-1 group">
        <span class="material-symbols-outlined text-slate-500 group-hover:text-[#F45B26] transition-colors">home</span>
        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 group-hover:text-[#F45B26]">Atas</span>
    </button>
    <button onclick="scrollToForm()" class="flex flex-col items-center gap-1 group">
        <span class="material-symbols-outlined text-[#F45B26] transition-colors" style="font-variation-settings: 'FILL' 1;">rate_review</span>
        <span class="text-[10px] font-bold uppercase tracking-widest text-[#F45B26]">Rating</span>
    </button>
    <button onclick="window.location.reload()" class="flex flex-col items-center gap-1 group">
        <span class="material-symbols-outlined text-slate-500 group-hover:text-[#F45B26] transition-colors">refresh</span>
        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 group-hover:text-[#F45B26]">Segarkan</span>
    </button>
</div>
@endsection

@push('scripts')
<script>
// Material Symbols font
const link = document.createElement('link');
link.rel = 'stylesheet';
link.href = 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200';
document.head.appendChild(link);

// Dynamic pelayanan loading
document.getElementById('unit_id').addEventListener('change', function() {
    const unitId = this.value;
    const pelayananSelect = document.getElementById('pelayanan_id');
    
    if(unitId) {
        pelayananSelect.innerHTML = '<option value="">Loading...</option>';
        fetch(`/get-pelayanan/${unitId}`)
            .then(response => response.json())
            .then(data => {
                pelayananSelect.innerHTML = '<option value="">Pilih Pelayanan</option>';
                data.forEach(pelayanan => {
                    pelayananSelect.innerHTML += `<option value="${pelayanan.id}">${pelayanan.nama_pelayanan}</option>`;
                });
            });
    } else {
        pelayananSelect.innerHTML = '<option value="">Pilih Unit Terlebih Dahulu</option>';
    }
});

// Star rating system
let currentRating = 0;
const starContainer = document.getElementById('starRatingContainer');
const starIcons = document.querySelectorAll('.star-icon');
const ratingInput = document.getElementById('ratingValue');
const ratingText = document.getElementById('rating-text');
const ratingsMap = ['', 'Kurang Baik', 'Cukup', 'Baik', 'Sangat Baik'];

function updateStars(rating) {
    starIcons.forEach((star, index) => {
        const starValue = parseInt(star.dataset.rating);
        if (starValue <= rating) {
            star.textContent = 'star';
            star.classList.add('text-[#F45B26]');
            star.classList.remove('text-slate-200');
            star.style.fontVariationSettings = "'FILL' 1";
        } else {
            star.textContent = 'star';
            star.classList.remove('text-[#F45B26]');
            star.classList.add('text-slate-200');
            star.style.fontVariationSettings = "'FILL' 0";
        }
    });
}

starIcons.forEach(star => {
    star.addEventListener('click', function() {
        const rating = parseInt(this.dataset.rating);
        currentRating = rating;
        ratingInput.value = rating;
        updateStars(rating);
        ratingText.textContent = ratingsMap[rating];
    });
    
    star.addEventListener('mouseenter', function() {
        const rating = parseInt(this.dataset.rating);
        starIcons.forEach((s, idx) => {
            const starVal = parseInt(s.dataset.rating);
            if (starVal <= rating) {
                s.classList.add('text-[#F45B26]');
                s.classList.remove('text-slate-200');
            } else {
                s.classList.remove('text-[#F45B26]');
                s.classList.add('text-slate-200');
            }
        });
    });
});

starContainer.addEventListener('mouseleave', function() {
    updateStars(currentRating);
});

// Filter ratings
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('bg-[#F45B26]', 'text-white');
            b.classList.add('bg-slate-50', 'text-slate-600');
        });
        this.classList.remove('bg-slate-50', 'text-slate-600');
        this.classList.add('bg-[#F45B26]', 'text-white');
        
        const filter = this.dataset.filter;
        document.querySelectorAll('.rating-item').forEach(item => {
            if(filter === 'all' || item.dataset.rating === filter) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
});

// Form validation
document.getElementById('ratingForm').addEventListener('submit', function(e) {
    if(!document.querySelector('input[name="rating"]:checked') && !ratingInput.value) {
        e.preventDefault();
        alert('Silakan pilih rating terlebih dahulu!');
    }
});

// Scroll functions
function scrollToForm() {
    document.querySelector('.lg:col-span-5').scrollIntoView({ behavior: 'smooth' });
}

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
@endpush