<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class HadeesTranslation extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'hadees_translations';
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
    public  function mainChapter()
    {
        $chapterId = $this->chapter_id;
        $chapter   =     HadithChapter::where('_id', $chapterId)->first();
        if ($chapter) {
            return $chapter->parent_id;
        }
    }
    public  function author()
    {
        $author_lang = $this->author_lang;
        $author   =     AuthorLanguage::where('_id', $author_lang)->first();
        if ($author) {
            return $author->author_id;
        }
    }
    public  function language()
    {
        $author_lang = $this->author_lang;
        $author   =     AuthorLanguage::where('_id', $author_lang)->first();
        if ($author) {
            return $author->lang_id;
        }
    }
}
