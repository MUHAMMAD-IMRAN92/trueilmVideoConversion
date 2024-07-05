<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;
use Maklad\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use Billable;

    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $connection = 'mongodb';
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getStatusAttribute()
    {

        $userSubscription = UserSubscription::where('user_id', $this->_id)->where('status', 'paid')->orderBy('plan_type', 'DESC')->first();
        if (@$userSubscription->plan_type == 3) {
            return 'Big Family';
        } else if (@$userSubscription->plan_type == 2) {
            return 'Family';
        } elseif (@$userSubscription->plan_type == 1 & @$userSubscription->istrail == 1) {
            return 'Individual (Trial)';
        } elseif (@$userSubscription->plan_type == 0) {
            return 'Freemium';
        } elseif (@$userSubscription->plan_type == 1) {
            return 'Individual';
        }
    }

    // public function getStatusAttribute()
    // {

    //     $userSubscription = UserSubscription::where('user_id', $this->_id)->where('plan_name', '!=', 'Freemium')->where('status', 'paid')->get();
    //     if ($userSubscription) {
    //         return count($userSubscription);
    //     } else {
    //         return 0;
    //     }
    // }
    public function getCancelSubcriptionAttribute()
    {
        $userSubscription = UserSubscription::where('user_id', $this->_id)->where('status', 'cancelled')->get();
        if ($userSubscription) {
            return count($userSubscription);
        } else {
            return 0;
        }
    }
    public function book()
    {
        return $this->hasMany(Book::class, 'user_id', '_id')->orderBy('created_at', 'desc');
    }
    public function bookLastSeen()
    {
        return $this->hasMany(BookLastSeen::class, 'user_id', '_id')->orderBy('created_at', 'desc');
    }
    protected $appends = ['status'];

    protected $dates = ['deleted_at'];

    public function refferer()
    {
        return $this->hasMany(User::class, 'reffer_id', '_id');
    }
    public function family()
    {
        return $this->hasMany(User::class, 'parentId', '_id');
    }
    public function cancelSubscription()
    {
        return $this->hasMany(UserSubscription::class, 'user_id', '_id')->where('status', 'cancelled');
    }
    public function subscription()
    {
        return $this->hasMany(UserSubscription::class, 'user_id', '_id')->where('plan_name', '!=', 'Freemium')->where('status', 'paid');
    }


    public function getmyrole()
    {
        return $this->hasOne(Role::class,'_id','my_role_id');

    }

    
    public function checkPermission($permission)
    {

        
        return $this->getmyrole && $this->getmyrole->permissions->contains('name', $permission);

    }

    public function anycheckPermission($permission)
    {
        
        $all=explode(",",$permission);

        $check = 0;
        foreach( $all as $row){

            if($this->getmyrole && $this->getmyrole->permissions->contains('name', $row) ){

                $check = 1;

            }

            

        }
        if($check == 1 ){
            return true;
        }else{
            return false;
        }
        

    }

    
}
