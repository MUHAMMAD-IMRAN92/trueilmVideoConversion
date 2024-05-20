<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class AppVersion extends Eloquent
{
    use HasFactory;
    protected $table = 'app_versions';
}
