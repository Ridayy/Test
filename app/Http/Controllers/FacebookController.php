<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Connection;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use App\Post;
use App\Platform;
use App\Page;
use App\Group;
use Exception;
use Socialite;
use UserHelper;
class FacebookController extends Controller
{
    private $fb;
    private $targetURL;

    public function __construct(){
        $this->fb = new Facebook([
            'default_graph_version' => 'v6.0',
        ]);

        $this->targetURL = Socialite::driver('facebook')
        ->setScopes(['email','manage_pages','publish_pages','publish_to_groups','instagram_basic'])
        ->redirect()->getTargetUrl();

    }
    public function index(Request $r){
        $user = UserHelper::handleUser($r);
        // $user = \App\User::find(1);
        $conn = Connection::where('user_id',$user->id)->where('platform_id',1)->first();
        if($conn == null){
            return view('socials.facebook', [
                "title" => "Facebook",
                "targetURL" => $this->targetURL,
                "preview"=> true,
                "user" => $user
            ]);
        }else{
            return redirect('/facebook/'.$conn->id);
        }
    }
    public function connection($connection_id){
        $id = Platform::where("platform_title", "facebook")->first()->id;
        $conn = Connection::find($connection_id);
        $connections = Connection::where('user_id', $conn->user_id)
        ->where('id','!=',$connection_id)
        ->where('platform_id',$id)
        ->get();
        return view('socials.facebook', [
            'connection' => $conn,
            'connections' => $connections,
            "title" => "Facebook",
            "targetURL" => $this->targetURL,
            "preview"=> false,
            "user" => $conn->user,
            "posts" => Post::where([
                "platform_id" => Platform::where("platform_title", "facebook")->first()->id,
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

    public function login($user_id){
        session(['user' => $user_id]);

        return Socialite::driver('facebook')
        ->setScopes(['email','manage_pages','publish_pages','publish_to_groups','read_page_mailboxes','pages_messaging'])
        ->redirect();

    }

    private function createUserPages(Connection $conn){
        try {
            $response = $this->fb->get($conn->fb_id.'/accounts', $conn->access_token);
            $graphEdge = $response->getGraphEdge();
            foreach($graphEdge as $page){
                $oAuth2Client = $this->fb->getOAuth2Client();

                $name = $page->getField('name');
                $page_id = $page->getField('id');
                $pageLongLivedToken = $oAuth2Client->getLongLivedAccessToken($page->getField('access_token'));
                Page::create([
                    'user_id' => $conn->user_id,
                    'connection_id' => $conn->id,
                    'name' => $name,
                    'page_id' => $page_id,
                    'access_token' => $pageLongLivedToken,
                    'platform_id' => 1

                ]);
            }
        } catch(FacebookResponseException $e) {
            echo 'Grapha returned an error: ' . $e->getMessage();
            error_log('Graph returned an error: ' . $e->getMessage());
            return false;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            error_log('Facebook SDK returned an error: ' . $e->getMessage());
            return false;
        }
    }

    private function createUserGroups(Connection $conn){
        try {
            $response = $this->fb->get($conn->fb_id.'/groups', $conn->access_token);
            $graphEdge = $response->getGraphEdge();
            foreach($graphEdge as $group){


                $name = $group->getField('name');
                $group_id = $group->getField('id');

                Group::create([
                    'user_id' => $conn->user_id,
                    'connection_id' => $conn->id,
                    'name' => $name,
                    'fb_id' => $group_id,
                    'platform_id' => 1
                ]);
            }
        } catch(FacebookResponseException $e) {
            echo 'Grapha returned an error: ' . $e->getMessage();
            error_log('Graph returned an error: ' . $e->getMessage());
            return false;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            error_log('Facebook SDK returned an error: ' . $e->getMessage());
            return false;
        }
    }

    public function callback(Request $r){
        $user = Socialite::driver('facebook')->stateless()->user();

        $oAuth2Client = $this->fb->getOAuth2Client();
        $accessToken = $oAuth2Client->getLongLivedAccessToken($user->token);
        $id = $user->id;
        $name = $user->name;
        $email = $user->email;
        $avatar = $user->avatar;

        $ifExists = Connection::where('fb_id',$id)->first();
        if($ifExists){
            return redirect($ifExists->user->mautic_url . "/index.php/s/facebook");

            // return redirect("/facebook/".$ifExists->id);
        }else{
            $connection = \App\Connection::create([
                'user_id' => session('user'),
                'platform_id' => 1,
                'access_token' => $accessToken,
                'fb_id' => $id,
                'name' => $name,
                'email' => $email,
                'avatar' => $avatar,
            ]);
            $this->createUserPages($connection);
            $this->createUserGroups($connection);

            return redirect($connection->user->mautic_url . "/index.php/s/facebook");
            // return redirect("/facebook/".$connection->id);
        }

    }

    public function store(Request $request){


        $captions = "";
        $image_path = "";
        $link_path = "";
        $platform = Platform::where("platform_title", "facebook")->first();
        $scheduled_date = $request->input("scheduled_date");
        $page_id = 0;
        $group_id = 0;
        $isScheduled = $request->input("is_schedule") == "on" ? true : false;
        $timezone = $request->input("timezone");
        $scheduled_epoch = new \DateTime($scheduled_date, new \DateTimeZone($timezone));
        $scheduled_epoch = $scheduled_epoch->format('U');


        // echo $isScheduled . " xx ".$timezone . " xxx ". $scheduled_date->format('U');;
        // die();

        $post = new Post;

        if($request->input("type") == "media"){

            if($request->input("media_page_group") == "page"){
                $key = "media_page_value";
            }else {
                $key = "media_group_value";
            }

            if($request->input("media-url") == ""){
                $this->validate($request, [
                    'media_captions' => 'required',
                     $key => 'required',
                    'media_image' => 'required|max:1999'
                ]);
            }else {
                $this->validate($request, [
                    'media_captions' => 'required',
                     $key => 'required',
                    'media_image' => 'nullable'
                ]);
            }

            $captions = $request->input("media_captions");
            if($request->input("media_page_group") == "page"){
                $page_id = $request->input("media_page_value");
            }else {
                $group_id = $request->input("media_group_value");
            }

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



            if($request->input("link_page_group") == "page"){
                $key = "link_page_value";
            }else {
                $key = "link_group_value";
            }

            if($request->input("media-url") != ""){
                $this->validate($request, [
                    'link_captions' => 'required',
                     $key => 'required',
                    'link_image' => 'required',
                    'link' => 'required'
                ],
                [
                    'link_captions.required' => 'Caption is Required',
                    'link_page_value.required'  => 'Page is required',
                    'link_group_value.required'  => 'Group is required',
                    'link_image.required' => 'Link image is required.',
                    'link.required' => 'Link is required'
                ]
                );
            }else {
                $this->validate($request, [
                        'link_captions' => 'required',
                        $key => 'required',
                        'link_image' => 'nullable',
                        'link' => 'required'
                    ],
                    [
                        'link_captions.required' => 'Caption is Required',
                        'link_page_value.required'  => 'Page is required',
                        'link_group_value.required'  => 'Group is required',
                        'link_image.required' => 'Link image is required.',
                        'link.required' => 'Link is required'
                    ]
                );
            }

            $captions = $request->input("link_captions");
            if($request->input("link_page_group") == "page"){
                $page_id = $request->input("link_page_value");
            }else {
                $group_id = $request->input("link_group_value");
            }

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
            if($request->input("text_page_group") == "page"){
                $key = "text_page_value";
            }else {
                $key = "text_group_value";
            }

            $this->validate($request, [
                'text_captions' => 'required',
                 $key => 'required'
            ]);

            $captions = $request->input("text_captions");
            if($request->input("text_page_group") == "page"){
                $page_id = $request->input("text_page_value");
            }else {
                $group_id = $request->input("text_group_value");
            }
        }



        $post->caption = $captions;
        $post->page_id = $page_id;
        $post->group_id = $group_id;
        $post->scheduled_date = $scheduled_date;
        $post->isScheduled = $isScheduled;
        $post->scheduled_epoch = $scheduled_epoch;
        $post->platform_id =  $platform->id;
        $conn = Connection::find($request->input("connection_id"));
        $post->user_id = $conn->user->id; // To do
        $post->connection_id = $request->input("connection_id"); // To do

        $link_path = $request->input("link");
        if($link_path){
            $post->link = $link_path;
        }

        $post->save();

        return redirect("/facebook/".$request->input("connection_id"))->with("success", "Post Created");


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

    public function messages(){
        return view("messages.facebookMessages");
    }
    public function getMessages($page_id){
        $page = Page::find($page_id);
        // dd($page);
        try{
            $response = $this->fb->get($page->page_id.'/conversations?fields=messages{message,from,to,id,created_time},participants&limit=10',$page->access_token);

        $graphEdge = $response->getGraphEdge();

        return view("messages.page-inbox",[
            'messages' => $graphEdge
        ]);

        } catch(FacebookResponseException $e) {
            echo 'Graphb returned an error: ' . $e->getMessage();
            error_log('Graph returned an error: ' . $e->getMessage());
            return false;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            error_log('Facebook SDK returned an error: ' . $e->getMessage());
            return false;
        }
    }

    public function messagebyID($page_id, $id){
        $page = Page::find($page_id);
        try{
            $response = $this->fb->get("$id?fields=messages{from,message,created_time}",$page->access_token);

        $graphNode = $response->getGraphNode();
        $messages = $graphNode->getField('messages');
        $length = count($messages) - 1;

        return view("messages.modal-messages",[
            'messages' => $messages,
            'length' => $length,
        ]);

        } catch(FacebookResponseException $e) {
            echo 'Graphb returned an error: ' . $e->getMessage();
            error_log('Graph returned an error: ' . $e->getMessage());
            return false;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            error_log('Facebook SDK returned an error: ' . $e->getMessage());
            return false;
        }
    }

    public function sendMessage($page_id, $id,  Request $r){
        $page = Page::find($page_id);
        $response = $this->fb->get($id."?fields=participants", $page->access_token);
        $graphEdge = $response->getGraphNode();
        $repID = '';
        $participants = $graphEdge->getField('participants');
        foreach($participants as $participant){
            $id = $participant->getField('id');
            if($id != $page->page_id){
                $repID = $id;
            }
        }

        $message = $r->message;
        try{
            $data = [
                'messaging_type' => 'RESPONSE',
                'recipient' => [
                    'id' => $repID
                ],
                'message' => [
                    'text' => $message
                ]

                ];

            $response = $this->fb->post("/me/messages", $data , $page->access_token);

        $graphNode = $response->getGraphNode();
        if(isset($graphNode['message_id']) && $graphNode['message_id'] != '')
            return "sent";


        } catch(FacebookResponseException $e) {
            echo 'Graphb returned an error: ' . $e->getMessage();
            error_log('Graph returned an error: ' . $e->getMessage());
            return false;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            error_log('Facebook SDK returned an error: ' . $e->getMessage());
            return false;
        }
    }
}
