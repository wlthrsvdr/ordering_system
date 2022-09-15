<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Str;

class Topup extends Authenticatable
{
    use Notifiable;

    protected $table = "topup";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

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

    public function topupTo()
    {
        return $this->belongsTo('App\Models\User', 'topup_to', 'id');
    }

    public function topupBy()
    {
        return $this->belongsTo('App\Models\User', 'topupBy', 'id');
    }
}
