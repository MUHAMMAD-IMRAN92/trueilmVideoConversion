<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class AppSection extends Eloquent
{
    use HasFactory;
    protected $table = 'app_sections';
    protected $guarded = [];
    public function user()
    {
        return $this->hasOne(User::class, '_id', 'added_by');
    }
    public function eBook()
    {
        return $this->hasMany(AppSectionContent::class, 'section_id', '_id')->where('content_type', 1);
    }
    public function audioBook()
    {
        return $this->hasMany(AppSectionContent::class, 'section_id', '_id')->where('content_type', 2);
    }
    public function podcast()
    {
        return $this->hasMany(AppSectionContent::class, 'section_id', '_id')->where('content_type', 7);
    }
    public function course()
    {
        return $this->hasMany(AppSectionContent::class, 'section_id', '_id')->where('content_type', 6);
    }
    public function appSectionContent()
    {
        return $this->hasMany(AppSectionContent::class, 'section_id', '_id');
    }
}
