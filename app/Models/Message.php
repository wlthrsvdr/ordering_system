<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Message extends Authenticatable
{
    use Notifiable;

    protected $table = "message";


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function account()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Profiles', 'id', 'user_id');
    }
}
