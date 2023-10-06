<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Languages extends Eloquent
{
    use HasFactory;
    public function user()
    {
        return $this->hasOne(User::class, '_id', 'added_by');
    }
}
