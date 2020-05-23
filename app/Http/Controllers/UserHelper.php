<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserHelper
{
    public static function handleUser(Request $r){

        $id = $r->id;
        $email = $r->email;
        $url = $r->url;

        $user = User::where('mautic_id',$id)->where('email', $email)->where('mautic_url',$url)->first();
        if($user){
            return $user;
        }else{
            $user = User::create([
                'mautic_id' => $id,
                'email' => $email,
                'mautic_url' => $url,
            ]);
            return $user;
        }
    }
}


?>
