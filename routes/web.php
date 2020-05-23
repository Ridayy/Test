<?php

use App\Connection;
use App\Group;
use App\Page;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => ['web']], function () {
    // your routes here


Route::get('/', 'DefaultController@index');

// ============ FACEBOOK
Route::get('/facebook', 'FacebookController@index');
Route::get('/facebook/messages/{page_id}', 'FacebookController@getMessages');
Route::get('/facebook/{connection_id}', 'FacebookController@connection');
Route::get('/facebook/login/{user_id}', 'FacebookController@login');
Route::get('/fbcallback', 'FacebookController@callback');
Route::get('/fbpost', 'FacebookController@post');
Route::post('/facebook', 'FacebookController@store');
Route::get('/page', 'FacebookController@getPage');
Route::get('/cron', 'CronController@facebook');
Route::post('/fetchPost', 'FacebookController@fetch');



// ============ TWITTER
Route::get('/twitter', 'TwitterController@index');
Route::post('/twitter', 'TwitterController@store');
Route::get('/twitter/login/{user_id}', 'TwitterController@login');
Route::get('/twitter/{connection_id}', 'TwitterController@connection');
Route::post('/fetchTwitterPost', 'TwitterController@fetch');



// ============ Instagram
Route::get('/instagram', 'InstagramController@index');
Route::post('/instagram', 'InstagramController@store');
Route::get('/instagram/test', 'InstagramController@test');
Route::get('/instagram/login/{user_id}', 'InstagramController@login');
Route::post('/instagram/login', 'InstagramController@loginValidate');
Route::post('/fetchInstagramPost', 'InstagramController@fetch');
Route::get('/instagram/{connection_id}', 'InstagramController@connection');

// ============ LINKEDIN
Route::get('/linkedin', 'LinkedInController@index');
Route::post('/linkedin', 'LinkedInController@store');
Route::get('/linkedin/login/{user_id}', 'LinkedInController@login');
Route::get('/linkedin/callback', 'LinkedInController@callback');
Route::get('/linkedin/{connection_id}', 'LinkedInController@connection');
Route::post('/fetchLinkedInPost', 'LinkedInController@fetch');


Route::get('/l', 'DefaultController@linkedIn');


Route::get('/cronfb', 'CronController@facebook');
Route::get('/cronli', 'CronController@postToLinkedIn');
Route::get('/croninsta', 'InstaCronController@postToInstagram');


Route::get('/delete_connection/{conn_id}', 'DefaultController@deleteConnection');




Route::get('/ini', function(){
    // echo fopen('storage/images/2_1588464111.png', 'r');
    echo session('url');
    //return phpinfo();
});


Route::get('/truncate', function(Request $r){
    if($r->ammar == 'x'){
        // User::truncate();
        Post::truncate();
        Page::truncate();
        Group::truncate();
        Connection::truncate();
        User::truncate();
    }
});

// ============ FACEBOOK MESSAGES
Route::get('/facebookMessages/{page_id}/{id}', 'FacebookController@messagebyID');
Route::post('/facebookMessages/{page_id}/{id}', 'FacebookController@sendMessage');
Route::get('/facebookMessages', 'FacebookController@messages');
Route::get('/facebookMessages/{page_id}', 'FacebookController@getMessages');

Route::get('/twittercb', 'TwitterController@callback');

});


// Instagram Login

// Route::get('/instagramLogin', 'InstagramController@login');
// Route::post('/instagramLogin', 'InstagramController@loginValidate');

// Whatsapp
Route::get("/whatsapp", "WhatsAppController@index");
Route::get("/whatsapp/check", "WhatsAppController@check");
Route::post("/whatsapp", "WhatsAppController@contact");
Route::post("/contact/update", "WhatsAppController@update");
Route::post("whatsapp/send", "WhatsAppController@send");
