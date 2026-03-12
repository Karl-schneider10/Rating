@extends('layouts.app')

@section('title', 'Kelola Unit & Pelayanan - Rating Kampus')

@section('content')
<style>
    .unit-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }
    
    .unit-card:hover {
        transform: translateY(-5px);
        border-color: #667eea;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .unit-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(102, 126, 234, 0.1), transparent);
        transform: rotate(45deg) translate(-100%, -100%);
        transition: transform 0.6s ease;
    }
    
    .unit-card:hover::before {
        transform: rotate(45deg) translate(100%, 100%);
    }
    
    .service-item {
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }
    
    .service-item:hover {
        border-left-color: #667eea;
        background: linear-gradient(90deg, #f9fafb, white);
        transform: translateX(5px);
    }
    
    .form-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: sticky;
        top: 100px;
    }
    
    .modal-content {
        animation: modalSlideIn 0.3s ease-out;
    }
    
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .input-modern {
        transition: all 0.3s ease;
        border: 2px solid #e2e8f0;
    }
    
    .input-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.5);
    }
    
    .btn-primary::after {
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
    
    .btn-primary:hover::after {
        transform: rotate(30deg) translate(30%, -20%);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
    }
    
    .action-btn {
        transition: all 0.2s ease;
        border-radius: 10px;
    }
    
    .action-btn:hover {
        transform: scale(1.1);
    }
    
    .badge-unit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.25rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .empty-state {
        animation: fadeIn 0.5s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .search-box {
        transition: all 0.3s ease;
    }
    
    .search-box:focus-within {
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
    }
    
    .stat-badge {
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.875rem;
        color: #4b5563;
    }
    
    /* Tombol Kembali ke Dashboard */
    .back-to-dashboard {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .back-to-dashboard:hover {
        transform: translateX(-5px);
        box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.5);
        border-color: white;
    }
    
    .back-to-dashboard i {
        transition: transform 0.3s ease;
    }
    
    .back-to-dashboard:hover i {
        transform: translateX(-3px);
    }
</style>

<!-- Header Section dengan Tombol Kembali -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center space-x-4">
            <!-- Tombol Kembali ke Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="back-to-dashboard text-white px-5 py-3 rounded-xl font-semibold flex items-center space-x-2 shadow-lg">
                <i class="fas fa-arrow-left"></i>
                <span>dashboard</span>
            </a>
            
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                    Kelola Unit & Pelayanan
                </h1>
                <p class="text-gray-600 mt-1">Atur unit dan jenis pelayanan yang tersedia di kampus</p>
            </div>
        </div>
        
        <!-- Statistik Cepat -->
        <div class="flex space-x-3">
            <div class="stat-badge">
                <i class="fas fa-building text-purple-600 mr-2"></i>
                <span class="font-semibold">{{ $units->count() }}</span> Unit
            </div>
            <div class="stat-badge">
                <i class="fas fa-list text-pink-600 mr-2"></i>
                <span class="font-semibold">{{ $units->sum(function($unit) { return $unit->pelayanans->count(); }) }}</span> Pelayanan
            </div>
        </div>
    </div>
    
    <!-- Breadcrumb Navigation -->
    <div class="flex items-center space-x-2 text-sm text-gray-500 mt-4">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-purple-600 transition">Dashboard</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-purple-600 font-semibold">Kelola Unit & Pelayanan</span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Form Section - Left Column -->
    <div class="lg:col-span-1">
        <div class="form-card bg-white rounded-2xl shadow-xl p-6">
            <h2 class="text-xl font-bold mb-6 flex items-center">
                <span class="bg-gradient-to-r from-purple-600 to-pink-600 w-8 h-8 rounded-lg flex items-center justify-center text-white mr-3">
                    <i class="fas fa-plus"></i>
                </span>
                Tambah Unit Baru
            </h2>
            
            <form action="{{ route('admin.units.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 mb-2 font-semibold">Nama Unit</label>
                    <input type="text" name="nama_unit" required 
                           class="input-modern w-full px-4 py-3 rounded-xl"
                           placeholder="Contoh: Akademik, Kemahasiswaan, dll">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2 font-semibold">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" 
                              class="input-modern w-full px-4 py-3 rounded-xl"
                              placeholder="Jelaskan tentang unit ini..."></textarea>
                </div>
                <button type="submit" class="btn-primary w-full text-white py-3 rounded-xl font-semibold">
                    <i class="fas fa-save mr-2"></i>
                    Tambah Unit
                </button>
            </form>

            <hr class="my-8 border-2 border-dashed border-gray-200">

            <h2 class="text-xl font-bold mb-6 flex items-center">
                <span class="bg-gradient-to-r from-green-500 to-green-600 w-8 h-8 rounded-lg flex items-center justify-center text-white mr-3">
                    <i class="fas fa-plus"></i>
                </span>
                Tambah Pelayanan
            </h2>
            
            <form action="{{ route('admin.pelayanan.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 mb-2 font-semibold">Pilih Unit</label>
                    <select name="unit_id" required class="input-modern w-full px-4 py-3 rounded-xl appearance-none bg-white">
                        <option value="">-- Pilih Unit --</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2 font-semibold">Nama Pelayanan</label>
                    <input type="text" name="nama_pelayanan" required 
                           class="input-modern w-full px-4 py-3 rounded-xl"
                           placeholder="Contoh: Pendaftaran KRS, Pengajuan Beasiswa">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2 font-semibold">Deskripsi</label>
                    <textarea name="deskripsi" rows="2" 
                              class="input-modern w-full px-4 py-3 rounded-xl"
                              placeholder="Jelaskan tentang pelayanan ini..."></textarea>
                </div>
                <button type="submit" class="btn-primary w-full text-white py-3 rounded-xl font-semibold">
                    <i class="fas fa-save mr-2"></i>
                    Tambah Pelayanan
                </button>
            </form>
            
            <!-- Tips Card -->
            <div class="mt-6 p-4 bg-blue-50 rounded-xl">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-lightbulb text-yellow-500 text-xl mt-1"></i>
                    <div>
                        <h4 class="font-semibold text-gray-800">Tips:</h4>
                        <p class="text-sm text-gray-600">Tambahkan unit terlebih dahulu sebelum menambahkan pelayanan. Setiap unit dapat memiliki beberapa jenis pelayanan.</p>
                    </div>
                </div>
            </div>
            
            <!-- Quick Navigation -->
            <div class="mt-6 p-4 bg-purple-50 rounded-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-compass text-purple-600 text-xl"></i>
                        <span class="font-semibold text-gray-700">Navigasi Cepat:</span>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="text-purple-600 hover:text-purple-800 font-semibold text-sm flex items-center">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Unit & Pelayanan - Right Column -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div class="flex items-center space-x-3">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        Daftar Unit & Pelayanan
                    </h2>
                    
                    <!-- Tombol Kembali Kecil (Mobile) -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="md:hidden bg-purple-100 text-purple-600 px-3 py-2 rounded-lg text-sm flex items-center">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Dashboard
                    </a>
                </div>
                
                <!-- Search Box -->
                <div class="search-box relative w-full md:w-auto">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="Cari unit atau pelayanan..." 
                           class="pl-12 pr-4 py-2 border-2 border-gray-200 rounded-xl focus:border-purple-400 focus:outline-none w-full md:w-64">
                </div>
            </div>
            
            @if($units->isEmpty())
                <div class="empty-state text-center py-12">
                    <div class="text-6xl mb-4">🏢</div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Unit</h3>
                    <p class="text-gray-500">Mulai dengan menambahkan unit pertama Anda</p>
                    
                    <!-- Tombol Kembali di Empty State -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="inline-flex items-center mt-6 text-purple-600 hover:text-purple-800 font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Dashboard
                    </a>
                </div>
            @else
                <div class="space-y-6" id="unitsContainer">
                    @foreach($units as $unit)
                    <div class="unit-card bg-gradient-to-r from-gray-50 to-white rounded-xl p-6 border border-gray-200" data-unit-name="{{ strtolower($unit->nama_unit) }}">
                        <!-- Header Unit -->
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-start space-x-4">
                                <div class="bg-gradient-to-br from-purple-600 to-pink-600 w-14 h-14 rounded-xl flex items-center justify-center text-white text-2xl shadow-lg">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">{{ $unit->nama_unit }}</h3>
                                    <p class="text-gray-600 mt-1">{{ $unit->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                                    <div class="flex items-center mt-2 space-x-2">
                                        <span class="badge-unit">
                                            <i class="fas fa-list mr-1"></i>
                                            {{ $unit->pelayanans->count() }} Pelayanan
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <button onclick="editUnit({{ $unit->id }}, '{{ $unit->nama_unit }}', '{{ $unit->deskripsi }}')" 
                                        class="action-btn w-10 h-10 bg-blue-100 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition duration-300 flex items-center justify-center"
                                        title="Edit Unit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.units.delete', $unit) }}" method="POST" class="inline"
                                      onsubmit="return confirmDelete('unit', '{{ $unit->nama_unit }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="action-btn w-10 h-10 bg-red-100 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition duration-300 flex items-center justify-center"
                                            title="Hapus Unit">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Daftar Pelayanan -->
                        @if($unit->pelayanans->isNotEmpty())
                        <div class="ml-18 mt-4">
                            <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                                <i class="fas fa-list-alt text-purple-600 mr-2"></i>
                                Daftar Pelayanan:
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($unit->pelayanans as $pelayanan)
                                <div class="service-item bg-white p-4 rounded-xl border border-gray-200 flex justify-between items-center group"
                                     data-service-name="{{ strtolower($pelayanan->nama_pelayanan) }}">
                                    <div>
                                        <span class="font-semibold text-gray-800">{{ $pelayanan->nama_pelayanan }}</span>
                                        @if($pelayanan->deskripsi)
                                            <p class="text-sm text-gray-500 mt-1">{{ $pelayanan->deskripsi }}</p>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <button onclick="editPelayanan({{ $pelayanan->id }}, '{{ $pelayanan->nama_pelayanan }}', '{{ $pelayanan->deskripsi }}')" 
                                                class="text-blue-600 hover:text-blue-800 w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                        <form action="{{ route('admin.pelayanan.delete', $pelayanan) }}" method="POST" class="inline"
                                              onsubmit="return confirmDelete('pelayanan', '{{ $pelayanan->nama_pelayanan }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="ml-18 mt-4 p-4 bg-yellow-50 rounded-xl border border-yellow-200">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mr-3"></i>
                                <p class="text-yellow-700">Belum ada pelayanan untuk unit ini. Tambahkan pelayanan menggunakan form di samping.</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            @endif
            
            <!-- Footer Navigation -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <a href="{{ route('admin.dashboard') }}" 
                   class="text-gray-600 hover:text-purple-600 transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Dashboard
                </a>
                
                <p class="text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Total {{ $units->count() }} unit dengan {{ $units->sum(function($unit) { return $unit->pelayanans->count(); }) }} pelayanan
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Unit -->
<div id="editUnitModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="modal-content bg-white rounded-2xl p-8 w-96 max-w-full mx-4">
        <div class="flex items-center mb-6">
            <div class="bg-purple-600 w-12 h-12 rounded-xl flex items-center justify-center text-white text-xl mr-4">
                <i class="fas fa-building"></i>
            </div>
            <h3 class="text-2xl font-bold">Edit Unit</h3>
        </div>
        
        <form id="editUnitForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2 font-semibold">Nama Unit</label>
                <input type="text" name="nama_unit" id="edit_nama_unit" required 
                       class="input-modern w-full px-4 py-3 rounded-xl">
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 mb-2 font-semibold">Deskripsi</label>
                <textarea name="deskripsi" id="edit_deskripsi_unit" rows="3" 
                          class="input-modern w-full px-4 py-3 rounded-xl"></textarea>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeEditUnitModal()" 
                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition duration-300 font-semibold">
                    Batal
                </button>
                <button type="submit" class="btn-primary px-6 py-3 text-white rounded-xl font-semibold">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Pelayanan -->
<div id="editPelayananModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="modal-content bg-white rounded-2xl p-8 w-96 max-w-full mx-4">
        <div class="flex items-center mb-6">
            <div class="bg-pink-600 w-12 h-12 rounded-xl flex items-center justify-center text-white text-xl mr-4">
                <i class="fas fa-list"></i>
            </div>
            <h3 class="text-2xl font-bold">Edit Pelayanan</h3>
        </div>
        
        <form id="editPelayananForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2 font-semibold">Nama Pelayanan</label>
                <input type="text" name="nama_pelayanan" id="edit_nama_pelayanan" required 
                       class="input-modern w-full px-4 py-3 rounded-xl">
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 mb-2 font-semibold">Deskripsi</label>
                <textarea name="deskripsi" id="edit_deskripsi_pelayanan" rows="3" 
                          class="input-modern w-full px-4 py-3 rounded-xl"></textarea>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeEditPelayananModal()" 
                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition duration-300 font-semibold">
                    Batal
                </button>
                <button type="submit" class="btn-primary px-6 py-3 text-white rounded-xl font-semibold">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg transform transition-transform duration-300 translate-y-20 z-50">
    <div class="flex items-center space-x-2">
        <i class="fas fa-check-circle"></i>
        <span id="toastMessage">Berhasil disimpan!</span>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Fungsi Edit Unit
function editUnit(id, nama, deskripsi) {
    document.getElementById('editUnitForm').action = `/admin/units/${id}`;
    document.getElementById('edit_nama_unit').value = nama;
    document.getElementById('edit_deskripsi_unit').value = deskripsi;
    document.getElementById('editUnitModal').classList.remove('hidden');
    document.getElementById('editUnitModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeEditUnitModal() {
    document.getElementById('editUnitModal').classList.add('hidden');
    document.getElementById('editUnitModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Fungsi Edit Pelayanan
function editPelayanan(id, nama, deskripsi) {
    document.getElementById('editPelayananForm').action = `/admin/pelayanan/${id}`;
    document.getElementById('edit_nama_pelayanan').value = nama;
    document.getElementById('edit_deskripsi_pelayanan').value = deskripsi;
    document.getElementById('editPelayananModal').classList.remove('hidden');
    document.getElementById('editPelayananModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeEditPelayananModal() {
    document.getElementById('editPelayananModal').classList.add('hidden');
    document.getElementById('editPelayananModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Konfirmasi Hapus dengan SweetAlert
function confirmDelete(type, name) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: `Apakah Anda yakin ingin menghapus ${type} "${name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e53e3e',
        cancelButtonColor: '#a0aec0',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        background: 'white',
        backdrop: `rgba(0, 0, 0, 0.5)`
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form
            event.target.submit();
        }
    });
    return false;
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const unitCards = document.querySelectorAll('.unit-card');
    
    unitCards.forEach(card => {
        const unitName = card.dataset.unitName;
        const serviceItems = card.querySelectorAll('.service-item');
        let unitMatch = unitName.includes(searchTerm);
        let serviceMatch = false;
        
        // Check services
        serviceItems.forEach(item => {
            const serviceName = item.dataset.serviceName;
            if (serviceName.includes(searchTerm)) {
                serviceMatch = true;
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
        
        // Show/hide unit card
        if (unitMatch || serviceMatch) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
        
        // If no services match but unit matches, show all services
        if (unitMatch && !serviceMatch && searchTerm !== '') {
            serviceItems.forEach(item => item.style.display = 'flex');
        }
    });
});

// Tutup modal jika klik di luar
window.onclick = function(event) {
    const unitModal = document.getElementById('editUnitModal');
    const pelayananModal = document.getElementById('editPelayananModal');
    
    if (event.target == unitModal) {
        closeEditUnitModal();
    }
    if (event.target == pelayananModal) {
        closeEditPelayananModal();
    }
}

// Show toast notification
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');
    
    toastMessage.textContent = message;
    toast.classList.remove('translate-y-20');
    
    if (type === 'error') {
        toast.classList.remove('bg-green-500');
        toast.classList.add('bg-red-500');
    } else {
        toast.classList.remove('bg-red-500');
        toast.classList.add('bg-green-500');
    }
    
    setTimeout(() => {
        toast.classList.add('translate-y-20');
    }, 3000);
}

// Keyboard shortcut untuk search (Ctrl/Cmd + F)
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        e.preventDefault();
        document.getElementById('searchInput').focus();
    }
    
    // Escape untuk menutup modal
    if (e.key === 'Escape') {
        closeEditUnitModal();
        closeEditPelayananModal();
    }
});

// Auto-show success message
@if(session('success'))
    showToast('{{ session('success') }}');
@endif

// Animasi untuk form submission
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function() {
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn && !submitBtn.classList.contains('btn-primary')) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';
        }
    });
});
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush