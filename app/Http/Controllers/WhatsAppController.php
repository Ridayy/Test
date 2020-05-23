<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Platform;
use App\Page;
use App\Group;
use App\Contact;
use App\Connection;
use Socialite;

class WhatsAppController extends Controller {
    public function index(){
        $title = "WhatsApp";
        $contacts = Contact::where([
            "user_id" => 1,
            "platform_id" => Platform::where("platform_title", "whatsapp")->first()->id
        ])->get();
        return view("socials.whatsapp",[
            'title' => $title,
            'contacts' => $contacts
        ]);
    }

    public function contact(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'number' => 'required'
        ]);

        $contact = new Contact();
        $platform_id = Platform::where("platform_title", "whatsapp")->first()->id;

        $user_id = 1; // to do
        $contact->name = $request->input("name");
        $contact->number = $request->input("number");
        $contact->user_id = $user_id;
        $contact->platform_id = $platform_id;

        $contact->save();

        return "yoyo";
    }


    public function check(Request $request){
        $response = json_decode(file_get_contents('https://api.chat-api.com/instance129389/status?token=e9wm5loqnwih3mie'));

        $val = false;

        foreach ($response as $key => $value) {
            if($key == "accountStatus" && $value == "authenticated") {
                $val = true;
            }
        }

        if($val){
            echo "YES";
        }
    }


    public function update(Request $request){
        if($request->input("name") == "" && $request->input("number") == ""){

        }else {
            $contact = new Contact();
            $contact->exists = true;
            $contact->id = $request->input("id");
            $contact->name = $request->input("name");
            $contact->save();
        }
    }

    public function send(Request $request){

        $numbers = json_decode($request->input("numbers"));

        for($i = 0; $i < count($numbers); $i++){
            if($request->hasFile('image')){
                $filenameWithExt = $request->file('image')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileNameToStore= $filename.'_'.time().'.'.$extension;
                $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
                $params =array(
                    'phone' => $numbers[$i],
                    'body' => "http://e57d2766.ngrok.io/social/public/storage/images/".$fileNameToStore,
                    'filename' => $filenameWithExt,
                    "caption" => $request->input("message")
                );


                $query = http_build_query($params);

                $contextData = array (
                            'method' => 'POST',
                            'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
                            "Content-Length: ".strlen($query)."\r\n".
                            "User-Agent:MyAgent/1.0\r\n",
                            'content'=> $query );

                $context = stream_context_create (array ( 'http' => $contextData ));

                $result =  file_get_contents (
                            'https://api.chat-api.com/instance129389/sendFile?token=e9wm5loqnwih3mie',
                            false,
                            $context);



            }

            if($request->hasFile('video')){
                $filenameWithExt = $request->file('video')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('video')->getClientOriginalExtension();
                $fileNameToStore= $filename.'_'.time().'.'.$extension;
                $path = $request->file('video')->storeAs('public/videos', $fileNameToStore);
                $params =array(
                    'phone' => $numbers[$i],
                    'body' => "http://e57d2766.ngrok.io/social/public/storage/videos/".$fileNameToStore,
                    'filename' => $filenameWithExt,
                    "caption" => $request->input("message")
                );


                $query = http_build_query($params);

                $contextData = array (
                            'method' => 'POST',
                            'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
                            "Content-Length: ".strlen($query)."\r\n".
                            "User-Agent:MyAgent/1.0\r\n",
                            'content'=> $query );

                $context = stream_context_create (array ( 'http' => $contextData ));

                $result =  file_get_contents (
                            'https://api.chat-api.com/instance129389/sendFile?token=e9wm5loqnwih3mie',
                            false,
                            $context);



            }

            if(!$request->hasFile('video') && !$request->hasFile('image') && $request->input("message") != ""){

                $params =array(
                    'phone' => $numbers[$i],
                    'body' => $request->input("message")
                );


                $query = http_build_query($params);

                $contextData = array (
                            'method' => 'POST',
                            'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
                            "Content-Length: ".strlen($query)."\r\n".
                            "User-Agent:MyAgent/1.0\r\n",
                            'content'=> $query );

                $context = stream_context_create (array ( 'http' => $contextData ));

                $result =  file_get_contents (
                            'https://api.chat-api.com/instance129389/sendMessage?token=e9wm5loqnwih3mie',
                            false,
                            $context);

            }



        }


    }
}
