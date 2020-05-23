
@for($j=$length; $j>=0; $j--)
    <div class="modal-message">
        <div class="message-profile">
            <img src="{{asset('img/default.png')}}" alt="">
            <div>
                <span class="user">{{ $messages[$j]->getField('from')->getField('name') }}</span><br>
                <span class="last-message-time">
                    <i class="fas fa-clock"></i>
                    {{ $messages[$j]->getField('created_time')->format('F j, Y. h:i a') }}
                </span>
            </div>
        </div>
        <p class="message-body">
            {{ $messages[$j]->getField('message') }}
        </p>
    </div>
@endfor
