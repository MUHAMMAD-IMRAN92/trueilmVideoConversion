<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ReviewBook extends Eloquent
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class, '_id', 'user_id');
    }
    public function reviewer()
    {
        return $this->hasOne(User::class, '_id', 'reviwed_by');
    }
}
