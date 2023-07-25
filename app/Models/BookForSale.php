<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class BookForSale extends Eloquent
{
    use HasFactory;
    protected $appends = ['user_name'];

    public function getUserNameAttribute()
    {
        // return $this->added_by;
        $user = User::where('_id', $this->added_by)->first();

        return @$user->name;
    }
    public function inventory(){
        return $this->hasOne(BookForSaleInventory::class , 'book_id' , '_id')->where('status' , 1);
    }
}
