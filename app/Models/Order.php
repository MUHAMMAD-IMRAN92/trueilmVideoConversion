<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Order extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'order_details';

    public function book()
    {
        return $this->hasOne(Book::class, '_id', 'bookId');
    }
}
