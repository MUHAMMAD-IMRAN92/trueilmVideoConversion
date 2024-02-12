<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Hadees extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'new_hadees';
    public function translations()
    {
        return $this->hasMany(HadeesTranslation::class, 'hadees_id', 'id');
    }
    public function references()
    {
        return $this->hasMany(Reference::class, 'referal_id', 'id');
    }
    public function revelation()
    {
        return $this->hasMany(HadeesTranslation::class, 'hadees_id', 'id');
    }
    public function notes()
    {
        return $this->hasMany(HadeesTranslation::class, 'hadees_id', 'id');
    }
}
