@extends('layouts.app')

@section('title', 'Kelola Unit & Pelayanan - Rating Kampus')

@section('content')
<style>
    /* Modern CampusPulse Theme */
    .unit-card {
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
        position: relative;
        overflow: hidden;
        background: white;
        border-radius: 1rem;
    }
    
    .unit-card:hover {
        transform: translateY(-5px);
        border-color: #F45B26;
        box-shadow: 0px 20px 40px rgba(21, 28, 39, 0.08);
    }
    
    .service-item {
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
        background: #f8fafc;
        border-radius: 0.75rem;
    }
    
    .service-item:hover {
        border-left-color: #F45B26;
        background: white;
        transform: translateX(5px);
        box-shadow: 0px 10px 20px rgba(21, 28, 39, 0.05);
    }
    
    .form-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 1rem;
        position: sticky;
        top: 100px;
    }
    
    .modal-content {
        animation: modalSlideIn 0.3s ease-out;
    }
    
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .input-modern {
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        border-radius: 0.75rem;
    }
    
    .input-modern:focus {
        border-color: #F45B26;
        box-shadow: 0 0 0 3px rgba(244, 91, 38, 0.1);
        outline: none;
        background: white;
    }
    
    .btn-primary {
        background: #F45B26;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: #d1430b;
        transform: translateY(-2px);
        box-shadow: 0px 10px 20px rgba(244, 91, 38, 0.25);
    }
    
    .btn-success {
        background: #10b981;
    }
    
    .btn-success:hover {
        background: #059669;
    }
    
    .btn-danger {
        background: #ef4444;
    }
    
    .btn-danger:hover {
        background: #dc2626;
    }
    
    .action-btn {
        transition: all 0.2s ease;
        border-radius: 0.5rem;
    }
    
    .action-btn:hover {
        transform: scale(1.05);
    }
    
    .badge-unit {
        background: #F45B26;
        color: white;
        padding: 0.25rem 1rem;
        border-radius: 9999px;
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
        box-shadow: 0 0 0 3px rgba(244, 91, 38, 0.15);
    }
    
    .stat-badge {
        background: #f8fafc;
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        font-size: 0.875rem;
        color: #475569;
        border: 1px solid #e5e7eb;
    }
    
    .back-to-dashboard {
        background: #F45B26;
        transition: all 0.3s ease;
    }
    
    .back-to-dashboard:hover {
        background: #d1430b;
        transform: translateX(-5px);
        box-shadow: 0px 10px 20px rgba(244, 91, 38, 0.25);
    }
    
    .back-to-dashboard span {
        transition: transform 0.3s ease;
    }
    
    .back-to-dashboard:hover span {
        transform: translateX(-3px);
    }
</style>

