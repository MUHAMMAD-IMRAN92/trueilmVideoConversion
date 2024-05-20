<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Models\Scopes\DeletedAtScope as ScopesDeletedAtScope;

class CourseLesson extends Eloquent
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::addGlobalScope(new ScopesDeletedAtScope);
    }
}
