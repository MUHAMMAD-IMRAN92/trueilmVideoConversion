<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Course extends Eloquent
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['user_name'];
    public function lessons()
    {
        return $this->hasMany(CourseLesson::class, 'course_id', 'id');
    }

    public function getUserNameAttribute()
    {
        // return $this->added_by;
        $user = User::where('_id', $this->added_by)->first();

        return @$user->name;
    }
}
