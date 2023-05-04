<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Category extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'categories';
    protected $guarded = [];


    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
