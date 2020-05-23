<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Post;
use App\Platform;
use App\Page;
use App\Group;
use App\Connection;
use Illuminate\Support\Facades\Redis;
use Socialite;
use LinkedIn\Client;
use LinkedIn\Scope;
class LinkedInController extends Controller
{
    public function index(Request $r){

        $user = UserHelper::handleUser($r);

        $conn = Connection::where('user_id',$user->id)->where('platform_id',4)->first();
        if($conn == null){
            return view('socials.linkedin', [
                "title" => "LinkedIn",
                "preview"=> true,
                "user" => $user

            ]);
        }else{
            return redirect('/linkedin/'.$conn->id);
        }
    }

    public function connection($connection_id){
        $id = Platform::where("platform_title", "linkedin")->first()->id;
        $conn = Connection::find($connection_id);
        $connections = Connection::where('user_id',$conn->user_id)
        ->where('id','!=',$connection_id)
        ->where('platform_id',$id)
        ->get();


        return view('socials.linkedin', [
            'connection' => $conn,
            'connections' => $connections,
            "title" => "LinkedIn",
            "preview"=> false,
            "user" => $conn->user,
            "posts" => Post::where([
                "platform_id" => $id,
                "user_id" => $conn->user_id,
                "connection_id" => $connection_id,
            ])->orderBy("id", "desc")->get(),
            "pages" => Page::where([
                "platform_id" => $id,
                "connection_id" => $connection_id,
            ])->get(),
            "groups" => Group::where([
                "platform_id" => $id,
                "connection_id" => $connection_id,
            ])->get()
        ]);
    }

    public function store(Request $request){


        $captions = "";
        $image_path = "";
        $link_path = "";
        $platform = Platform::where("platform_title", "linkedin")->first();
        $scheduled_date = "";
        $page_id = 0;
        $group_id = 0;
        $isScheduled = $request->input("is_schedule") == "on" ? true : false;
        $timezone = $request->input("timezone");
        $scheduled_epoch = new \DateTime($scheduled_date, new \DateTimeZone($timezone));
        $scheduled_epoch = $scheduled_epoch->format('U');


        $post = new Post;

        if($request->input("type") == "media"){

            // if($request->input("media_page_group") == "page"){
            //     $key = "media_page_value";
            // }else if($request->input("media_page_group") == "group"){
            //     $key = "media_group_value";
            // }else {
            //     $key = "media_page_group";
            // }

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
            // if($request->input("media_page_group") == "page"){
            //     $page_id = $request->input("media_page_value");
            // }else {
            //     $group_id = $request->input("media_group_value");
            // }

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
        else if($request->input("type") == "link"){

            // if($request->input("link_page_group") == "page"){
            //     $key = "link_page_value";
            // }else if($request->input("link_page_group") == "group"){
            //     $key = "link_group_value";
            // }
            // else {
            //     $key = "link_page_group";
            // }

            if($request->input("media-url") != ""){
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
            // if($request->input("link_page_group") == "page"){
            //     $page_id = $request->input("link_page_value");
            // }else {
            //     $group_id = $request->input("link_group_value");
            // }

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
            // if($request->input("text_page_group") == "page"){
            //     $key = "text_page_value";
            // }else if($request->input("text_page_group") == "group"){
            //     $key = "text_group_value";
            // }else {
            //     $key = "text_page_group";
            // }

            $this->validate($request, [
                'text_captions' => 'required',
            ]);

            $captions = $request->input("text_captions");
            // if($request->input("text_page_group") == "page"){
            //     $page_id = $request->input("text_page_value");
            // }else {
            //     $group_id = $request->input("text_group_value");
            // }
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

        return redirect("/linkedin/".$request->input("connection_id"))->with("success", "Post Created");


    }

    public function login($user_id){
        session(['user' => $user_id]);

        $client = new Client(config('services.linkedin.client_id'),config('services.linkedin.client_secret'));
        $client->setRedirectUrl(config('services.linkedin.redirect'));

        $scopes = [
            Scope::READ_LITE_PROFILE,
            Scope::SHARE_AS_USER,
            Scope::MANAGE_COMPANY
        ];
        //Get login URL
        $loginUrl = $client->getLoginUrl($scopes);

        //Send user to login
        return redirect($loginUrl);
    }

    public function callback(Request $r){
        // $user = Socialite::driver('LinkedIn')->stateless()->user();
        // $accessTokenResponseBody = $user->accessTokenResponseBody;

        $client = new Client(config('services.linkedin.client_id'),config('services.linkedin.client_secret'));
        // return $r->code;
        $client->setRedirectUrl(config('services.linkedin.redirect'));
        $accessToken = $client->getAccessToken($r->code);
        $accessToken = json_decode( json_encode($accessToken), true);
        $profile = $client->get('me');
        $user = [
            'profile' => $profile,
            'accessToken' => $accessToken
        ];

        $ifExists = Connection::where('l_id',$profile['id'])->first();
        if($ifExists){
            return redirect($ifExists->user->mautic_url . "/index.php/s/linkedin");

            return redirect("/linkedin/".$ifExists->id);
        }else{
            $connection = \App\Connection::create([
                'user_id' => session('user'),
                'platform_id' => 4,
                'access_token' => $accessToken['token'],
                'l_id' => $profile['id'],
                'name' => $profile['localizedFirstName'] ." " . $profile['localizedLastName'],
            ]);

            return redirect($connection->user->mautic_url . "/index.php/s/linkedin");

            return redirect("/linkedin/".$connection->id);
        }

    }


    public function fetch(Request $request){
        $post = Post::where("id", $request->id)->first();

        $caption = $post->caption;
        $link = $post->link;
        $image = $post->image_path;
        $imageDiv = "";

        if($image){
            if(!filter_var($image, FILTER_VALIDATE_URL)){
                $image = "/storage/images/". $image;
            }
            $imageDiv = "<div class='image-preview'>
                            <img src='$image' />
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
            ";
        return $html;
    }
}
