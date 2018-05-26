@foreach($conversations as $conversation)
    <div data-id="{{$conversation->getId()}}" data-user-id="{{$conversation->getOtherId()}}" data-name="{{$conversation->getName()}}" class="chat-window">
        <div class="messages">
            @php($previousSender = '')
            @foreach($conversation->getMessages as $index => $message)
                @if($loop->first || $previousSender != $message->getSender->getId())
                    @unless($loop->first)
                        <br/><span class="timestamp">{{$conversation->getMessages->get($index-1)->getTimestamp()->format('d/m/Y H:i:s')}}</span>
                        </div>
                    @endunless
                    @if($message->isMine())
                        <div class="message message-sent">
                    @else
                        <div class="message message-received">
                    @endif
                @else
                    <br/>
                @endif
                {{$message->getBody()}}
                @if($loop->last)<br/><span class="timestamp">{{$message->getTimestamp()->format('d/m/Y H:i')}}</span></div>@endif
                @php($previousSender = $message->getSender->getId())
                @endforeach
            </div>
            <div class="send-div">
                <form class="new_message_form form-inline">
                    <input type="hidden" name="conversation_id" value="{{$conversation->getId()}}"/>
                    <input type="text" name="body" class="new-message-input form-control" value="" autocomplete="off"/>
                    <button type="submit" class="btn btn-outline-success new-message-btn"><i class="far fa-paper-plane"></i></button>
                </form>
            </div>
    </div>
@endforeach