<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class AppSectionContent extends Eloquent
{
    use HasFactory;
    protected $table = 'app_section_contents';
    public function course()
    {
        return $this->hasOne(Course::class, '_id', 'content_id');
    }
    public function books()
    {
        return $this->hasOne(Book::class, '_id', 'content_id');
    }
    public function ebooks()
    {
        return $this->hasMany(Book::class, '_id', 'content_id')->where('type', '1');
    }
    public function audioBooks()
    {
        return $this->hasMany(Book::class, '_id', 'content_id')->where('type', '2');
    }
    public function podcast()
    {
        return $this->hasMany(Book::class, '_id', 'content_id')->where('type', '7');
    }
}
