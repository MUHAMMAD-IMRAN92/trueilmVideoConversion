<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class Surah extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'surahs';
    protected $appends = ['combination_translations'];

    public function ayats()
    {
        return $this->hasMany(AlQuran::class, 'surah_id', 'id');
    }
    public function translations()
    {
        return $this->hasMany(AlQuranTranslation::class, 'surah_id', '_id');
    }
    public  function getCombinationTranslationsAttribute()
    {
        // $count = \DB::table('author_languages')
        //     ->select(\DB::raw('SUM(CASE WHEN aq.translations_count = ? THEN 1 ELSE 0 END) AS count_matched'), 'al._id', 'al.name')
        //     ->leftJoin('alquran_translations as aq', function ($join)  {
        //         $join->on('author_languages._id', '=', 'aq.author_lang')
        //             ->where('aq.surah_id', '=', $this->_id)
        //             ->whereNotNull('aq.translation');
        //     })->groupBy('author_languages._id', 'author_languages.name')
        //     ->get();
        // $counts = DB::table('author_languages')
        //     ->select('author_languages._id', 'author_languages.name')
        //     ->selectRaw('COUNT(CASE WHEN aq.surah_id = ? AND aq.translation IS NOT NULL THEN 1 END) as count_matched', [$this->_id])
        //     ->leftJoin('alquran_translations as aq', function ($join) {
        //         $join->on('author_languages._id', '=', 'aq.author_lang');
        //         $join->where('aq.surah_id', '=', $this->_id);
        //     })
        //     ->groupBy('author_languages._id', 'author_languages.name')
        //     ->havingRaw('count_matched = (SELECT COUNT(*) FROM alquran WHERE surah_id = ?)', [$this->_id])
        //     ->get();

        // return $counts;
    }
    // public  function getCombinationTranslationsAttribute()
    // {
    //     $count = 0;
    //     // $ayats = AlQuran::where('surah_id', $this->_id)->count();
    //     // $ayats = AlQuranTranslation::where('surah_id', $this->_id)->get();
    //     // return $trans = AlQuranTranslation::where('surah_id', $this->_id)->groupBy('author_lang')->get();

    //     // $authorLang =   AuthorLanguage::get();

    //     return $count;
    // }
}
