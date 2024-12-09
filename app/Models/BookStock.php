<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookStock extends Model {
    use HasFactory;

    protected $fillable = [
        'entity_id',
        'title',
        'author',
        'isbn',
        'published_date',
        'quantity',
        'description',
    ];
}
