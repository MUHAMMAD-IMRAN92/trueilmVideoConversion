<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class CourseLesson extends Eloquent
{
    use HasFactory;

    public function video()
    {
        return $this->hasOne(LessonVideo::class, 'lesson_id', 'id');
    }
}
