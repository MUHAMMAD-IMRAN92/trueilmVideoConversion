<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Permission extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'permissions';
}
