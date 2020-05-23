@extends('layout')


@section('content')

<div class="header">
    <h3 class="font-weight-bold">
       Facebook Messages
    </h3>
    <div class="bottom-line"></div>
</div>

@include('messages')

<div class="message-box">
    <div class="message-header">
        <i class="fab fa-facebook-messenger"></i> Messages
        <select class="messages-pages" id="messagePageID">
            <option value="1">Ammar</option>
        </select>
    </div>

    <div class="page-inbox-loader">
        <div class="message">
            <img src="{{ asset('img/message-loader.svg') }}"/>
        </div>
        <div class="message">
            <img src="{{ asset('img/message-loader.svg') }}"/>
        </div>
        <div class="message">
            <img src="{{ asset('img/message-loader.svg') }}"/>
        </div>
    </div>

    <div class="page-messages-holder">

    </div>




</div>

@endSection

<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="messageModalLabel">
              Facebook Conversation
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
            <div class="loading-div">

                <img src="{{ asset('img/message-loader.svg') }}"/>
                <img src="{{ asset('img/message-loader.svg') }}"/>
                <img src="{{ asset('img/message-loader.svg') }}"/>
            </div>

            <div class="modal-messages-holder">
                <!-- TO LOAD AJAX MSGS -->
            </div>


            <form action="#" id="messengerReply">
                <textarea name="" id="message-area" placeholder="Enter Your Message"></textarea>
                <input type="hidden" id="conversation_id" value=""/>
                <input type="hidden" id="page_id" value="1"/>
                <button class="btn btn-primary ml-auto d-block btn-sm" id="sendBtn">
                    Send
                </button>
            </form>
        </div>
      </div>
    </div>
  </div>

  @section('scripts')
  <script>
      $('document').ready(function(){
        loadMessages();
      })
  </script>
  @endsection
