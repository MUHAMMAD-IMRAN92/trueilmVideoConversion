<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Grant extends Eloquent
{
    use HasFactory;

    protected $appends = ['user_name', 'approver_name'];
    protected $guarded = [];
    public function getUserNameAttribute()
    {
        // return $this->added_by;
        $user = User::where('_id', $this->user_id)->first();

        return @$user->name;
    }

    public function getApproverNameAttribute()
    {
        // return $this->added_by;
        $user = User::where('_id', $this->approved_by)->first();

        return @$user->name;
    }
    public function scopeRejected($query)
    {
        return $query->where('status', 2);
    }
    public function scopeApproved($query)
    {
        return $query->where('status', 1);
    }
}
