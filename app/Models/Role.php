<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Role extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'roles';

    public function permissions()
    {
        return $this->belongsToMany(Permission::class ,'_id','role_id');
    }
}