<!-- Header Section -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center space-x-4">
            <!-- Tombol Kembali ke Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="back-to-dashboard text-white px-5 py-3 rounded-full font-semibold flex items-center space-x-2 shadow-lg shadow-[#F45B26]/20 transition-all">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                <span>Dashboard</span>
            </a>
            
            <div>
                <h1 class="text-3xl font-bold text-[#151c27]">
                    Kelola Unit & Pelayanan
                </h1>
                <p class="text-slate-500 mt-1">Atur unit dan jenis pelayanan yang tersedia di kampus</p>
            </div>
        </div>
        
        <!-- Statistik Cepat -->
        <div class="flex space-x-3">
            <div class="stat-badge flex items-center">
                <span class="material-symbols-outlined text-[#F45B26] text-lg mr-2">business</span>
                <span class="font-semibold">{{ $units->count() }}</span> Unit
            </div>
            <div class="stat-badge flex items-center">
                <span class="material-symbols-outlined text-[#F45B26] text-lg mr-2">list_alt</span>
                <span class="font-semibold">{{ $units->sum(function($unit) { return $unit->pelayanans->count(); }) }}</span> Pelayanan
            </div>
        </div>
    </div>
    
    <!-- Breadcrumb Navigation -->
    <div class="flex items-center space-x-2 text-sm text-slate-500 mt-4">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#F45B26] transition">Dashboard</a>
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <span class="text-[#F45B26] font-semibold">Kelola Unit & Pelayanan</span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Form Section - Left Column -->
    <div class="lg:col-span-1">
        <div class="form-card p-6">
            <h2 class="text-xl font-bold mb-6 flex items-center">
                <span class="bg-[#F45B26] w-8 h-8 rounded-lg flex items-center justify-center text-white mr-3">
                    <span class="material-symbols-outlined text-lg">add</span>
                </span>
                Tambah Unit Baru
            </h2>
            
            <form action="{{ route('admin.units.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-slate-700 mb-2 font-semibold text-sm">Nama Unit</label>
                    <input type="text" name="nama_unit" required 
                           class="input-modern w-full px-4 py-3 rounded-xl"
                           placeholder="Contoh: Akademik, Kemahasiswaan, dll">
                </div>
                <div>
                    <label class="block text-slate-700 mb-2 font-semibold text-sm">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" 
                              class="input-modern w-full px-4 py-3 rounded-xl"
                              placeholder="Jelaskan tentang unit ini..."></textarea>
                </div>
                <button type="submit" class="btn-primary w-full text-white py-3 rounded-full font-semibold transition-all">
                    <span class="material-symbols-outlined text-sm mr-2">save</span>
                    Tambah Unit
                </button>
            </form>

            <hr class="my-8 border-t border-slate-200">

            <h2 class="text-xl font-bold mb-6 flex items-center">
                <span class="bg-[#F45B26] w-8 h-8 rounded-lg flex items-center justify-center text-white mr-3">
                    <span class="material-symbols-outlined text-lg">add</span>
                </span>
                Tambah Pelayanan
            </h2>
            
            <form action="{{ route('admin.pelayanan.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-slate-700 mb-2 font-semibold text-sm">Pilih Unit</label>
                    <select name="unit_id" required class="input-modern w-full px-4 py-3 rounded-xl appearance-none bg-white">
                        <option value="">-- Pilih Unit --</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->nama_unit }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-700 mb-2 font-semibold text-sm">Nama Pelayanan</label>
                    <input type="text" name="nama_pelayanan" required 
                           class="input-modern w-full px-4 py-3 rounded-xl"
                           placeholder="Contoh: Pendaftaran KRS, Pengajuan Beasiswa">
                </div>
                <div>
                    <label class="block text-slate-700 mb-2 font-semibold text-sm">Deskripsi</label>
                    <textarea name="deskripsi" rows="2" 
                              class="input-modern w-full px-4 py-3 rounded-xl"
                              placeholder="Jelaskan tentang pelayanan ini..."></textarea>
                </div>
                <button type="submit" class="btn-primary w-full text-white py-3 rounded-full font-semibold transition-all">
                    <span class="material-symbols-outlined text-sm mr-2">save</span>
                    Tambah Pelayanan
                </button>
            </form>
            
            <!-- Tips Card -->
            <div class="mt-6 p-4 bg-orange-50 rounded-xl">
                <div class="flex items-start space-x-3">
                    <span class="material-symbols-outlined text-[#F45B26] text-xl">lightbulb</span>
                    <div>
                        <h4 class="font-semibold text-slate-800">Tips:</h4>
                        <p class="text-sm text-slate-600">Tambahkan unit terlebih dahulu sebelum menambahkan pelayanan. Setiap unit dapat memiliki beberapa jenis pelayanan.</p>
                    </div>
                </div>
            </div>
            
            <!-- Quick Navigation -->
            <div class="mt-6 p-4 bg-orange-50 rounded-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <span class="material-symbols-outlined text-[#F45B26] text-xl">explore</span>
                        <span class="font-semibold text-slate-700">Navigasi Cepat:</span>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="text-[#F45B26] hover:text-[#d1430b] font-semibold text-sm flex items-center">
                        <span class="material-symbols-outlined text-sm mr-1">arrow_back</span>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Unit & Pelayanan - Right Column -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-[#E5E7EB] shadow-[0px_20px_40px_rgba(21,28,39,0.04)] p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div class="flex items-center space-x-3">
                    <h2 class="text-2xl font-bold text-[#151c27]">
                        Daftar Unit & Pelayanan
                    </h2>
                    
                    <!-- Tombol Kembali Kecil (Mobile) -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="md:hidden bg-orange-50 text-[#F45B26] px-3 py-2 rounded-lg text-sm flex items-center">
                        <span class="material-symbols-outlined text-sm mr-1">arrow_back</span>
                        Dashboard
                    </a>
                </div>
                
                <!-- Search Box -->
                <div class="search-box relative w-full md:w-auto">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400 text-lg">search</span>
                    <input type="text" id="searchInput" placeholder="Cari unit atau pelayanan..." 
                           class="pl-12 pr-4 py-2 border border-slate-200 rounded-full focus:border-[#F45B26] focus:outline-none w-full md:w-64 bg-slate-50">
                </div>
            </div>
            
            @if($units->isEmpty())
                <div class="empty-state text-center py-12">
                    <div class="text-6xl mb-4">🏢</div>
                    <h3 class="text-xl font-semibold text-slate-700 mb-2">Belum Ada Unit</h3>
                    <p class="text-slate-500">Mulai dengan menambahkan unit pertama Anda</p>
                    
                    <a href="{{ route('admin.dashboard') }}" 
                       class="inline-flex items-center mt-6 text-[#F45B26] hover:text-[#d1430b] font-semibold">
                        <span class="material-symbols-outlined text-sm mr-2">arrow_back</span>
                        Kembali ke Dashboard
                    </a>
                </div>
            @else
                <div class="space-y-6" id="unitsContainer">
                    @foreach($units as $unit)
                    <div class="unit-card p-6" data-unit-name="{{ strtolower($unit->nama_unit) }}">
                        <!-- Header Unit -->
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-start space-x-4">
                                <div class="bg-[#F45B26] w-14 h-14 rounded-xl flex items-center justify-center text-white shadow-md">
                                    <span class="material-symbols-outlined text-2xl">business</span>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-[#151c27]">{{ $unit->nama_unit }}</h3>
                                    <p class="text-slate-500 mt-1 text-sm">{{ $unit->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                                    <div class="flex items-center mt-2 space-x-2">
                                        <span class="badge-unit">
                                            <span class="material-symbols-outlined text-xs mr-1">list_alt</span>
                                            {{ $unit->pelayanans->count() }} Pelayanan
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <button onclick="editUnit({{ $unit->id }}, '{{ $unit->nama_unit }}', '{{ $unit->deskripsi }}')" 
                                        class="action-btn w-10 h-10 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center"
                                        title="Edit Unit">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </button>
                                <form action="{{ route('admin.units.delete', $unit) }}" method="POST" class="inline"
                                      onsubmit="return confirmDelete('unit', '{{ $unit->nama_unit }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="action-btn w-10 h-10 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all flex items-center justify-center"
                                            title="Hapus Unit">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Daftar Pelayanan -->
                        @if($unit->pelayanans->isNotEmpty())
                        <div class="ml-4 mt-4">
                            <h4 class="font-semibold text-slate-700 mb-3 flex items-center text-sm">
                                <span class="material-symbols-outlined text-[#F45B26] text-sm mr-2">list_alt</span>
                                Daftar Pelayanan:
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($unit->pelayanans as $pelayanan)
                                <div class="service-item p-4 flex justify-between items-center group"
                                     data-service-name="{{ strtolower($pelayanan->nama_pelayanan) }}">
                                    <div>
                                        <span class="font-semibold text-slate-800">{{ $pelayanan->nama_pelayanan }}</span>
                                        @if($pelayanan->deskripsi)
                                            <p class="text-sm text-slate-500 mt-1">{{ $pelayanan->deskripsi }}</p>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <button onclick="editPelayanan({{ $pelayanan->id }}, '{{ $pelayanan->nama_pelayanan }}', '{{ $pelayanan->deskripsi }}')" 
                                                class="text-blue-600 hover:text-blue-800 w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                                            <span class="material-symbols-outlined text-sm">edit</span>
                                        </button>
                                        <form action="{{ route('admin.pelayanan.delete', $pelayanan) }}" method="POST" class="inline"
                                              onsubmit="return confirmDelete('pelayanan', '{{ $pelayanan->nama_pelayanan }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center">
                                                <span class="material-symbols-outlined text-sm">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="ml-4 mt-4 p-4 bg-orange-50 rounded-xl border border-orange-100">
                            <div class="flex items-center">
                                <span class="material-symbols-outlined text-[#F45B26] mr-3">warning</span>
                                <p class="text-slate-600 text-sm">Belum ada pelayanan untuk unit ini. Tambahkan pelayanan menggunakan form di samping.</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            @endif
            
            <!-- Footer Navigation -->
            <div class="mt-8 pt-6 border-t border-slate-200 flex justify-between items-center">
                <a href="{{ route('admin.dashboard') }}" 
                   class="text-slate-600 hover:text-[#F45B26] transition flex items-center text-sm">
                    <span class="material-symbols-outlined text-sm mr-2">arrow_back</span>
                    Kembali ke Dashboard
                </a>
                
                <p class="text-sm text-slate-500 flex items-center">
                    <span class="material-symbols-outlined text-sm mr-1">info</span>
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
            <div class="bg-[#F45B26] w-12 h-12 rounded-xl flex items-center justify-center text-white mr-4">
                <span class="material-symbols-outlined text-xl">business</span>
            </div>
            <h3 class="text-2xl font-bold text-[#151c27]">Edit Unit</h3>
        </div>
        
        <form id="editUnitForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-slate-700 mb-2 font-semibold text-sm">Nama Unit</label>
                <input type="text" name="nama_unit" id="edit_nama_unit" required 
                       class="input-modern w-full px-4 py-3 rounded-xl">
            </div>
            
            <div class="mb-6">
                <label class="block text-slate-700 mb-2 font-semibold text-sm">Deskripsi</label>
                <textarea name="deskripsi" id="edit_deskripsi_unit" rows="3" 
                          class="input-modern w-full px-4 py-3 rounded-xl"></textarea>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeEditUnitModal()" 
                        class="px-6 py-3 bg-slate-100 text-slate-700 rounded-full hover:bg-slate-200 transition-all font-semibold">
                    Batal
                </button>
                <button type="submit" class="btn-primary px-6 py-3 text-white rounded-full font-semibold">
                    <span class="material-symbols-outlined text-sm mr-2">save</span>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Pelayanan -->
<div id="editPelayananModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="modal-content bg-white rounded-2xl p-8 w-96 max-w-full mx-4">
        <div class="flex items-center mb-6">
            <div class="bg-[#F45B26] w-12 h-12 rounded-xl flex items-center justify-center text-white mr-4">
                <span class="material-symbols-outlined text-xl">list_alt</span>
            </div>
            <h3 class="text-2xl font-bold text-[#151c27]">Edit Pelayanan</h3>
        </div>
        
        <form id="editPelayananForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-slate-700 mb-2 font-semibold text-sm">Nama Pelayanan</label>
                <input type="text" name="nama_pelayanan" id="edit_nama_pelayanan" required 
                       class="input-modern w-full px-4 py-3 rounded-xl">
            </div>
            
            <div class="mb-6">
                <label class="block text-slate-700 mb-2 font-semibold text-sm">Deskripsi</label>
                <textarea name="deskripsi" id="edit_deskripsi_pelayanan" rows="3" 
                          class="input-modern w-full px-4 py-3 rounded-xl"></textarea>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeEditPelayananModal()" 
                        class="px-6 py-3 bg-slate-100 text-slate-700 rounded-full hover:bg-slate-200 transition-all font-semibold">
                    Batal
                </button>
                <button type="submit" class="btn-primary px-6 py-3 text-white rounded-full font-semibold">
                    <span class="material-symbols-outlined text-sm mr-2">save</span>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Edit Unit Function
function editUnit(id, nama, deskripsi) {
    document.getElementById('editUnitForm').action = `/admin/units/${id}`;
    document.getElementById('edit_nama_unit').value = nama;
    document.getElementById('edit_deskripsi_unit').value = deskripsi || '';
    document.getElementById('editUnitModal').classList.remove('hidden');
    document.getElementById('editUnitModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeEditUnitModal() {
    document.getElementById('editUnitModal').classList.add('hidden');
    document.getElementById('editUnitModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Edit Pelayanan Function
function editPelayanan(id, nama, deskripsi) {
    document.getElementById('editPelayananForm').action = `/admin/pelayanan/${id}`;
    document.getElementById('edit_nama_pelayanan').value = nama;
    document.getElementById('edit_deskripsi_pelayanan').value = deskripsi || '';
    document.getElementById('editPelayananModal').classList.remove('hidden');
    document.getElementById('editPelayananModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeEditPelayananModal() {
    document.getElementById('editPelayananModal').classList.add('hidden');
    document.getElementById('editPelayananModal').classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Confirm Delete
function confirmDelete(type, name) {
    event.preventDefault();
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: `Apakah Anda yakin ingin menghapus ${type} "${name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#F45B26',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
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
        
        serviceItems.forEach(item => {
            const serviceName = item.dataset.serviceName;
            if (serviceName.includes(searchTerm)) {
                serviceMatch = true;
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
        
        if (unitMatch || serviceMatch) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
        
        if (unitMatch && !serviceMatch && searchTerm !== '') {
            serviceItems.forEach(item => item.style.display = 'flex');
        }
    });
});

// Close modal on outside click
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

// Success notification
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
</script>
@endpush