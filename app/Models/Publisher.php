<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Publisher extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'publishers';


    public function scopeActive($query)
    {
        return $query->where('status', 0);
    }
}
