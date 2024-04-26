<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Scopes\DeletedAtScope as ScopesDeletedAtScope;

class UserSubscription extends Eloquent
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_subcriptions';
    public function plan()
    {
        return $this->hasOne(Subscription::class, '_id', 'plan_id');
    }
    protected static function booted()
    {
        static::addGlobalScope(new ScopesDeletedAtScope);
    }
}
