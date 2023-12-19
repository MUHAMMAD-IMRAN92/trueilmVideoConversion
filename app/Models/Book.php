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
    // protected $appends = ['user_name', 'approver_name'];
    public function bookTraking()
    {
        return $this->hasOne(BookTranking::class, 'book_id', '_id')->orderBy('createdAt', 'desc');
    }
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
    // public function getUserNameAttribute()
    // {
    //     // return $this->added_by;
    //     $user = User::where('_id', $this->added_by)->first();

    //     return @$user->name;
    // }
    public function user()
    {
        return $this->hasOne(User::class, '_id', 'added_by');
    }
    public function approver()
    {
        return $this->hasOne(User::class, '_id', 'approved_by');
    }
    // public function getApproverNameAttribute()
    // {
    //     // return $this->added_by;
    //     $user = User::where('_id', $this->approved_by)->first();

    //     return @$user->name;
    // }
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

    public function content()
    {
        return $this->hasMany(BookContent::class, 'book_id', 'id');
    }
    public function author()
    {
        return $this->hasOne(Author::class, '_id', 'author_id');
    }
}
