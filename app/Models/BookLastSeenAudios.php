<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class BookLastSeenAudios extends Eloquent
{
    use HasFactory;

    protected $table = 'lastseenaudios';
}
