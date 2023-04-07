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
}
