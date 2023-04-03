<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlQuranTranslation extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'users';
}
