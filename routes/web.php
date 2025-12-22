<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use App\Models\Book;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. HALAMAN PUBLIK (Bisa diakses siapa saja) ---

Route::get('/', function () {
    // Ambil 5 buku terbaru yang SUDAH DI-APPROVE admin
    $latestBooks = \App\Models\Book::where('status', 'approved')
        ->latest()
        ->take(5)
        ->get();

    return view('welcome', compact('latestBooks'));
})->name('home');

// Route Ganti Bahasa
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');


// --- 2. HALAMAN TAMU (Hanya untuk yang BELUM login) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware(['auth'])->group(function () {
    
    // ... route lainnya ...

    // Route untuk Dashboard Statistik
    Route::get('/api/stats', [BookController::class, 'getStats'])->name('api.stats');

    // Route untuk Save History (Pastikan ini juga ada)
    Route::post('/books/{book}/history', [BookController::class, 'saveHistory'])->name('books.history');
});

// --- 3. HALAMAN USER & UMUM (Wajib Login) ---
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 1. Route untuk Switch Mode (Reader <-> Creator)
    Route::get('/dashboard/mode/{mode}', function ($mode) {
        if (in_array($mode, ['reader', 'creator'])) {
            session(['dashboard_mode' => $mode]); // Simpan mode di session
        }
        return redirect()->route('dashboard');
    })->name('dashboard.mode');

    // Dashboard User
    Route::get('/dashboard/mode/{mode}', function ($mode) {
        // Cek Security: Hanya Admin boleh pilih mode admin
        if ($mode === 'admin' && !auth()->user()->is_admin) {
            abort(403);
        }

        if (in_array($mode, ['reader', 'creator', 'admin'])) {
            session(['dashboard_mode' => $mode]);
        }
        return redirect()->route('dashboard');
    })->name('dashboard.mode');

    // History Baca Buku
    Route::post('/books/{book}/history', [App\Http\Controllers\BookController::class, 'saveHistory'])->name('books.history');

    // Halaman Pustaka (Library) dengan Live Search
    Route::get('/library', function (\Illuminate\Http\Request $request) {

        $query = Book::where('status', 'approved');

        // Logika Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $books = $query->latest()->paginate(12);

        // JIKA AJAX (Request dari Javascript Live Search), kembalikan potongan HTML saja
        if ($request->ajax()) {
            return view('components.books-list', compact('books'))->render();
        }

        // Jika request biasa (Refresh halaman), kembalikan halaman penuh
        return view('books.index', compact('books'));
    })->name('books.index');

    // Route Dashboard Utama
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $mode = session('dashboard_mode', 'reader');

        // 1. Security Fallback: Jika mode admin tapi user bukan admin, paksa jadi reader
        if ($mode === 'admin' && !$user->is_admin) {
            $mode = 'reader';
            session(['dashboard_mode' => 'reader']);
        }

        $stats = [];
        $books = collect(); // Default kosong

        // 2. Logika Berdasarkan Mode
        switch ($mode) {
            case 'admin':
                // --- MODE ADMIN ---
                // Statistik Global System
                $stats = [
                    'total_users'   => \App\Models\User::count(),
                    'total_uploads' => Book::count(),
                    'approved'      => Book::where('status', 'approved')->count(),
                    'rejected'      => Book::where('status', 'rejected')->count(),
                ];
                // Data Utama: Antrean Review (Pending) + Info Usernya
                $books = Book::where('status', 'pending')->with('user')->latest()->get();
                break;

            case 'creator':
                // --- MODE KREATOR ---
                // Ambil semua buku upload-an user ini
                $books = Book::where('user_id', $user->id)->latest()->get();

                // Hitung statistik dari koleksi di atas (biar hemat query)
                $stats = [
                    'total_uploads' => $books->count(),
                    'approved'      => $books->where('status', 'approved')->count(),
                    'pending'       => $books->where('status', 'pending')->count(),
                    'rejected'      => $books->where('status', 'rejected')->count(),
                ];
                break;

            default:
                // --- MODE PEMBACA (Default) ---

                // A. Ambil Riwayat Baca (Maksimal 10 Terakhir)
                $recentProgress = \App\Models\ReadingProgress::where('user_id', $user->id)
                    ->with('book')          // Eager load data buku
                    ->latest('updated_at')  // Urutkan dari yang terakhir dibuka
                    ->take(10)              // Batasi 10
                    ->get();

                // Ekstrak objek 'book' dari reading_progress
                // filter() membuang data null (misal buku sudah dihapus tapi history masih ada)
                $books = $recentProgress->map(fn($p) => $p->book)->filter();

                // B. Hitung Statistik Total (Perlu query semua, bukan cuma 10)
                $allProgress = \App\Models\ReadingProgress::where('user_id', $user->id)->get();

                $stats = [
                    'total_hours'  => round($allProgress->sum('total_seconds') / 3600, 1),
                    'books_read'   => $allProgress->count(),
                    'avg_progress' => round($allProgress->avg('percentage') ?? 0, 0),
                ];
                break;
        }

        return view('dashboard', compact('books', 'mode', 'stats'));
    })->name('dashboard');

    // Fitur Upload Buku
    Route::get('/books/upload', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');

    // --- API untuk Reader (Bookmark & Highlight) ---
    Route::post('/books/{id}/bookmark', [BookController::class, 'saveBookmark'])->name('books.bookmark');
    Route::post('/books/{id}/highlight', [BookController::class, 'saveHighlight'])->name('books.highlight');

    // --- Halaman Baca Buku ---
    Route::get('/books/{book}/read', [BookController::class, 'read'])->name('books.read');

    Route::post('/books/{book}/track', [BookController::class, 'trackProgress'])->name('books.track');

    // API Statistik Realtime
    Route::get('/api/my-stats', [BookController::class, 'getStats'])->name('api.stats');

    // CRUD Buku (Edit & Delete)
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update'); // Pakai PUT untuk update
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy'); // Pakai DELETE untuk hapus

    // Route Profil
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});


// --- 4. HALAMAN ADMIN (Wajib Login & Wajib Admin) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/books', [AdminController::class, 'index'])->name('admin.books.index');
    Route::post('/books/{id}/approve', [AdminController::class, 'approve'])->name('admin.books.approve');
    Route::post('/books/{id}/reject', [AdminController::class, 'reject'])->name('admin.books.reject');
});
