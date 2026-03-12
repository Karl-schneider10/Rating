<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;

// Halaman utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rating (tanpa login)
Route::post('/rating', [RatingController::class, 'store'])->name('rating.store');
Route::get('/get-pelayanan/{unitId}', [RatingController::class, 'getPelayanan'])->name('get.pelayanan');

// Login admin
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin routes (perlu login)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/rating/{rating}/balas', [AdminController::class, 'balas'])->name('rating.balas');
    
    
    // Manajemen Unit
    Route::get('/units', [AdminController::class, 'units'])->name('units');
    Route::post('/units', [AdminController::class, 'storeUnit'])->name('units.store');
    Route::put('/units/{unit}', [AdminController::class, 'updateUnit'])->name('units.update');
    Route::delete('/units/{unit}', [AdminController::class, 'deleteUnit'])->name('units.delete');
    
    // Manajemen Pelayanan
    Route::post('/pelayanan', [AdminController::class, 'storePelayanan'])->name('pelayanan.store');
    Route::put('/pelayanan/{pelayanan}', [AdminController::class, 'updatePelayanan'])->name('pelayanan.update');
    Route::delete('/pelayanan/{pelayanan}', [AdminController::class, 'deletePelayanan'])->name('pelayanan.delete');
});