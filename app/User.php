<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function fb(){
        return $this->hasOne(Facebook::class,'user_id');
    }
}
