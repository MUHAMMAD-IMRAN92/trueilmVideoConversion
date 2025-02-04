<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class BookMistake extends Eloquent
{
    use HasFactory;
    public function book()
    {
        return $this->hasOne(Book::class, '_id', 'book_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, '_id', 'user_id');
    }
}
