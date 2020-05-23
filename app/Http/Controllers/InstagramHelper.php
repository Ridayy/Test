<?php

namespace App\Http\Controllers;

use App\Post;
use InstagramAPI\Instagram;
use Grafika\Grafika;
use Storage;
class InstagramHelper
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

    private function postImage(Post $post){

        $connection = $post->connection;
        try{
            $this->ig->login($connection->email, decrypt($connection->access_token));

            $file = $this->resizeImage('storage/images/'.$post->image_path);

            $photo = $this->getImageParams($file,'photo');
            $this->ig->timeline->uploadPhoto($photo->getFile(), ['caption' => $post->caption]);
            return true;
        } catch (\Exception $e) {
            echo 'Something went wrong:xx '.$e->getMessage()."\n";
            return false;
        }
    }

    private function postStory(Post $post){

        echo "STORY";
        $connection = $post->connection;
        try{

            $this->ig->login($connection->email, decrypt($connection->access_token));

            $file = $this->resizeImage('storage/images/'.$post->story_path);

            $photo = $this->getImageParams($file,'story');
            $this->ig->story->uploadPhoto($photo->getFile(), ['caption' => $post->caption, 'location' => 'link_story']);

            return true;
        } catch (\Exception $e) {
            echo 'Something went wrong:xx '.$e->getMessage()."\n";
            return false;
        }
    }

    public function postToInstagram(Post $post)
    {
        switch($post->type){
            case 'media':
                return $this->postImage($post);
                break;
            case 'story':
                return $this->postStory($post);
                break;
            case 'video':
                return false;
                break;
        }
    }



    public static function saveAvatar($img, $username){
        $headers = @get_headers(urldecode($img), 1);
        $img_types = ['image/jpeg', 'image/png', 'image/gif'];

        if( is_array($headers['Content-Type']) ){
            $file_type = "png";
            $name = 'storage/avatars/'.$username.".".$file_type;
            $data = file_get_contents($img);
            Storage::put($name, $data);

            return '/'.$name;
        }else{
            $file_type = InstagramHelper::mime2ext( $headers['Content-Type'] );
            $name = 'storage/avatars/'.$username.".".$file_type;
            if(in_array( $headers['Content-Type'] , $img_types, true)){
                $data = file_get_contents($img);
                Storage::put($name, $data);
                return '/'.$name;
            }
        }
    }

    private function getImageParams($image, $type){
        switch ($type) {
            case 'photo':
                $img = new \InstagramAPI\Media\Photo\InstagramPhoto($image, [
                    "targetFeed" => \InstagramAPI\Constants::FEED_TIMELINE,
                    "operation" => \InstagramAPI\Media\InstagramMedia::CROP
                ]);
                break;

            case 'story':
                $img = new \InstagramAPI\Media\Photo\InstagramPhoto($image, [
                    "targetFeed" => \InstagramAPI\Constants::FEED_STORY,
                    "operation" => \InstagramAPI\Media\InstagramMedia::CROP
                ]);
                break;

            case 'carousel':
                $img = new \InstagramAPI\Media\Photo\InstagramPhoto($image, [
                    "targetFeed" => \InstagramAPI\Constants::FEED_TIMELINE_ALBUM,
                    "operation" => \InstagramAPI\Media\InstagramMedia::CROP,
                ]);
                break;
        }

        return $img;
    }


    private function resizeImage($image){
            $im_info = getImageSize($image);
			$name = basename($image);
			$type = $im_info['mime'];

			$im_name = time().$name;
			$im_output = storage_path('tempdir').'/'.$im_name;

			$editor = Grafika::createEditor();
			$editor->open( $image, $image );

            $width = $im_info[0];

            $height = $im_info[1];
            echo $width . " x ".$height;
			$max = 800;
			if($width > $max || $height > $max){

			    if ($width > $height) {
			        $newwidth = $max;
			        $divisor = $width / $max;
                    $newheight = floor( $height / $divisor);
                    echo $newwidth . " xx ".$newheight;
			    } else {
			        $newheight = $max;
			        $divisor = $height / $max;
                    $newwidth = floor( $width / $divisor );
                    echo $newwidth . " xx ".$newheight;
			    }

			    $editor->resizeExact( $image, $newwidth, $newheight );
			}

			$editor->save( $image, $im_output, null, 100 );

			return $im_output;
    }
    public function test(){


        echo InstagramHelper::ammar();

        $ig = new Instagram(true,false,[
            'storage'    => 'mysql',
            'dbhost'     => 'localhost',
            'dbname'     => 'socialfreak',
            'dbusername' => 'root',
            'dbpassword' => '',
            'dbtablename'=> "sp_instagram_sessions"
        ]);

        // $ig = new Instagram();

        try {
            $ig->login('lefoman9373', 'lefonej431@hubopss.com');


            // ============= STORY==============

            // $file = $this->resizeImage('storage/images/STO_vs_ICO_1588984066.png');
            // $photo = $this->getImageParams($file,'story');
            // $ig->story->uploadPhoto($photo->getFile(), ['caption' => "my first post", 'location' => 'link_story']);

            // ============= IMAGe ==============

             $file = $this->resizeImage('storage/images/STO_vs_ICO_1588984066.png');
             $photo = $this->getImageParams($file,'photo');
             $ig->timeline->uploadPhoto($photo->getFile(), ['caption' => "my first post"]);

            // ============= IGTV ==============

            //  $response = $ig->tv->uploadVideo('storage/videos/small.mp4', ['caption' => "my first post",
            //  'title' => 'Small video']);
            // if($this->check_post_video()){

            //     $ig->story->uploadVideo('storage/videos/small.mp4', ['caption' => "my first post", 'location' => 'link_story']);
            // }else{
            //     echo "noo";
            // }



            // $user = $ig->account->getCurrentUser()->getUser();

            // // $contents = file_get_contents($url);
            // // // $name = substr($url, strrpos($url, '/') + 1);
            // // Storage::put($user->getUsername(), $contents);
            // $path = $this->saveAvatar($user->getProfilePicUrl(),$user->getUsername());


            // return [
            //     "user" => $user->getFullName()?$user->getFullName():$user->getUsername(),
            //     "usernamae" => $user->getUsername(),
            //     "avatar" => $path
            // ];


        } catch (\Exception $e) {
            echo 'Something went wrong: '.$e->getMessage()."\n";
            exit(0);
        }

        // try {
        //     // The most basic upload command, if you're sure that your photo file is
        //     // valid on Instagram (that it fits all requirements), is the following:
        //     // $ig->timeline->uploadPhoto($photoFilename, ['caption' => $captionText]);

        //     // However, if you want to guarantee that the file is valid (correct format,
        //     // width, height and aspect ratio), then you can run it through our
        //     // automatic photo processing class. It is pretty fast, and only does any
        //     // work when the input file is invalid, so you may want to always use it.
        //     // You have nothing to worry about, since the class uses temporary files if
        //     // the input needs processing, and it never overwrites your original file.
        //     //
        //     // Also note that it has lots of options, so read its class documentation!
        //     $photo = new \InstagramAPI\Media\Photo\InstagramPhoto('storage/images/1_1588443304.png');
        //     $ig->timeline->uploadPhoto($photo->getFile(), ['caption' => "testing"]);
        // } catch (\Exception $e) {
        //     echo 'Something went wrong: '.$e->getMessage()."\n";
        // }
    }

    private function check_post_video(){

	    \InstagramAPI\Utils::$ffmpegBin = null;
	    \InstagramAPI\Utils::$ffprobeBin =null;

	    if (\InstagramAPI\Utils::checkFFPROBE()) {
	        try {
                \InstagramAPI\Media\Video\FFmpeg::factory();
                echo 'xxx';
	            return true;
	        } catch (\Exception $e) {
                echo "xxx1".$e->getMessage();
	            return false;
	        }
        }

	    return false;
	}
    public static function mime2ext($mime_type) {

        // Original mapping from: https://github.com/bcit-ci/CodeIgniter/blob/develop/application/config/mimes.php
        $mapping = array(
          'hqx'	=>	array('application/mac-binhex40', 'application/mac-binhex', 'application/x-binhex40', 'application/x-mac-binhex40'),
          'cpt'	=>	'application/mac-compactpro',
          'csv'	=>	array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain'),
          'bin'	=>	array('application/macbinary', 'application/mac-binary', 'application/octet-stream', 'application/x-binary', 'application/x-macbinary'),
          'dms'	=>	'application/octet-stream',
          'lha'	=>	'application/octet-stream',
          'lzh'	=>	'application/octet-stream',
          'exe'	=>	array('application/octet-stream', 'application/x-msdownload'),
          'class'	=>	'application/octet-stream',
          'psd'	=>	array('application/x-photoshop', 'image/vnd.adobe.photoshop'),
          'so'	=>	'application/octet-stream',
          'sea'	=>	'application/octet-stream',
          'dll'	=>	'application/octet-stream',
          'oda'	=>	'application/oda',
          'pdf'	=>	array('application/pdf', 'application/force-download', 'application/x-download', 'binary/octet-stream'),
          'ai'	=>	array('application/pdf', 'application/postscript'),
          'eps'	=>	'application/postscript',
          'ps'	=>	'application/postscript',
          'smi'	=>	'application/smil',
          'smil'	=>	'application/smil',
          'mif'	=>	'application/vnd.mif',
          'xls'	=>	array('application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/download', 'application/vnd.ms-office', 'application/msword'),
          'ppt'	=>	array('application/powerpoint', 'application/vnd.ms-powerpoint', 'application/vnd.ms-office', 'application/msword'),
          'pptx'	=> 	array('application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/x-zip', 'application/zip'),
          'wbxml'	=>	'application/wbxml',
          'wmlc'	=>	'application/wmlc',
          'dcr'	=>	'application/x-director',
          'dir'	=>	'application/x-director',
          'dxr'	=>	'application/x-director',
          'dvi'	=>	'application/x-dvi',
          'gtar'	=>	'application/x-gtar',
          'gz'	=>	'application/x-gzip',
          'gzip'  =>	'application/x-gzip',
          'php'	=>	array('application/x-httpd-php', 'application/php', 'application/x-php', 'text/php', 'text/x-php', 'application/x-httpd-php-source'),
          'php4'	=>	'application/x-httpd-php',
          'php3'	=>	'application/x-httpd-php',
          'phtml'	=>	'application/x-httpd-php',
          'phps'	=>	'application/x-httpd-php-source',
          'js'	=>	array('application/x-javascript', 'text/plain'),
          'swf'	=>	'application/x-shockwave-flash',
          'sit'	=>	'application/x-stuffit',
          'tar'	=>	'application/x-tar',
          'tgz'	=>	array('application/x-tar', 'application/x-gzip-compressed'),
          'z'	=>	'application/x-compress',
          'xhtml'	=>	'application/xhtml+xml',
          'xht'	=>	'application/xhtml+xml',
          'zip'	=>	array('application/x-zip', 'application/zip', 'application/x-zip-compressed', 'application/s-compressed', 'multipart/x-zip'),
          'rar'	=>	array('application/x-rar', 'application/rar', 'application/x-rar-compressed'),
          'mid'	=>	'audio/midi',
          'midi'	=>	'audio/midi',
          'mpga'	=>	'audio/mpeg',
          'mp2'	=>	'audio/mpeg',
          'mp3'	=>	array('audio/mpeg', 'audio/mpg', 'audio/mpeg3', 'audio/mp3'),
          'aif'	=>	array('audio/x-aiff', 'audio/aiff'),
          'aiff'	=>	array('audio/x-aiff', 'audio/aiff'),
          'aifc'	=>	'audio/x-aiff',
          'ram'	=>	'audio/x-pn-realaudio',
          'rm'	=>	'audio/x-pn-realaudio',
          'rpm'	=>	'audio/x-pn-realaudio-plugin',
          'ra'	=>	'audio/x-realaudio',
          'rv'	=>	'video/vnd.rn-realvideo',
          'wav'	=>	array('audio/x-wav', 'audio/wave', 'audio/wav'),
          'bmp'	=>	array('image/bmp', 'image/x-bmp', 'image/x-bitmap', 'image/x-xbitmap', 'image/x-win-bitmap', 'image/x-windows-bmp', 'image/ms-bmp', 'image/x-ms-bmp', 'application/bmp', 'application/x-bmp', 'application/x-win-bitmap'),
          'gif'	=>	'image/gif',
          'jpeg'	=>	array('image/jpeg', 'image/pjpeg'),
          'jpg'	=>	array('image/jpeg', 'image/pjpeg'),
          'jpe'	=>	array('image/jpeg', 'image/pjpeg'),
          'png'	=>	array('image/png',  'image/x-png'),
          'tiff'	=>	'image/tiff',
          'tif'	=>	'image/tiff',
          'css'	=>	array('text/css', 'text/plain'),
          'html'	=>	array('text/html', 'text/plain'),
          'htm'	=>	array('text/html', 'text/plain'),
          'shtml'	=>	array('text/html', 'text/plain'),
          'txt'	=>	'text/plain',
          'text'	=>	'text/plain',
          'log'	=>	array('text/plain', 'text/x-log'),
          'rtx'	=>	'text/richtext',
          'rtf'	=>	'text/rtf',
          'xml'	=>	array('application/xml', 'text/xml', 'text/plain'),
          'xsl'	=>	array('application/xml', 'text/xsl', 'text/xml'),
          'mpeg'	=>	'video/mpeg',
          'mpg'	=>	'video/mpeg',
          'mpe'	=>	'video/mpeg',
          'qt'	=>	'video/quicktime',
          'mov'	=>	'video/quicktime',
          'avi'	=>	array('video/x-msvideo', 'video/msvideo', 'video/avi', 'application/x-troff-msvideo'),
          'movie'	=>	'video/x-sgi-movie',
          'doc'	=>	array('application/msword', 'application/vnd.ms-office'),
          'docx'	=>	array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/msword', 'application/x-zip'),
          'dot'	=>	array('application/msword', 'application/vnd.ms-office'),
          'dotx'	=>	array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/msword'),
          'xlsx'	=>	array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/vnd.ms-excel', 'application/msword', 'application/x-zip'),
          'word'	=>	array('application/msword', 'application/octet-stream'),
          'xl'	=>	'application/excel',
          'eml'	=>	'message/rfc822',
          'json'  =>	array('application/json', 'text/json'),
          'pem'   =>	array('application/x-x509-user-cert', 'application/x-pem-file', 'application/octet-stream'),
          'p10'   =>	array('application/x-pkcs10', 'application/pkcs10'),
          'p12'   =>	'application/x-pkcs12',
          'p7a'   =>	'application/x-pkcs7-signature',
          'p7c'   =>	array('application/pkcs7-mime', 'application/x-pkcs7-mime'),
          'p7m'   =>	array('application/pkcs7-mime', 'application/x-pkcs7-mime'),
          'p7r'   =>	'application/x-pkcs7-certreqresp',
          'p7s'   =>	'application/pkcs7-signature',
          'crt'   =>	array('application/x-x509-ca-cert', 'application/x-x509-user-cert', 'application/pkix-cert'),
          'crl'   =>	array('application/pkix-crl', 'application/pkcs-crl'),
          'der'   =>	'application/x-x509-ca-cert',
          'kdb'   =>	'application/octet-stream',
          'pgp'   =>	'application/pgp',
          'gpg'   =>	'application/gpg-keys',
          'sst'   =>	'application/octet-stream',
          'csr'   =>	'application/octet-stream',
          'rsa'   =>	'application/x-pkcs7',
          'cer'   =>	array('application/pkix-cert', 'application/x-x509-ca-cert'),
          '3g2'   =>	'video/3gpp2',
          '3gp'   =>	'video/3gp',
          'mp4'   =>	'video/mp4',
          'm4a'   =>	'audio/x-m4a',
          'f4v'   =>	'video/mp4',
          'webm'	=>	'video/webm',
          'aac'   =>	'audio/x-acc',
          'm4u'   =>	'application/vnd.mpegurl',
          'm3u'   =>	'text/plain',
          'xspf'  =>	'application/xspf+xml',
          'vlc'   =>	'application/videolan',
          'wmv'   =>	array('video/x-ms-wmv', 'video/x-ms-asf'),
          'au'    =>	'audio/x-au',
          'ac3'   =>	'audio/ac3',
          'flac'  =>	'audio/x-flac',
          'ogg'   =>	'audio/ogg',
          'kmz'	=>	array('application/vnd.google-earth.kmz', 'application/zip', 'application/x-zip'),
          'kml'	=>	array('application/vnd.google-earth.kml+xml', 'application/xml', 'text/xml'),
          'ics'	=>	'text/calendar',
          'ical'	=>	'text/calendar',
          'zsh'	=>	'text/x-scriptzsh',
          '7zip'	=>	array('application/x-compressed', 'application/x-zip-compressed', 'application/zip', 'multipart/x-zip'),
          'cdr'	=>	array('application/cdr', 'application/coreldraw', 'application/x-cdr', 'application/x-coreldraw', 'image/cdr', 'image/x-cdr', 'zz-application/zz-winassoc-cdr'),
          'wma'	=>	array('audio/x-ms-wma', 'video/x-ms-asf'),
          'jar'	=>	array('application/java-archive', 'application/x-java-application', 'application/x-jar', 'application/x-compressed'),
          'svg'	=>	array('image/svg+xml', 'application/xml', 'text/xml'),
          'vcf'	=>	'text/x-vcard'
        );

        if (($ext = array_search($mime_type, $mapping, TRUE))) {
          return $ext;
        }

        foreach ($mapping as $ext => $mimes) {
          if (is_array($mimes) && in_array($mime_type, $mimes)) {
            return $ext;
          }
        }

        return FALSE;

      }

}
//

?>
