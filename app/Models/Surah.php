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
    // protected $appends = ['combination_translations'];
    public function ayats()
    {
        return $this->hasMany(AlQuran::class, 'surah_id', 'id');
    }
    // public  function getCombinationTranslationsAttribute()
    // {

    //     return $count;
    // }
}
