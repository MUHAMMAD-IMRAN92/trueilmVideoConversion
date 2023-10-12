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
        $stripe = new \Stripe\StripeClient(env("STRIPE_SECRET"));
        if ($this->customer) {
            $dataActive = $stripe->subscriptions->all(['customer' => $this->customer]);
            return count($dataActive->data);
        } else {
            return 0;
        }
    }
    public function book()
    {
        return $this->hasMany(Book::class, 'user_id', '_id')->orerBy('created_at', 'desc');
    }
    public function bookLastSeen()
    {
        return $this->hasMany(BookLastSeen::class, 'user_id', '_id')->orerBy('created_at', 'desc');
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
}
