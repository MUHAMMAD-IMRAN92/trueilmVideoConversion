<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Glossory extends Eloquent
{
    use HasFactory;

    public function attributes()
    {
        return $this->hasMany(GlossoryAttribute::class, 'glossory_id', 'id');
    }
}
