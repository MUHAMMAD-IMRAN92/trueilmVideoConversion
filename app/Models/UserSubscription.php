<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class UserSubscription extends Eloquent
{
    use HasFactory;
    protected $table = 'usersubcriptions';
}
