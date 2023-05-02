<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Course extends Eloquent
{
    use HasFactory;

    public function lessons()
    {
        return $this->hasMany(CourseLesson::class, 'course_id', 'id');
    }
}
