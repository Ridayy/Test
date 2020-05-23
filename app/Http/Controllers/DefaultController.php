<?php

namespace App\Http\Controllers;

use App\Connection;
use App\Platform;
use Illuminate\Http\Request;
use App\UserTwo;

class DefaultController extends Controller
{
    public function index(Request $r){
        return "Welcome to Social Freak";
        // return UserTwo::all();
    }


    public function deleteConnection($conn_id){
        $conn = Connection::find($conn_id);
        $user = $conn->user;
        $platform = Platform::find($conn->platform_id)->platform_title;
        $platform = strtolower($platform);
        $id = $user->mautic_id;
        $email = $user->email;
        $url = $user->mautic_url;
        if($conn){
            $conn->delete();

        }
        return redirect("/$platform/?id=$id&email=$email&url=$url");
    }
}
