<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Surah extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'surahs';

    public function ayats()
    {
        return $this->hasMany(AlQuran::class, 'surah_id', 'id');
    }
}
