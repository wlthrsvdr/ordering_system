<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Str;

class Product extends Authenticatable
{
    use Notifiable;

    protected $table = "product";

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
        'created_at' => "datetime:m-d-Y",
        'updated_at' => "datetime:m-d-Y"
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'product_category', 'id');
    }

    public function addedBy()
    {
        return $this->belongsTo('App\Models\User', 'added_by', 'id');
    }


    public function updatedBy()
    {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }

}
