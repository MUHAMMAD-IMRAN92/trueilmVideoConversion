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


    protected $appends = ['user_name'];
    public function getUserNameAttribute()
    {
        // return $this->added_by;
        $user = User::where('_id', $this->user_id)->first();

        return @$user->name;
    }
}
