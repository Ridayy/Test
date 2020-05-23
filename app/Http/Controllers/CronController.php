<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use LinkedIn\AccessToken;
use LinkedIn\Client;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\Connection;
use App\Http\Controllers\InstagramHelper;
use Carbon\Carbon;

class CronController extends Controller
{
    private $fb;
    public function __construct(){
        $this->fb = new Facebook([
            'default_graph_version' => 'v6.0',
        ]);
    }

    private function postTOFB( Post $post){

        $data = ['message' => $post->caption];
        $place = 'feed';
        $page = $post->page;
        $postToID = $page == null ? $post->group->fb_id : $page->page_id;
        $accessTokenToUse = $page == null ? $post->connection->access_token: $page->access_token;

        try {
            // Returns a `Facebook\FacebookResponse` object
            //Add to data for photo if photo exists
            if($post->image_path != '') {
                //Add to data for photo if photo exists

                $data['source'] = $this->fb->fileToUpload('storage/images/'.$post->image_path);
                $place = 'photos';
            }

            if($post->link != '') {
                //Add to data for photo if photo exists

                $data['link'] = $post->link;
            }

            $response = $this->fb->post($postToID."/$place", $data, $accessTokenToUse);
        } catch(FacebookResponseException $e) {
            echo 'Graphb returned an error: ' . $e->getMessage();
            error_log('Graph returned an error: ' . $e->getMessage());
            return false;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            error_log('Facebook SDK returned an error: ' . $e->getMessage());
            return false;
        }
        $graphNode = $response->getGraphNode();
        if(isset($graphNode['id']) && $graphNode['id'] != '')
            return true;
        return false;
    }

    private function postToTwitter( Post $post){
        $client_id = config('services.twitter.client_id');
        $client_secret = config('services.twitter.client_secret');
        $token = $post->connection->access_token;
        $tokenSecret = $post->connection->twitter_secret;
        $connection = new TwitterOAuth($client_id,$client_secret, $token,$tokenSecret);

        $message = $post->caption;
        if($post->link != '') {
            $message .= " ".$post->link;
        }
        if($post->image_path != '') {
            // Upload photo
            $media = $connection->upload('media/upload',['media' => 'storage/images/'.$post->image_path]);
            $parameters = [
                'status' => $message,
                'media_ids' => $media->media_id_string
            ];
            $result = $connection->post('statuses/update',$parameters);
            if($result->id != '') {
                return true;
            }
            return false;
        }
        //Post regular status
        else {

            $statuses = $connection->post("statuses/update", ["status" => $message]);
            // dd($statuses);
            if($statuses->id != '') {
                return true;
            }
            return false;
        }
    }

