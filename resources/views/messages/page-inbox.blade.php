@if(count($messages) > 0)
@foreach($messages as $inbox)

@php
    $messages = $inbox->getField('messages');
    $participants = $inbox->getField('participants');
    $name = $participants[0]->getField('name');
@endphp

<div class="message" data-conversation-id="{{ $inbox->getField('id') }}">
    <div class="message-profile">
        <img src="{{asset('img/default.png')}}" alt="">
        <div>
        <span class="user">{{ $name }}</span><br>
            <span class="last-message-time">
                <i class="fas fa-clock"></i>
                {{ $messages[0]->getField('created_time')->format('F j, Y. h:i a') }}
            </span>
        </div>
    </div>
    <p class="message-body">
        {{ $messages[0]->getField('message') }}
    </p>
</div>
@endforeach

@else
<div class="message">
    No Messages
</div>
@endif
