<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\Platform;
use App\Page;
use App\Group;

use InstagramAPI\Instagram;
use Storage;
use Grafika\Grafika;
use App\Connection;
use App\Http\Controllers\InstagramHelper;
class InstagramController extends Controller
{
    private $ig;
    public function __construct(){

        $this->ig = new Instagram(false,false,[
            'storage'    => 'mysql',
            'dbhost'     =>  env('DB_HOST', '127.0.0.1'),
            'dbname'     => env('DB_DATABASE', 'socialfreak'),
            'dbusername' => env('DB_USERNAME', 'root'),
            'dbpassword' => env('DB_PASSWORD', ''),
            'dbtablename'=> "sp_instagram_sessions"
        ]);
    }

    public function index(Request $r){
        // $user = UserHelper::handleUser($r);
        // $user = User::find(1);
        $conn = Connection::where('user_id', 1)->where('platform_id',3)->first();
        if($conn == null){
            return view('login.instagram', ['user_id' => 1]);
        }else{
            return redirect('/instagram/'.$conn->id);
        }
    }

    public function connection($connection_id){

        $id = Platform::where("platform_title", "instagram")->first()->id;
        $conn = Connection::find($connection_id);
        $connections = Connection::where('user_id',$conn->user_id)
        ->where('id','!=',$connection_id)
        ->where('platform_id',$id)
        ->get();

        return view('socials.instagram', [
            'connection' => $conn,
            'connections' => $connections,
            "preview"=> false,
            "title" => "Instagram",
            "user" => $conn->user,
            "posts" => Post::where([
                "platform_id" => $id,
                "user_id" => 1,
                "connection_id" => $connection_id,
            ])->orderBy("id", "desc")->get(),
            "pages" => Page::where([
                "platform_id" => $id,
            ])->get()
        ]);

    }


    public function store(Request $request){


        $captions = "";
        $image_path = "";
        $video_path = "";
        $story_path = "";
        $platform = Platform::where("platform_title", "Instagram")->first();
        $scheduled_date = "";
        $page_id = 0;
        $group_id = 0;
        $isScheduled = $request->input("is_schedule") == "on" ? true : false;
        $timezone = $request->input("timezone");
        $scheduled_epoch = new \DateTime($scheduled_date, new \DateTimeZone($timezone));
        $scheduled_epoch = $scheduled_epoch->format('U');

        $post = new Post;

        if($request->input("type") == "media"){

            if($request->input("media-url") == ""){
                $this->validate($request, [
                    'media_captions' => 'required',
                    'media_image' => 'required|max:1999'
                ]);
            }else {
                $this->validate($request, [
                    'media_captions' => 'required',
                    'media_image' => 'nullable'
                ]);
            }

            $captions = $request->input("media_captions");


            if($request->hasFile('media_image')){
                // Get filename with the extension
                $filenameWithExt = $request->file('media_image')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('media_image')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore= $filename.'_'.time().'.'.$extension;
                // Upload media_image
                $path = $request->file('media_image')->storeAs('public/images', $fileNameToStore);
                $post->image_path = $fileNameToStore;
            }
            else if($request->input("media-url") != ""){
                $post->image_path = $request->input("media-url");
            }



        } // end if media
        else if($request->input("type") == "video"){
            if($request->input("video-url") == ""){
                $this->validate($request, [
                    'video_captions' => 'required',
                    'video_page_value' => 'required',
                    'video' => 'required|max:1999',
                    'title' => 'required'
                ]);
            }else {
                $this->validate($request, [
                    'video_captions' => 'required',
                    'video_page_value' => 'required',
                    'video' => 'nullable',
                    'title' => 'required'
                ]);
            }


            $captions = $request->input("video_captions");
            $page_id = $request->input("video_page_value");
            $title = $request->input("title");

            if($request->hasFile('video')){
                // Get filename with the extension
                $filenameWithExt = $request->file('video')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('video')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore= $filename.'_'.time().'.'.$extension;
                // Upload video
                $path = $request->file('video')->storeAs('public/videos', $fileNameToStore);
                $post->video_path = $fileNameToStore;
            }
            else if($request->input("video-url") != ""){
                $post->video_path = $request->input("video-url");
            }

            $post->title = $title;
        }
       else {

            $this->validate($request, [
                'story_image' => 'required|max:1999',
            ]);


            if($request->hasFile('story_image')){
                // Get filename with the extension
                $filenameWithExt = $request->file('story_image')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('story_image')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore= $filename.'_'.time().'.'.$extension;
                // Upload story_image
                $path = $request->file('story_image')->storeAs('public/images', $fileNameToStore);
                $post->story_path = $fileNameToStore;
            }
            else if($request->input("media-url") != ""){
                $post->story_path = $request->input("media-url");
            }

            $page_id = $request->input("story_page_value");

        }

        $scheduled_date = $request->input("scheduled_date");


        $post->caption = $captions;
        $post->page_id = 0;
        $post->group_id = 0;
        $post->scheduled_date = $scheduled_date;
        $post->platform_id =  $platform->id;
        $conn = Connection::find($request->input("connection_id"));
        $post->user_id = $conn->user->id; // To do
        $post->connection_id = $request->input("connection_id");
        $post->type = $request->input("type");
        $post->isScheduled = $isScheduled;
        $post->scheduled_epoch = $scheduled_epoch;


        $post->save();

        return redirect("/instagram/".$request->input("connection_id"))->with("success", "Post Created");


    }

    public function login($user_id){
        return view("login.instagram", ['user_id' => $user_id]);
    }

    public function loginValidate(Request $request){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        try {
            $response = $this->ig->login($request->username, $request->password);

            $user = $this->ig->account->getCurrentUser()->getUser();

            $path = InstagramHelper::saveAvatar($user->getProfilePicUrl(),$user->getUsername());


            $ifExists = Connection::where('email',$user->getUsername())->where('platform_id',3)->first();
            if($ifExists){
                return redirect("/facebook/".$ifExists->id);
            }else{
                $connection = \App\Connection::create([
                    'user_id' => $request->user_id,
                    'platform_id' => 3,
                    'access_token' => encrypt( $request->password ),
                    'name' => $user->getFullName()?$user->getFullName():$user->getUsername(),
                    'email' => $user->getUsername(),
                    'avatar' => $path,
                ]);

                return redirect("/instagram/".$connection->id);
            }

        } catch (\Exception $e) {
            // echo 'Something went wrong: '.$e->getMessage()."\n";
            return view("login.instagram", ['user_id' => $request->user_id]);
        }
    }



}
