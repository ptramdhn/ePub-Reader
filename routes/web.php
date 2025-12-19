<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

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
        // Ambil buku yang di-upload oleh user yang sedang login, urutkan dari yang terbaru
        $books = Book::where('user_id', Auth::id())->latest()->get();

        return view('dashboard', compact('books'));
    })->name('dashboard');

    // Route untuk upload Buku
    Route::get('/books/upload', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');

    // Route Baca Buku
    Route::get('/books/{book}/read', function (Book $book) {
        return view('books.read', compact('book'));
    })->name('books.read');
});
