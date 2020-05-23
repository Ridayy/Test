<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTwo extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'users';

}
