<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Tafseer extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';

    protected $appends = ['lang_title'];

    public function getLangTitleAttribute()
    {
        // return $this->added_by;
        $lang = Languages::where('_id', $this->lang)->first();

        return @$lang->title;
    }
}
