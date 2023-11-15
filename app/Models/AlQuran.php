<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlQuran extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'al_qurans';

    protected $appends = ['para_title'];


    public function translations()
    {
        return $this->hasMany(AlQuranTranslation::class, 'ayat_id', 'id');
    }
    public function revelation()
    {
        return $this->hasMany(AlQuranTranslation::class, 'ayat_id', 'id');
    }
    public function notes()
    {
        return $this->hasMany(AlQuranTranslation::class, 'ayat_id', 'id');
    }
    public function references()
    {
        return $this->hasMany(Reference::class, 'referal_id', 'id');
    }
    public function tafseers()
    {
        return $this->hasMany(Tafseer::class, 'ayat_id', 'id');
    }
    public function getParaTitleAttribute()
    {
        // return $this->added_by;
        $juz = Juz::where('_id', $this->para_no)->first();

        return @$juz->juz;
    }
    public function surah()
    {
        return $this->belongsTo(Surah::class, 'surah_id', '_id');
    }
    public function khatoot()
    {
        return $this->hasMany(Khatoot::class, 'alQuran_id', '_id');
    }
}
