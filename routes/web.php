<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk ganti bahasa
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        Session::put('locale', $locale); // Simpan pilihan di Session
    }
    return redirect()->back(); // Kembali ke halaman sebelumnya
})->name('lang.switch');

// Guest only (belum login)
Route::middleware('guest')->group(function () { // <--- Tambahkan Route::
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated only (sudah login)
Route::middleware('auth')->group(function () { // <--- Tambahkan Route::
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', function () {
        return view('dashboard'); 
    })->name('dashboard');
});