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

            if ($this->type == 1 || $this->type == 3) {
                $sumDetail =  BookTrankingDetails::where('track_id', $this->_id)->where($type, $c)->get()->sum('total_diff');
                if ($sumDetail >= 7) {
                    $total_count++;
                }
            } else {
                $trackingDetail =  BookTrankingDetails::where('track_id', $this->_id)->where($type, $c)->get();
                $sumDetail = $trackingDetail->sum('total_diff');
                $fileDuration = $trackingDetail[0]->duration;
                $time = $fileDuration;
                list($minutes, $seconds) = explode(":", $time);
                $total_minutes = $minutes + ($seconds / 60);
                if ($total_minutes <= $sumDetail) {
                    $total_count++;
                }
            }
        }
        return $total_count;
    }

    public function book()
    {
        return $this->hasOne(Book::class, '_id', 'category_id');
    }
    public function course()
    {
        return $this->hasOne(Course::class, '_id', 'category_id');
    }
}
