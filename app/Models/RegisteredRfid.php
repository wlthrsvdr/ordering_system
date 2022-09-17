<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Str;

class RegisteredRfid extends Authenticatable
{
    use Notifiable;

    protected $table = "registered_rfid";

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

    public function getNameAttribute()
    {
        return Str::title("{$this->firstname} {$this->middlename} {$this->lastname} ");
    }

    // public function category()
    // {
    //     return $this->belongsTo('App\Models\Category', 'product_category', 'id');
    // }

    // public function addedBy()
    // {
    //     return $this->belongsTo('App\Models\User', 'added_by', 'id');
    // }


    // public function updatedBy()
    // {
    //     return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    // }

}
