<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $guarded = [];
    public $timestamps = false;

    public function platform(){
        return $this->belongsTo(Platform::class);
    }

    public function page(){
        return $this->belongsTo(Page::class);
    }
    public function group(){
        return $this->belongsTo(Group::class);
    }
    public function connection(){
        return $this->belongsTo(Connection::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
