<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Hadees extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'hadees';
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
    public function book()
    {
        return $this->hasOne(HadeesBooks::class, '_id', 'book_id');
    }
    public function chapter()
    {
        return $this->hasOne(HadithChapter::class, '_id', 'chapter_id');
    }

}
