<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Book extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'books';
    protected $guarded = [];

    protected $appends = ['user_name'];
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopeEbook($query)
    {
        return $query->where('type', '1');
    }

    public function scopeAudio($query)
    {
        return $query->where('type', '2');
    }
    public function scopePaper($query)
    {
        return $query->where('type', '3');
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
    public function getUserNameAttribute()
    {
        // return $this->added_by;
        $user = User::where('_id', $this->added_by)->first();

        return @$user->name;
    }
    public function lastSeenBook(){
        return $this->hasOne(BookLastSeen::class , 'book_id' , '_id');
    }
}
