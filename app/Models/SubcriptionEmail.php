<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SubcriptionEmail extends Eloquent
{
    use HasFactory;
    protected $table = "subscriptions_email";
}
