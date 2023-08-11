<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Book extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'books';
    protected $guarded = [];
    public function lastSeenBook()
    {
        return $this->hasMany(BookLastSeen::class, 'book_id', '_id')->orderBy('createdAt', 'desc');
    }
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
    public function bookPagescount($request)
    {
        $book_id = $this->_id;
        $bookLastSeen = BookLastSeen::where('book_id', $book_id)->when($request->e_date, function ($q) use ($request) {
            $q->whereBetween('createdAt', [new Carbon($request->s_date),  new Carbon($request->e_date)]);
        })->orderBy('createdAt', 'desc')->get();

        $unique = $bookLastSeen->unique('user_id');

        $unique->values()->all();
        return  $unique->sum('total_pages');
    }
    public function totalUserReadThisBook()
    {
        if ($this->type == 2 || $this->type == 7) {
            $bookLastSeen = BookLastSeenAudios::where('book_id', $this->_id)->orderBy('createdAt', 'desc')->get();

            $unique = $bookLastSeen->unique('user_id');
        } else {
            $bookLastSeen = BookLastSeen::where('book_id', $this->_id)->orderBy('createdAt', 'desc')->get();

            $unique = $bookLastSeen->unique('user_id');
        }


        return $unique->values()->count();
    }
}
