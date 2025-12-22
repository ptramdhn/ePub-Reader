<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingProgress extends Model
{
    protected $table = 'reading_progresses';

    protected $fillable = ['user_id', 'book_id', 'last_cfi', 'percentage', 'total_seconds'];

    // Relasi ke Buku
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
