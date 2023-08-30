<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ReviewBook extends Eloquent
{
    use HasFactory;
    protected $appends = ['user_name', 'reviewer_name'];
    public function getUserNameAttribute()
    {
        // return $this->added_by;
        $user = User::where('_id', $this->user_id)->first();

        return @$user->name;
    }
    public function getReviewerNameAttribute()
    {
        // return $this->added_by;
        $user = User::where('_id', $this->reviwed_by)->first();

        return @$user->name;
    }
}
