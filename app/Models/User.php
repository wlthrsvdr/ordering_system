<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Str;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = "users";

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

    protected $appends = ['name'];

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

    public function getUserRole()
    {
        return $this->user_role;
    }

    public function getNameAttribute()
    {
        return Str::title("{$this->firstname} {$this->middlename} {$this->lastname} " . (strlen($this->suffix) > 0 ? Str::title($this->suffix) : NULL));
    }

    // public function profile()
    // {
    //     return $this->hasOne('App\Models\Profile', 'userId', 'id');
    // }
}
