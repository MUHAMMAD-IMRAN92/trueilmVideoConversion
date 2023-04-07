<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hadees extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'hadees';
    public function translations()
    {
        return $this->hasMany(HadeesTranslation::class, 'hadees_id', 'id');
    }
}
