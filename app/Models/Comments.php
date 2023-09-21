<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Comments extends Eloquent
{
    use HasFactory;
    protected $table = 'reviews';
    public function book()
    {
        return $this->hasOne(Book::class, '_id', 'book_id');
    }
}
