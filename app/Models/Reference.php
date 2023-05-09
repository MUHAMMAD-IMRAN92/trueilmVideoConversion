<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Reference extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'references';
}
