<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ===== Publik =====
// Beranda sementara (halaman bawaan Laravel). Akan diganti di Task 3.
Route::view('/', 'welcome')->name('home');

// ===== Pelanggan (wajib login) =====
Route::middleware('auth')->group(function () {
    // Breeze masih memakai nama route 'dashboard' di beberapa link,
    // jadi kita alihkan saja ke beranda supaya tidak error.
    Route::get('/dashboard', fn () => redirect()->route('home'))->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===== Admin (wajib login + harus admin) =====
// prefix('admin')  → semua URL diawali /admin
// name('admin.')   → semua nama route diawali admin. (contoh: admin.dashboard)
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::view('/', 'admin.dashboard')->name('dashboard');
    });

// Route login/register/lupa password dari Breeze
require __DIR__.'/auth.php';
