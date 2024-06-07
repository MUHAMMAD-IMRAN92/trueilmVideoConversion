<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class BookTrankingDetails extends Eloquent
{
    use HasFactory;
    protected $table = "tracking_contents";
    public function tracking()
    {
        return $this->hasOne(BookTranking::class, '_id', 'track_id');
    }
}
