<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Str;

class Cart extends Authenticatable
{
    use Notifiable;

    protected $table = "cart";

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
        'order' => 'array',
        'created_at' => "datetime:m-d-Y",
        'updated_at' => "datetime:m-d-Y"
    ];

    public function orderBy()
    {
        return $this->belongsTo('App\Models\User', 'order_by', 'id');
    }

    public function paidBy()
    {
        return $this->belongsTo('App\Models\RegisteredRfid', 'paid_by', 'id');
    }
}
