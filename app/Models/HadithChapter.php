<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class HadithChapter extends Eloquent
{
    use HasFactory;
    protected $table = "new_hadees_chapters";

    public function hadees()
    {
        return $this->hasMany(Hadees::class, 'chapter_id', '_id');
    }
}
