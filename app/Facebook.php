<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facebook extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
