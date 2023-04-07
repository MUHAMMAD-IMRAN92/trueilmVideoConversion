<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HadeesTranslation extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'hadees_translations';
}
