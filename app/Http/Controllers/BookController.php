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
    // ==========================================
    // 1. HALAMAN DEPAN & UPLOAD
    // ==========================================

    // Menampilkan daftar buku (Explore Library)
    public function index(Request $request)
    {
        $query = Book::where('status', 'approved')->with('user');

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%');
        }

        $books = $query->latest()->paginate(12);
        return view('books.index', compact('books'));
    }

    // Menampilkan Form Upload (INI YANG TADI ERROR)
    public function create()
    {
        return view('books.create');
    }

    // Proses Simpan Buku
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string',
            'cover' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'file_epub' => 'required|file|mimes:epub|max:10240',
        ]);

        $coverPath = $request->file('cover')->store('covers', 'public');
        $epubPath = $request->file('file_epub')->store('books', 'public');

        Book::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'author' => $request->author,
            'category' => $request->category,
            'cover_path' => $coverPath,
            'file_path' => $epubPath,
            'status' => 'pending', // Default pending
        ]);

        return redirect()->route('dashboard')->with('success', 'Buku berhasil diupload!');
    }

    // ==========================================
    // 2. READER & PROGRESS (INTI FITUR)
    // ==========================================

    public function read(Book $book)
    {
        // Cek Izin Akses
        $isOwner = $book->user_id === Auth::id();
        $isApproved = $book->status === 'approved';
        $isAdmin = Auth::user()->is_admin ?? false;

        if (! ($isApproved || $isOwner || $isAdmin)) {
            abort(403, 'Buku ini belum diterbitkan.');
        }

        // Ambil Data Pendukung
        $bookmarks = Bookmark::where('user_id', Auth::id())->where('book_id', $book->id)->get();
        $highlights = Highlight::where('user_id', Auth::id())->where('book_id', $book->id)->get();
        
        // Ambil Lokasi Terakhir Baca
        $progress = ReadingProgress::where('user_id', Auth::id())->where('book_id', $book->id)->first();
        $lastLocation = $progress ? $progress->last_cfi : null;

        return view('books.read', compact('book', 'bookmarks', 'highlights', 'lastLocation'));
    }

    // API: Simpan History, Persentase, dan Waktu Baca
    public function saveHistory(Request $request, $id)
    {
        $request->validate([
            'last_location' => 'required|string',
            'percentage'    => 'required|numeric',
            'duration'      => 'nullable|integer',
        ]);

        $progress = ReadingProgress::firstOrNew([
            'user_id' => Auth::id(),
            'book_id' => $id
        ]);

        $progress->last_cfi = $request->last_location;
        $progress->percentage = $request->percentage;
        // Tambahkan durasi baru ke total yang sudah ada
        $progress->total_seconds = ($progress->total_seconds ?? 0) + ($request->duration ?? 0);
        
        $progress->updated_at = now();
        $progress->save();

        return response()->json(['status' => 'success']);
    }

    // API: Ambil Statistik Realtime (Untuk Dashboard)
    public function getStats()
    {
        $user_id = auth()->id();
        $userProgress = ReadingProgress::where('user_id', $user_id)->get();
        $totalSeconds = $userProgress->sum('total_seconds');

        return response()->json([
            'total_hours' => number_format($totalSeconds / 3600, 2), // Format Desimal 2 digit
            'books_read' => $userProgress->count(),
            'avg_progress' => round($userProgress->avg('percentage') ?? 0, 0)
        ]);
    }

    // ==========================================
    // 3. FITUR TAMBAHAN (EDIT, HAPUS, BOOKMARK)
    // ==========================================

    public function edit(Book $book)
    {
        if ($book->user_id !== auth()->id()) abort(403);
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        if ($book->user_id !== auth()->id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string',
            'cover' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            if ($book->cover_path) Storage::disk('public')->delete($book->cover_path);
            $book->cover_path = $request->file('cover')->store('covers', 'public');
        }

        $book->title = $request->title;
        $book->author = $request->author;
        $book->category = $request->category;
        $book->status = 'pending'; 
        $book->save();

        return redirect()->route('dashboard')->with('success', 'Buku diperbarui.');
    }

    public function destroy(Book $book)
    {
        if ($book->user_id !== auth()->id()) abort(403);

        if ($book->cover_path) Storage::disk('public')->delete($book->cover_path);
        if ($book->file_path) Storage::disk('public')->delete($book->file_path);
        
        $book->delete();
        return redirect()->route('dashboard')->with('success', 'Buku dihapus.');
    }

    public function saveBookmark(Request $request, $id)
    {
        Bookmark::updateOrCreate(
            ['user_id' => Auth::id(), 'book_id' => $id, 'cfi' => $request->cfi],
            ['label' => $request->label ?? 'Halaman Ditandai']
        );
        return response()->json(['status' => 'success']);
    }

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