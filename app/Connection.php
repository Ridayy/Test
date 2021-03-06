<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    protected $guarded=[];
    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
