@extends('layouts.app')

@section('title', 'Beranda - Rating Kampus')

@section('content')
<style>
    .rating-card {
        transition: all 0.3s ease;
    }
    .rating-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .star-rating {
        direction: rtl;
        display: inline-flex;
    }
    .star-rating input[type="radio"] {
        display: none;
    }
    .star-rating label {
        color: #ddd;
        font-size: 2.5rem;
        padding: 0 0.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input[type="radio"]:checked ~ label {
        color: #ffd700;
        transform: scale(1.1);
        text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
    }
    .rating-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .floating { 
        animation: floating 3s ease-in-out infinite;
    }
    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .input-focus-effect:focus {
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
    }
</style>

<!-- Header Statistik -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 fade-in">
    <div class="rating-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-400">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Rating Rata-rata</p>
                <h3 class="text-3xl font-bold">{{ number_format($ratings->avg('rating') ?? 0, 1) }}</h3>
            </div>
            <div class="text-yellow-400 text-4xl">⭐</div>
        </div>
    </div>
    
    <div class="rating-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-400">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Rating</p>
                <h3 class="text-3xl font-bold">{{ $ratings->total() ?? 0 }}</h3>
            </div>
            <div class="text-blue-400 text-4xl">📊</div>
        </div>
    </div>
    
    <div class="rating-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-400">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Unit Layanan</p>
                <h3 class="text-3xl font-bold">{{ $units->count() }}</h3>
            </div>
            <div class="text-green-400 text-4xl">🏢</div>
        </div>
    </div>
    
    <div class="rating-card bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-400">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Rating 4 Bintang</p>
                <h3 class="text-3xl font-bold">{{ $ratings->where('rating', 4)->count() }}</h3>
            </div>
            <div class="text-purple-400 text-4xl">🌟</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Form Rating - Modern Card -->
    <div class="rating-card bg-white rounded-2xl shadow-xl p-8 fade-in" style="animation-delay: 0.2s">
        <div class="flex items-center mb-6">
            <div class="gradient-bg w-12 h-12 rounded-2xl flex items-center justify-center text-white text-2xl floating mr-4">
                📝
            </div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                Beri Rating Layanan
            </h2>
        </div>
        
        <form action="{{ route('rating.store') }}" method="POST" id="ratingForm" class="space-y-5">
            @csrf
            
            <div class="relative">
                <label class="block text-gray-700 mb-2 font-semibold">Nama Lengkap</label>
                <input type="text" name="nama" required 
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-400 focus:outline-none input-focus-effect transition duration-300"
                       placeholder="Masukkan nama lengkap Anda">
            </div>

            <div class="relative">
                <label class="block text-gray-700 mb-2 font-semibold">Email</label>
                <input type="email" name="email" required 
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-400 focus:outline-none input-focus-effect transition duration-300"
                       placeholder="nama@email.com">
            </div>

            <div class="relative">
                <label class="block text-gray-700 mb-2 font-semibold">Unit</label>
                <select name="unit_id" id="unit_id" required 
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-400 focus:outline-none input-focus-effect transition duration-300 appearance-none bg-white">
                    <option value="">Pilih Unit Layanan</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                    @endforeach
                </select>
                <div class="absolute right-4 bottom-4 text-gray-400 pointer-events-none">▼</div>
            </div>

            <div class="relative">
                <label class="block text-gray-700 mb-2 font-semibold">Pelayanan</label>
                <select name="pelayanan_id" id="pelayanan_id" required 
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-400 focus:outline-none input-focus-effect transition duration-300 appearance-none bg-white">
                    <option value="">Pilih Unit Terlebih Dahulu</option>
                </select>
                <div class="absolute right-4 bottom-4 text-gray-400 pointer-events-none">▼</div>
            </div>

            <div class="relative">
                <label class="block text-gray-700 mb-4 font-semibold">Rating Layanan</label>
                <div class="star-rating flex justify-center space-x-2">
                    <input type="radio" name="rating" value="4" id="star4" required><label for="star4" class="text-4xl">★</label>
                    <input type="radio" name="rating" value="3" id="star3"><label for="star3" class="text-4xl">★</label>
                    <input type="radio" name="rating" value="2" id="star2"><label for="star2" class="text-4xl">★</label>
                    <input type="radio" name="rating" value="1" id="star1"><label for="star1" class="text-4xl">★</label>
                </div>
                <p class="text-center text-sm text-gray-500 mt-2" id="rating-text">Pilih rating Anda</p>
            </div>

            <div class="relative">
                <label class="block text-gray-700 mb-2 font-semibold">Komentar</label>
                <textarea name="komentar" rows="4" required 
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-400 focus:outline-none input-focus-effect transition duration-300"
                          placeholder="Tulis pengalaman Anda menggunakan layanan ini..."></textarea>
            </div>

            <button type="submit" 
                    class="w-full gradient-bg text-white py-4 rounded-xl font-bold text-lg hover:shadow-lg transform hover:scale-105 transition duration-300 flex items-center justify-center space-x-2">
                <span>⭐ Kirim Rating</span>
                <span class="text-xl">→</span>
            </button>
        </form>
        
        <p class="text-center text-sm text-gray-500 mt-4">
            Rating Anda akan membantu kami meningkatkan kualitas layanan
        </p>
    </div>

    <!-- Riwayat Rating - Modern Card dengan Tab -->
    <div class="rating-card bg-white rounded-2xl shadow-xl p-8 fade-in" style="animation-delay: 0.4s">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="gradient-bg w-12 h-12 rounded-2xl flex items-center justify-center text-white text-2xl floating mr-4">
                    📋
                </div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                    Riwayat Rating
                </h2>
            </div>
            <span class="rating-badge text-white px-4 py-2 rounded-full text-sm font-semibold">
                {{ $ratings->total() ?? 0 }} Review
            </span>
        </div>
        
        <!-- Filter Tabs -->
        <div class="flex space-x-2 mb-6 overflow-x-auto pb-2">
            <button class="filter-btn active px-4 py-2 rounded-full text-sm font-semibold bg-purple-600 text-white transition duration-300" data-filter="all">
                Semua
            </button>
            <button class="filter-btn px-4 py-2 rounded-full text-sm font-semibold bg-gray-200 text-gray-700 hover:bg-purple-200 transition duration-300" data-filter="4">
                4 ★
            </button>
            <button class="filter-btn px-4 py-2 rounded-full text-sm font-semibold bg-gray-200 text-gray-700 hover:bg-purple-200 transition duration-300" data-filter="3">
                3 ★
            </button>
            <button class="filter-btn px-4 py-2 rounded-full text-sm font-semibold bg-gray-200 text-gray-700 hover:bg-purple-200 transition duration-300" data-filter="2">
                2 ★
            </button>
            <button class="filter-btn px-4 py-2 rounded-full text-sm font-semibold bg-gray-200 text-gray-700 hover:bg-purple-200 transition duration-300" data-filter="1">
                1 ★
            </button>
        </div>
        
        <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar" id="ratings-container">
            @forelse($ratings as $rating)
            <div class="rating-item border-2 border-gray-100 rounded-xl p-5 hover:border-purple-200 transition duration-300" data-rating="{{ $rating->rating }}">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-start space-x-3">
                        <div class="gradient-bg w-10 h-10 rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($rating->nama, 0, 2)) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">{{ $rating->nama }}</h3>
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="bg-purple-100 text-purple-600 px-2 py-1 rounded-full text-xs mr-2">
                                    {{ $rating->unit->nama_unit }}
                                </span>
                                <span>•</span>
                                <span class="ml-2">{{ $rating->pelayanan->nama_pelayanan }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex text-yellow-400 text-lg">
                        @for($i = 1; $i <= 4; $i++)
                            @if($i <= $rating->rating)
                                ★
                            @else
                                <span class="text-gray-300">★</span>
                            @endif
                        @endfor
                    </div>
                </div>
                
                <p class="text-gray-700 mb-4 pl-13">{{ $rating->komentar }}</p>
                
                <!-- Balasan dengan Animasi -->
                @if($rating->balasans->count() > 0)
                    <div class="ml-12 mt-3 space-y-2">
                        @foreach($rating->balasans as $balasan)
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-4 rounded-xl border-l-4 border-purple-500">
                            <div class="flex items-center mb-2">
                                <div class="bg-purple-600 w-6 h-6 rounded-full flex items-center justify-center text-white text-xs mr-2">
                                    A
                                </div>
                                <p class="text-sm font-semibold text-purple-600">Admin Kampus</p>
                            </div>
                            <p class="text-gray-700">{{ $balasan->balasan }}</p>
                            <p class="text-xs text-gray-500 mt-2">{{ $balasan->created_at->diffForHumans() }}</p>
                        </div>
                        @endforeach
                    </div>
                @endif
                
                <div class="flex items-center justify-between mt-3 text-xs text-gray-400">
                    <span>{{ $rating->created_at->diffForHumans() }}</span>
                    <button class="text-purple-600 hover:text-purple-800 reply-btn" data-rating-id="{{ $rating->id }}">
                        <i class="far fa-comment mr-1"></i> Balas
                    </button>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <div class="text-6xl mb-4">📝</div>
                <p class="text-gray-500">Belum ada rating</p>
                <p class="text-sm text-gray-400">Jadilah yang pertama memberikan rating!</p>
            </div>
            @endforelse
        </div>
        
        <div class="mt-6 flex justify-center">
            {{ $ratings->links() }}
        </div>
    </div>
</div>

<!-- Floating Action Button untuk Rating Cepat -->
<button onclick="scrollToForm()" class="fixed bottom-8 right-8 gradient-bg text-white w-14 h-14 rounded-full shadow-2xl hover:shadow-3xl transform hover:scale-110 transition duration-300 flex items-center justify-center text-2xl floating">
    ⭐
</button>
@endsection

@push('scripts')
<script>
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

// Rating text change
document.querySelectorAll('.star-rating input').forEach(radio => {
    radio.addEventListener('change', function() {
        const ratingText = document.getElementById('rating-text');
        const ratings = ['', 'Kurang Baik', 'Cukup', 'Baik', 'Sangat Baik'];
        ratingText.textContent = ratings[this.value];
    });
});

// Filter ratings
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Update active button
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('bg-purple-600', 'text-white');
            b.classList.add('bg-gray-200', 'text-gray-700');
        });
        this.classList.remove('bg-gray-200', 'text-gray-700');
        this.classList.add('bg-purple-600', 'text-white');
        
        // Filter items
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

// Scroll to form
function scrollToForm() {
    document.querySelector('.rating-card').scrollIntoView({ behavior: 'smooth' });
}

// Form validation dengan animasi
document.getElementById('ratingForm').addEventListener('submit', function(e) {
    if(!document.querySelector('input[name="rating"]:checked')) {
        e.preventDefault();
        alert('Silakan pilih rating terlebih dahulu!');
    }
});

// Custom scrollbar style
const style = document.createElement('style');
style.textContent = `
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }
`;
document.head.appendChild(style);
</script>
@endpush