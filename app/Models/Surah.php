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
    public  function getCombinationTranslationsAttribute()
    {
        $count = 0;
        $ayats = AlQuran::where('surah_id', $this->_id)->count();

        $authorLang =   AuthorLanguage::get();
        foreach ($authorLang as $authLang) {
            $authLangCount =  AlQuranTranslation::whereHas('ayats', function ($q) {
                $q->where('surah_id', $this->_id);
            })->translation()->where('author_lang', $authLang->_id)->whereNotNull('translation')->count();

            if ($ayats != 0 && $ayats == $authLangCount) {
                $count += 1;
            }
        }
        return $count;
    }
}
