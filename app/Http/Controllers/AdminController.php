<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // 1. Tampilkan semua buku yang statusnya PENDING
    public function index()
    {
        $pendingBooks = Book::where('status', 'pending')->latest()->get();
        return view('admin.books.index', compact('pendingBooks'));
    }

    // 2. Action Approve
    public function approve($id)
    {
        $book = Book::findOrFail($id);
        $book->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Buku berhasil disetujui dan diterbitkan!');
    }

    // 3. Action Reject
    public function reject(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason // Admin bisa kasih alasan
        ]);

        return redirect()->back()->with('error', 'Buku ditolak.');
    }
}
