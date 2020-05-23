<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Platform;
use App\Page;
use App\Group;
use App\Connection;
use Socialite;

class TwitterController extends Controller
{

    private $targetURL;
    public function __construct()
    {

    }
    public function index(Request $r){

        $user = UserHelper::handleUser($r);

        $conn = Connection::where('user_id',$user->id)->where('platform_id',2)->first();
        if($conn == null){
            return view('socials.twitter', [
                "title" => "Twitter",
                "targetURL" => $this->targetURL,
                "preview"=> true,
                "user" => $user
            ]);
        }else{
            return redirect('/twitter/'.$conn->id);
        }
    }

    public function connection($connection_id){
        $id = Platform::where("platform_title", "twitter")->first()->id;
        $conn = Connection::find($connection_id);
        $connections = Connection::where('user_id',$conn->user_id)
        ->where('id','!=',$connection_id)
        ->where('platform_id',$id)
        ->get();
        return view('socials.twitter', [
            'connection' => $conn,
            'connections' => $connections,
            "title" => "Twitter",
            "targetURL" => $this->targetURL,
            "preview"=> false,
            "user" => $conn->user,
            "posts" => Post::where([
                "platform_id" => Platform::where("platform_title", "twitter")->first()->id,
                "user_id" => $conn->user_id,
                "connection_id" => $connection_id,
            ])->orderBy("id", "desc")->get(),
            "pages" => Page::where([
                "platform_id" => $id,
                "connection_id" => $connection_id,
            ])->get()
        ]);
    }



    public function store(Request $request){


        $captions = "";
        $image_path = "";
        $video_path = "";
        $link_path = "";
        $platform = Platform::where("platform_title", "Twitter")->first();
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
            // $page_id = $request->input("photo_page_value");


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
                    'video' => 'required|max:1999'
                ]);
            }else {
                $this->validate($request, [
                    'video_captions' => 'required',
                    'video' => 'nullable'
                ]);
            }


            $captions = $request->input("video_captions");


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
        }
        else if($request->input("type") == "link"){


            if($request->input("media-url") == ""){
                $this->validate($request, [
                    'link_captions' => 'required',
                    'link_image' => 'required',
                    'link' => 'required'
                ]);
            }else {
                $this->validate($request, [
                    'link_captions' => 'required',
                    'link_image' => 'nullable',
                    'link' => 'required'
                ]);
            }

            $captions = $request->input("link_captions");
            // $page_id = $request->input("link_page_value");


            if($request->hasFile('link_image')){
                // Get filename with the extension
                $filenameWithExt = $request->file('link_image')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('link_image')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore= $filename.'_'.time().'.'.$extension;
                // Upload link_image
                $path = $request->file('link_image')->storeAs('public/images', $fileNameToStore);
                $post->image_path = $fileNameToStore;
            }
            else if($request->input("media-url") != ""){
                $post->image_path = $request->input("media-url");
            }



        }else {

            $this->validate($request, [
                'text_captions' => 'required',
            ]);

            $captions = $request->input("text_captions");
            // $page_id = $request->input("text_page_value");

        }

        $scheduled_date = $request->input("scheduled_date");


        $post->caption = $captions;
        $post->page_id = 0;
        $post->group_id = 0;
        $post->scheduled_date = $scheduled_date;
        $post->platform_id =  $platform->id;
        $conn = Connection::find($request->input("connection_id"));
        $post->user_id = $conn->user->id; // To do
        $post->connection_id = $request->input("connection_id"); // To do
        $post->isScheduled = $isScheduled;
        $post->scheduled_epoch = $scheduled_epoch;


        $link_path = $request->input("link");
        if($link_path){
            $post->link = $link_path;
        }

        $post->save();

        return redirect("/twitter/".$request->input("connection_id"))->with("success", "Post Created");


    }


    public function login($user_id){
        session(['user' => $user_id]);
        return Socialite::driver('twitter')->redirect();

    }

    public function callback(Request $r){
        $user = Socialite::driver('twitter')->user();
        $id = $user->id;
        $name = $user->nickname;
        $email = $user->email;
        $avatar = $user->avatar;

        $accessToken = $user->token;
        $tokenSecret = $user->tokenSecret;

        $ifExists = Connection::where('twitter_id',$id)->first();
        if($ifExists){
            return redirect($ifExists->user->mautic_url . "/index.php/s/twitter");
        }else{
            $connection = \App\Connection::create([
                'user_id' => session('user'),
                'platform_id' => 2,
                'access_token' => $accessToken,
                'twitter_secret' => $tokenSecret,
                'twitter_id' => $id,
                'name' => $name,
                'email' => $email,
                'avatar' => $avatar,
            ]);
            // return redirect("/twitter/".$connection->id);
            return redirect($connection->user->mautic_url . "/index.php/s/twitter");
        }
        // return redirect('/twitter');
        return redirect(session('url'));
    }

    public function fetch(Request $request){
        $post = Post::where("id", $request->id)->first();

        $caption = $post->caption;
        $link = $post->link;
        $image = $post->image_path;
        $video = $post->video_path;


        $imageDiv = "";
        $videoDiv = "";

        if($image){
            if(!filter_var($image, FILTER_VALIDATE_URL)){
                $image = "/storage/images/". $image;
            }
            $imageDiv = "<div class='image-preview'>
                            <img src='$image' />
                        </div>";
        }

        if($video){
            if(!filter_var($video, FILTER_VALIDATE_URL)){
                $video = "/storage/videos/". $video;
            }
            $videoDiv = "<div class='video-preview'>
                            <video src='$video' autoplay controls muted></video>
                        </div>";
        }


        $html = "
                <div class='link-text'>
                    <a href='$link' target='_blank'>
                        $link
                    </a>
                </div>

                <div class='caption-text'>
                    $caption
                </div>

                $imageDiv
                $videoDiv
            ";
        return $html;
    }
}
