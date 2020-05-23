<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Platform;
use App\Page;
use App\Group;
use App\Connection;
use Socialite;

class MessageController extends Controller
{
    public function index(){
        // $conn = Connection::where('user_id',1)->where('platform_id',2)->first();
        // if($conn == null){
        //     return view('socials.twitter', [
        //         "title" => "Twitter",
        //         "preview"=> true
        //     ]);
        // }else{
        //     return redirect('/twitter/'.$conn->id);
        // }

        return view("messages.facebookMessages");
    }

}