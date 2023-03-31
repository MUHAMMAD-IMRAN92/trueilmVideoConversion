<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlQuran extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';

    public function translations()
    {
        return $this->hasMany(AlQuranTranslation::class, 'ayat_id' , 'id');
    }
}
