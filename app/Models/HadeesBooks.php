<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class HadeesBooks extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    public function hadees()
    {
        return $this->hasMany(Hadees::class, 'book_id', '_id');
    }
    public function introduction()
    {
        return $this->hasOne(HadeesTranslation::class, 'book_id', 'id');
    }
}
