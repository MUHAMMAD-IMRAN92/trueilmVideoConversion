<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Category extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'categories';
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopeInActive($query)
    {
        return $query->where('status', 0);
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', '_id');
    }
    public function content()
    {
        return $this->hasMany(Book::class, 'category_id', '_id');
    }
}
