<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class AuthorLanguage extends Eloquent
{
    use HasFactory;
    protected $guarded = [];

    public function author()
    {
        return $this->hasOne(Author::class, '_id', 'author_id');
    }
    public function language()
    {
        return $this->hasOne(Languages::class, '_id', 'lang_id');
    }
    public function translations()
    {
        return $this->hasMany(AlQuranTranslation::class, 'author_lang', '_id');
    }
}
