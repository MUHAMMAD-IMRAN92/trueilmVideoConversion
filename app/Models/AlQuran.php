<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlQuran extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'al_quran';
    public function translations()
    {
        return $this->hasMany(AlQuranTranslation::class, 'ayat_id', 'id');
    }
}
