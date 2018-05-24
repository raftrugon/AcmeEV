<nav class="nav nav-pills nav-justified chat-list">
    @php($usersStr = '<select class="picker" data-size="5" data-live-search="true">')
    @foreach($users as $user)
        @php($usersStr .= '<option value="'.$user->id.'">'.$user->full_name.'</option>')
    @endforeach
    @php($usersStr .= '</select>')
    <a tabindex="0" class="new-chat-tab chat-tab" data-toggle="popover" data-placement="top" data-content="{{$usersStr}}"><i class="fas fa-plus"></i></a>
    @php($groupsStr = '')
    @foreach($conversations as $conversation)
    @if(is_null($conversation->getGroup))
        <a data-id="{{$conversation->getId()}}" class="chat-tab">{{$conversation->getName()}}</a>
    @else
        @php($groupsStr .= '<a href="#" data-id=\''.$conversation->getId().'\' class=\'nav-link chat-tab\'>'.$conversation->getName().'</a>')
    @endif
    @endforeach
    <a tabindex="0" class="groups-tab chat-tab" data-toggle="popover" data-placement="top" data-content="{{$groupsStr}}">Groups</a>
</nav>

<div class="chat-container">
    <div class="chat-header bg-dark d-flex justify-content-between">
        <h1 class="display-4 chat-title"></h1>
        <div class="chat-buttons d-flex flex-row-reverse">
            <a href="#" id="chat-btn-close"><i class="fas fa-times"></i></a>
            <a href="#" id="chat-btn-min"><i class="fas fa-minus"></i></a>
        </div>
    </div>
    @foreach($conversations as $conversation)
    <div data-id="{{$conversation->getId()}}" class="chat-window">
        <div class="messages">
        @foreach($conversation->getMessages as $index => $message)
            @if($loop->first || $conversation->getMessages->get($index-1)->getSender->getId() != $message->getSender->getId())
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
            @if($loop->last)<br/><span class="timestamp">{{$message->getTimestamp()->format('d/m/Y H:i:s')}}</span></div>@endif
        @endforeach
        </div>
        <div class="send-div">
            <form class="new_message_form form-inline">
                <input type="hidden" name="conversation_id" value="{{$conversation->getId()}}"/>
                <input type="text" name="body" class="new-message-input form-control" value=""/>
                <button type="submit" class="btn btn-outline-success new-message-btn"><i class="far fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<template id="message_sent_template">
    <div class="message message-sent"></div>
</template>

<template id="message_received_template">
    <div class="message message-received"></div>
</template>