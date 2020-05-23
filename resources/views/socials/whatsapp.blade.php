@extends('layout')


@section('content')


<div class="header">
    <h3 class="font-weight-bold">
        {{ $title}}
    </h3>
    <div class="bottom-line"></div>
</div>

<?php
$response = json_decode(file_get_contents("https://api.chat-api.com/instance130455/status?token=b52m9hexv2pxrdy9"));

$val = false;

foreach ($response as $key => $value) {
    if($key == "accountStatus" && $value == "authenticated") {
        $val = true;
    }
}

?>


<div class="profile whatsapp">
    <div>
         <a href="">
                <img src="{{asset('img/default.png')}}" alt="">
             <span>
                 Anonymous
                 <br>
                 <small>10 messages so far!</small>
             </span>
 
         </a>
    </div>

    <div>
        <a href="">
               <img src="{{asset('img/default.png')}}" alt="">
            <span>
                Anonymous
                <br>
                <small>10 messages so far!</small>
            </span>

        </a>
   </div>
 
</div>

@if($val)  
    <div class="page"> 
        
        <div class="contacts">
            <form action="{{ action('WhatsAppController@contact') }}" method="POST">
                {{ csrf_field() }}
                <input type="text" placeholder="Enter Name" name="name" class="{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
                <input type="text" placeholder="Enter Number" name="number" class="{{ $errors->has('number') ? ' has-error' : '' }}">
                {!! $errors->first('number', '<small class="help-block">:message</small>') !!}
                <button class="btn btn-primary btn-sm d-block ml-auto mt-2" type="submit">
                    Add Contact
                </button>
            </form>

            <div class="contact-wrapper">
                <div class="contact-container">
                    <h3>Your Contacts</h3>
                    @if($contacts)
                    <?php foreach($contacts as $contact): ?>
                    <div class="contact">
                        <span class="contact-name">
                            {{$contact->name}}
                        </span>
                        <span>
                            <button type="button" onclick="showContactInfo(this)">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                        </span>
                        <input type="hidden" class="id-value" value="{{$contact->id}}">
                        <input type="hidden" class="name-value" value="{{$contact->name}}">
                        <input type="hidden" class="number-value" value="{{$contact->number}}">
                    </div>
                    <?php endforeach; ?>
                    @else
                    <small>
                        You have no contacts at the moment
                    </small>
                    @endif
                  
                    <div class="contact-info" id="contact-desc">
                        <button id="remove-contact-box">
                            <i class="fas fa-times"></i>
                        </button>
                        <input type="hidden" id="contact-id-val" value="">
                        <input type="text" placeholder="Your Name" value="" id="contact-name-val">
                        <input type="text" placeholder="Your Number" value="" id="contact-number-val">
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-primary btn-sm d-block mr-2 mt-2" onclick="updateContactInfo(this)">
                                Edit Contact
                            </button>
                            <button class="btn btn-danger btn-sm d-block mr-2 mt-2" onclick="removeContactInfo(this)">
                                Remove Contact
                            </button>
                        </div>
            
                    </div>
                </div>
            </div>
            
        </div>
        <div class="marvel-device nexus5">
        <div class="top-bar"></div>
        <div class="sleep"></div>
        <div class="volume"></div>
        <div class="camera"></div>
        <div class="screen">
            <div class="screen-container">
            <div class="status-bar">
                <div class="time"></div>
                <div class="battery">
                <i class="zmdi zmdi-battery"></i>
                </div>
                <div class="network">
                <i class="zmdi zmdi-network"></i>
                </div>
                <div class="wifi">
                <i class="zmdi zmdi-wifi-alt-2"></i>
                </div>
                <div class="star">
                <i class="zmdi zmdi-star"></i>
                </div>
            </div>
            <div class="chat">
                <div class="chat-container">
                <div class="user-bar">
                    <div class="back">
                    <i class="zmdi zmdi-arrow-left"></i>
                    </div>
                    <div class="avatar">
                    <img src="https://i.ibb.co/2Yg7tWv/Rumbiiha-Swaibu.jpg" alt="Avatar">
                    </div>
                    <div class="name">
                    <span>Rumbiiha s.</span>
                    <span class="status">online</span>
                    </div>
                    <div class="actions more">
                    <i class="zmdi zmdi-more-vert"></i>
                    </div>
                    <div class="actions attachment">
                    <i class="zmdi zmdi-phone"></i>
                    </div>
                    <div class="actions">
                               
                    </div>
                </div>
                <div class="conversation">
                    <div class="conversation-container">
                    {{-- <div class="message sent">
                        What happened last night swaibu?
                        <span class="metadata">
                            <span class="time"></span><span class="tick"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck-ack" x="2063" y="2076"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#4fc3f7"/></svg></span>
                        </span>
                    </div> --}}
                    <div class="message received">
                        Send me a message
                        <span class="metadata"><span class="time"></span></span>
                    </div>
{{-- 
                     <div class="message sent">
                        <img src="https://www.rd.com/wp-content/uploads/2019/09/walruses-e1567629015796.jpg" alt="" class="message-image">
                        What happened last night swaibu?
                        <span class="metadata">
                            <span class="time"></span><span class="tick"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck-ack" x="2063" y="2076"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#4fc3f7"/></svg></span>
                        </span>
                    </div> --}}

               
                    
                    </div>
                    <form class="conversation-compose" method="POST" enctype="multipart/form-data">
                    
                        <textarea class="input-msg" name="input" placeholder="Type a message.." autocomplete="off" autofocus id="input-msg"></textarea>
                        <div class="whatsapp-upload">
                        <button type="button" id="whatsapp-image-upload">
                            <i class="fas fa-camera"></i>
                        </button>
                        <button  type="button" id="whatsapp-video-upload">
                                <i class="fas fa-video"></i>
                            </button>
                            <input type="file" id="whatsapp-image" name="whatsapp-image">
                            <input type="file" id="whatsapp-video" name="whatsapp-video">
                        </div>
                        <button class="send" type="submit">
                            <div class="circle">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                        </button>
                    </form>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="whatsapp-previews">
            <div class="whatsapp-image-preview">
                <small id="img-small">
                    Your Image Here
                </small>

                <img src="https://i.vimeocdn.com/portrait/10406110_300x300" alt="">
                <button id="whatsapp-remove-image-btn">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>
            <div class="whatsapp-video-preview">
                <small id="video-small">
                    Your Video Here
                </small>
                <video src="" controls>

                </video>
                <button id="whatsapp-remove-video-btn">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>
        </div>
    </div>
    <br><br><br>
@else
    <div class="qr-scanner">
       <div>
            <p class="font-weight-bold">
                To send and receive messages, you have to authorize our server like for WhatsApp Web.  
            </p>
            <ul>
                <li>
                    1. Open Whatsapp on your phone
                </li>
                <li>
                    2. Tap menu or settings and select WhatsApp Web.
                </li>
                <li>
                    3. Point your phone to this screen to capture code
                </li>
            </ul>
       </div>
        <div>
            <img src="https://api.chat-api.com/instance130455/qr_code?token=b52m9hexv2pxrdy9" alt="">
        </div> 
    </div>
@endif


<script>
   $(document).ready(function(){    

        function progressHandle(){
            $.get("whatsapp/check", { _token: CSRF_TOKEN }, function(data){
                if(data == "YES"){
                    clearTimeout(progressHandle);
                    console.log("progress canceled");
                    if($(".page").length == 0)
                        location.reload();
                }else {
                    setTimeout(progressHandle, 2000);
                }
                console.log("searching...");
            })
        }
        
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        setTimeout(progressHandle, 2000);

        

        console.log("here")
   });

    

</script>

@endSection


