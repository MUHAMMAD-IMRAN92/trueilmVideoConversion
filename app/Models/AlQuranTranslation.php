<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlQuranTranslation extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'al_quran_translations';
    protected $appends = ['lang_title'];

    public function getLangTitleAttribute()
    {
        // return $this->added_by;
        $lang = Languages::where('_id', $this->lang)->first();

        return @$lang->title;
    }
    public function ayats()
    {
        return $this->belongsTo(AlQuran::class, 'ayat_id', '_id');
    }
    public function scopeTranslation($query)
    {
        return $query->where('type', 1);
    }
    public function scopeTafseer($query)
    {
        return $query->where('type', 2);
    }
}
