<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'fullname',
        'password',
        'role',
        'image',
        'level'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function transactions(){
        return $this->hasMany(HeaderTransaction::class);
    }

    // function friends(){
    //     return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id');
    // }
    function friends(){
        return $this->hasMany(Friend::class, 'user_id', 'id');
    }

    function friend_reqs(){
        return $this->hasMany(Friend::class, 'friend_id', 'id');
    }
}
