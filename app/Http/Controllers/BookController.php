<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // 1. Tampilkan Form Upload
    public function create()
    {
        return view('books.create');
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
}
