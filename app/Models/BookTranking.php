<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class BookTranking extends Eloquent
{
    use HasFactory;

    protected $table = "trackings";
    protected $appends = ['total_pages'];

    public function getTotalPagesAttribute()
    {
        $total_count = 0;
        if ($this->type == 1 || $this->type == 3) {
            $type = 'current_pg';
        } else {
            $type = 'file_id';
        }

        $pageCount = BookTrankingDetails::where('track_id', $this->_id)->get()->unique($type)->pluck($type);
        $count = $pageCount->values()->all();

        foreach ($count as $c) {
            $sumDetail =  BookTrankingDetails::where('track_id', $this->_id)->where($type, $c)->sum('total_diff');
            if ($sumDetail >= 7) {
                $total_count++;
            }
        }
        return $total_count;
    }
}
