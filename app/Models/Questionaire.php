<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Questionaire extends Eloquent
{
    use HasFactory;
    public function options()
    {
        return $this->hasMany(QuestionaireOptions::class, 'question_id', '_id');
    }
}
