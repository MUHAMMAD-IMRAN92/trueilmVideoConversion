<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Activities extends Eloquent
{
    use HasFactory;
    protected $appends = ['user_name'];
    public function getUserNameAttribute()
    {
        $user = User::where('_id', $this->user_id)->first();

        return @$user->name;
    }
}
