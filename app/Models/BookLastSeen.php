<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class BookLastSeen extends Eloquent
{
    use HasFactory;

    protected $table = 'lastseenbooks';

    public function book()
    {
        return $this->hasOne(Book::class, 'book_id', '_id');
    }
}
