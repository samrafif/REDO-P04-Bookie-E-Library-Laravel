<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'book_name',
        'book_isbn',
        'book_desc',
        'book_category',
        'book_leaser',
        'book_lease_end_date',
        'book_cover',
        'book_publisher'
    ];

    public function publisher()
    {
        return $this->belongsTo(User::class, 'book_publisher');
    }
}
