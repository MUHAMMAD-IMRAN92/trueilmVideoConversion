<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class UserSubscription extends Eloquent
{
    use HasFactory;
    protected $table = 'user_subcriptions';
    public function plan()
    {
        return $this->hasMany(Subscription::class, 'plan_id', '_id');
    }
}
