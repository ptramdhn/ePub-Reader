<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'author',
        'category',
        'cover_path',
        'file_path',
        'status',
        'rejection_reason',
    ];

    // Scope Helper 
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Relasi: Buku dimiliki oleh User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
