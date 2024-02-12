<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class HadeesTranslation extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'new_hadees_translations';
    protected $appends = ['lang_title'];

    public function getLangTitleAttribute()
    {
        // return $this->added_by;
        $lang = Languages::where('_id', $this->lang)->first();

        return @$lang->title;
    }
    public function scopeTranslation($query)
    {
        return $query->where('type', 1);
    }
    public function Hadith()
    {
        return $this->belongsTo(Hadees::class, '_id', 'hadees_id');
    }
}
