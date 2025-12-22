<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Bookmark;
use App\Models\Highlight;
use App\Models\ReadingProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Tampilkan Daftar Buku (Halaman Depan Library)
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Ambil Mode dari Session (Reader/Creator/Admin)
        $mode = session('dashboard_mode', 'reader'); 

        // --- LOGIC STATISTIK READER (YANG KAMU TANYAKAN) ---
        
        // 1. Ambil semua progress baca user ini
        $userProgress = ReadingProgress::where('user_id', $user->id)->get();

        // 2. Hitung total detik
        $totalSeconds = $userProgress->sum('total_seconds');

        // 3. Konversi ke Jam dengan Desimal (PENTING)
        // number_format(angka, jumlah_desimal)
        // Contoh: 5400 detik / 3600 = 1.50 Jam
        $totalHours = number_format($totalSeconds / 3600, 2); 

        // 4. Siapkan Array Stats
        $stats = [
            // Statistik Reader
            'total_hours'  => $totalHours, // <--- HASIL DESIMAL DISIMPAN DI SINI
            'books_read'   => $userProgress->count(),
            'avg_progress' => round($userProgress->avg('percentage') ?? 0, 0),

            // Statistik Creator/Admin (Biarkan tetap ada agar tidak error)
            'total_users'   => User::count(),
            'total_uploads' => Book::count(), // Sesuaikan filter jika perlu
            'approved'      => Book::where('status', 'approved')->count(),
            'rejected'      => Book::where('status', 'rejected')->count(),
            'pending'       => Book::where('status', 'pending')->count(),
        ];

        // Query Buku (Sesuaikan dengan logic dashboard kamu sebelumnya)
        $books = Book::latest()->take(5)->get(); 

        return view('dashboard', compact('stats', 'books', 'mode'));
    }

    // 2. Proses Simpan Data ke Database & Server
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string',
            'cover' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            'file_epub' => 'required|file|mimes:epub|max:10240', // Max 10MB, Wajib .epub
        ]);

        // Upload Cover
        $coverPath = $request->file('cover')->store('covers', 'public');

        // Upload File Epub
        $epubPath = $request->file('file_epub')->store('books', 'public');

        // Simpan ke Database
        Book::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'author' => $request->author,
            'category' => $request->category,
            'cover_path' => $coverPath,
            'file_path' => $epubPath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Buku berhasil diupload!');
    }

    // --- [MODIFIKASI] Method ini tetap ada untuk tracking waktu (jika Anda pakai timer) ---
    public function trackProgress(Request $request, Book $book)
    {
        // Validasi data yang dikirim dari JS
        $request->validate([
            'cfi' => 'required|string',
            'percentage' => 'required|numeric',
            'seconds' => 'required|integer', 
        ]);

        $progress = ReadingProgress::firstOrCreate(
            ['user_id' => Auth::id(), 'book_id' => $book->id]
        );

        $progress->last_cfi = $request->cfi;
        $progress->percentage = $request->percentage;
        $progress->total_seconds += $request->seconds;
        $progress->save();

        return response()->json(['status' => 'success']);
    }

    // --- [BARU] Method khusus untuk menyimpan Lokasi Terakhir (History) ---
    // Ini dipanggil saat user scroll/pindah bab di read.blade.php
    public function saveHistory(Request $request, $id)
    {
        // 1. Validasi input dari JavaScript
        $request->validate([
            'last_location' => 'required|string',
            'percentage'    => 'required|numeric', // Terima persentase
            'duration'      => 'nullable|integer', // Terima durasi (detik)
        ]);

        // 2. Cari atau Buat Progress Baru
        $progress = ReadingProgress::firstOrNew([
            'user_id' => Auth::id(),
            'book_id' => $id
        ]);

        // 3. Update Data
        $progress->last_cfi = $request->last_location;
        $progress->percentage = $request->percentage; // Simpan progres %
        
        // Tambahkan durasi baru ke total durasi yang sudah ada
        // (total_seconds harus ada di database tabel reading_progress)
        $progress->total_seconds = ($progress->total_seconds ?? 0) + ($request->duration ?? 0);
        
        $progress->updated_at = now();
        $progress->save();

        return response()->json(['status' => 'success']);
    }

    // API untuk mengambil statistik realtime
    public function getStats()
    {
        $user_id = auth()->id();
        $userProgress = ReadingProgress::where('user_id', $user_id)->get();

        $totalSeconds = $userProgress->sum('total_seconds');

        return response()->json([
            // UBAH BARIS INI:
            // Gunakan number_format untuk memaksa 2 angka di belakang koma (misal: 1.25)
            // Parameter: (angka, jumlah_desimal)
            'total_hours' => number_format($totalSeconds / 3600, 2), 
            
            'books_read' => $userProgress->count(),
            'avg_progress' => round($userProgress->avg('percentage') ?? 0, 0)
        ]);
    }

    // 1. TAMPILKAN FORM EDIT
    public function edit(Book $book)
    {
        if ($book->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit buku ini.');
        }
        return view('books.edit', compact('book'));
    }

    // 2. PROSES UPDATE (RE-SUBMIT)
    public function update(Request $request, Book $book)
    {
        if ($book->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string',
            'cover' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            if ($book->cover_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($book->cover_path);
            }
            $coverPath = $request->file('cover')->store('covers', 'public');
            $book->cover_path = $coverPath;
        }

        $book->title = $request->title;
        $book->author = $request->author;
        $book->category = $request->category;
        $book->status = 'pending';
        $book->rejection_reason = null;

        $book->save();

        return redirect()->route('dashboard')->with('success', 'Buku berhasil diperbarui dan dikirim ulang untuk review Admin.');
    }

    // 3. HAPUS BUKU
    public function destroy(Book $book)
    {
        if ($book->user_id !== auth()->id()) {
            abort(403);
        }

        if ($book->cover_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($book->cover_path);
        }
        if ($book->file_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($book->file_path);
        }

        $book->delete();

        return redirect()->route('dashboard')->with('success', 'Buku berhasil dihapus permanen.');
    }

    /**
     * Menampilkan halaman baca buku (Reader)
     */
    public function read(Book $book)
    {
        // 1. LOGIKA PERIZINAN
        $isOwner = $book->user_id === Auth::id();
        $isApproved = $book->status === 'approved';
        $isAdmin = Auth::user()->is_admin ?? false; // Tambahkan fallback false jika kolom belum ada

        if (! ($isApproved || $isOwner || $isAdmin)) {
            abort(403, 'BUKU INI BELUM DITERBITKAN DAN ANDA BUKAN PEMILIKNYA.');
        }

        // 2. AMBIL DATA BOOKMARK & HIGHLIGHT
        $bookmarks = Bookmark::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->get();

        $highlights = Highlight::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->get();

        // --- [DIUBAH & DITAMBAHKAN] Logika Ambil Lokasi Terakhir ---
        // Kita cari progress user untuk buku ini
        $progress = ReadingProgress::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->first();
        
        // Ambil kolom 'last_cfi' jika ada, jika tidak null
        $lastLocation = $progress ? $progress->last_cfi : null;

        // 3. TAMPILKAN VIEW (Kirim variabel $lastLocation ke view)
        return view('books.read', compact('book', 'bookmarks', 'highlights', 'lastLocation'));
    }

    /**
     * API: Simpan Bookmark
     */
    public function saveBookmark(Request $request, $id)
    {
        Bookmark::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'book_id' => $id,
                'cfi' => $request->cfi
            ],
            ['label' => $request->label ?? 'Halaman Ditandai']
        );

        return response()->json(['status' => 'success']);
    }

    /**
     * API: Simpan Highlight
     */
    public function saveHighlight(Request $request, $id)
    {
        Highlight::create([
            'user_id' => Auth::id(),
            'book_id' => $id,
            'cfi_range' => $request->cfi_range,
            'selected_text' => $request->text,
            'color' => $request->color ?? 'yellow',
            'note' => $request->note
        ]);

        return response()->json(['status' => 'success']);
    }
}