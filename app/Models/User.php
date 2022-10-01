<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Cashier\Billable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'auth_type',
        'auth_id',
        'email_verified_at',
        'id'
    ];

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
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function complaints()
    {
        return $this->hasMany('App\Models\Complaint');
    }
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }
    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }
    public function password_token()
    {
        return $this->hasOne('App\Models\Tokenpassword');
    }
    public function address()
    {
        return $this->hasMany('App\Models\Address');
    }
    public function ordercollections()
    {
        return $this->hasMany('App\Models\Ordercollection');
    }
}
