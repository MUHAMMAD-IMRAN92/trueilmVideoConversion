<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class AppSectionContent extends Eloquent
{
    use HasFactory;
    protected $table = 'app_section_content';
    public function course()
    {
        return $this->hasMany(Course::class, '_id', 'content_id');
    }
    public function books()
    {
        return $this->hasMany(Book::class, '_id', 'content_id');
    }
}
