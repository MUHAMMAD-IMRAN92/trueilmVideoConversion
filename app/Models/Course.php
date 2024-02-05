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
    public function user()
    {
        return $this->hasOne(User::class, '_id', 'added_by');
    }
    public function author()
    {
        return $this->hasOne(Author::class, '_id', 'author_id');
    }
    public function scopePendingApprove($query)
    {
        return $query->where('approved', 0);
    }

    public function scopeApproved($query)
    {
        return $query->where('approved', 1);
    }
    public function scopeRejected($query)
    {
        return $query->where('approved', 2);
    }
    public function approver()
    {
        return $this->hasOne(User::class, '_id', 'approved_by');
    }
    public function category()
    {
        return $this->hasOne(Category::class, '_id', 'category_id');
    }
}
