<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Grant extends Eloquent
{
    use HasFactory;

    // protected $appends = ['user_name', 'approver_name'];
    protected $guarded = [];
    public function user()
    {
        return $this->hasOne(User::class, '_id', 'user_id');
    }
    public function approver()
    {
        return $this->hasOne(User::class, '_id', 'approved_by');
    }
    public function scopeRejected($query)
    {
        return $query->where('approved', 2);
    }
    public function scopeApproved($query)
    {
        return $query->where('approved', 1);
    }
}