    private function postToLinkedInx( Post $post){
        $client_id = config('services.twitter.client_id');
        $client_secret = config('services.twitter.client_secret');
        $token = $post->connection->access_token;
        $tokenSecret = $post->connection->twitter_secret;
        $connection = new TwitterOAuth($client_id,$client_secret, $token,$tokenSecret);

        $message = $post->caption;
        if($post->link != '') {
            $message .= " ".$post->link;
        }
        if($post->image_path != '') {
            // Upload photo
            $media = $connection->upload('media/upload',['media' => 'storage/images/'.$post->image_path]);
            $parameters = [
                'status' => $message,
                'media_ids' => $media->media_id_string
            ];
            $result = $connection->post('statuses/update',$parameters);
            if($result->id != '') {
                return true;
            }
            return false;
        }
        //Post regular status
        else {

            $statuses = $connection->post("statuses/update", ["status" => $message]);
            // dd($statuses);
            if($statuses->id != '') {
                return true;
            }
            return false;
        }
    }
    private function linkedInImageUpload(Connection $conn, $imgUrl){
        $reg = $this->linkedInRegisterUpload($conn);
        $linkedInURL = $reg['url'] . "&oauth2_access_token=" . $conn->access_token;

        $body = fopen($imgUrl, 'r');
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', $linkedInURL, [
        'body' => $body
        ]);

        if($res){
            return $reg['urn'];
        }else{
            return "";
        }

    }

    private function linkedInRegisterUpload(Connection $conn){

        $requestMessage = new \stdClass;
        $requestMessage->registerUploadRequest = new \stdClass;
        $requestMessage->registerUploadRequest->owner = 'urn:li:person:' .$conn->l_id;
        $requestMessage->registerUploadRequest->recipes = array();
        $requestMessage->registerUploadRequest->recipes[] = 'urn:li:digitalmediaRecipe:feedshare-image';
        $requestMessage->registerUploadRequest->serviceRelationships = array();
        $requestMessage->registerUploadRequest->serviceRelationships[] = (object) ['identifier' => 'urn:li:userGeneratedContent', 'relationshipType' => 'OWNER'];
        $data_string = json_encode($requestMessage);

        $linkedInURL = "https://api.linkedin.com/v2/assets?action=registerUpload&oauth2_access_token=" . $conn->access_token;

        // Send request via POST to https://api.linkedin.com/v2/assets?action=registerUpload
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $linkedInURL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $server_output = curl_exec($ch);
        curl_close ($ch);
        $serverDecodedResponse = json_decode($server_output);
        $tmpVar = 'com.linkedin.digitalmedia.uploading.MediaUploadHttpRequest';
        $uploadrlTmp = $serverDecodedResponse->value->uploadMechanism->$tmpVar->uploadUrl;
        $uploadImgTmpUrn = $serverDecodedResponse->value->asset;
        return [
            'url' => $uploadrlTmp,
            'urn' => $uploadImgTmpUrn,

        ];
    }

    public function postToLinkedIn(Post $post){
        $conn = $post->connection;
        $accessToken = new AccessToken($conn->access_token);
        $client = new Client(config('services.linkedin.client_id'),config('services.linkedin.client_secret'));
        $client->setAccessToken($accessToken);
        $data = [
                'author' => 'urn:li:person:' .$conn->l_id,
                'lifecycleState' => 'PUBLISHED',
                'specificContent' => [
                    'com.linkedin.ugc.ShareContent' => [
                        'shareCommentary' => [
                            'text' => $post->caption
                        ],
                        'shareMediaCategory' => 'NONE'

                    ]
                ],
                'visibility' => [
                    'com.linkedin.ugc.MemberNetworkVisibility' => 'CONNECTIONS'
                ]
            ];
        if($post->link != '') {
            $data['specificContent']['com.linkedin.ugc.ShareContent']['shareMediaCategory'] = 'ARTICLE';
            $data['specificContent']['com.linkedin.ugc.ShareContent']['media'] = [
                [
                    'status' => 'READY',
                    'originalUrl' => $post->link,
                ]
            ];
        }

        if($post->image_path != '') {
            $resp = $this->linkedInImageUpload($conn,'storage/images/'.$post->image_path);
            $data['specificContent']['com.linkedin.ugc.ShareContent']['shareMediaCategory'] = 'IMAGE';
            $data['specificContent']['com.linkedin.ugc.ShareContent']['media'] = [
                [
                    'status' => 'READY',
                    'media' => $resp,
                ]
            ];

        }

        $share = $client->post(
            'ugcPosts',
            $data
        );
        if($share['id'] != '') {
            return true;
        }
        return false;

    }

    public function postToInstagram(Post $post){
        $i = new InstagramHelper();
        return $i->postToInstagram($post);
    }

    public function facebook(){
        $posts = Post::where('isPosted',0)
        ->where('isScheduled',0)
        ->get();
        foreach($posts as $post){
            $posted = false;
            if($post->platform_id == 1){
                $posted = $this->postTOFB($post);
            }

            if($post->platform_id == 2){
                $posted = $this->postToTwitter($post);
            }

            if($post->platform_id == 3){
                $posted = $this->postToInstagram($post);
            }

            if($post->platform_id == 4){
                $posted = $this->postToLinkedIn($post);
            }
            $post->isPosted = $posted;
            $post->save();
        }


        $posts = Post::where('isPosted',0)
        ->where('isScheduled',1)
        ->where('scheduled_epoch','<=',time())
        ->get();
        foreach($posts as $post){
            $posted= false;

            if($post->platform_id == 1){
                $posted = $this->postTOFB($post);
            }

            if($post->platform_id == 2){
                $posted = $this->postToTwitter($post);
            }

            if($post->platform_id == 3){
                $posted = $this->postToInstagram($post);
            }

            if($post->platform_id == 4){
                $posted = $this->postToLinkedIn($post);
            }
            $post->isPosted = $posted;
            $post->save();
        }
    }
}
