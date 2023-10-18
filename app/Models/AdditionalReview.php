<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class AdditionalReview extends Eloquent
{
    use HasFactory;
    protected $table = 'reviewbooks';
    protected $appends = ['user_name'];
    public function getUserNameAttribute()
    {
        $user = User::where('_id', $this->user_id)->first();

        return @$user->name;
    }
    public function book()
    {
        return $this->hasOne(Book::class, '_id', 'book_id');
    }
}
