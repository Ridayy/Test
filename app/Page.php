<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function connection(){
        return $this->belongsTo(Connection::class);
    }

}
