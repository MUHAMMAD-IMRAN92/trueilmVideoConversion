<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class QuizAttempts extends Eloquent
{
    use HasFactory;

    protected $appends = ['attemped', 'unattemped', 'correct', 'incorrect', 'user'];

    public function getAttempedAttribute()
    {
        $result = AttemptResult::where('attempt_id', $this->_id)->where('status', 1)->count();

        return @$result;
    }
    public function getUnattempedAttribute()
    {
        $result = AttemptResult::where('attempt_id', $this->_id)->where('status', 0)->count();

        return @$result;
    }
    public function getCorrectAttribute()
    {
        $result = AttemptResult::where('attempt_id', $this->_id)->where('status', 1)->where('type', 1)->count();

        return @$result;
    }
    public function getIncorrectAttribute()
    {
        $result = AttemptResult::where('attempt_id', $this->_id)->where('status', 1)->where('type', 1)->count();

        return @$result;
    }
    public function getUserAttribute()
    {
        $result = AttemptResult::where('attempt_id', $this->_id)->first();
        $user = User::where('_id', $result->user_id)->first();

        return @$user->name;
    }
}
