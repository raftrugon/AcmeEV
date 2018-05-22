<nav class="nav nav-pills nav-justified chat-list">
    @foreach($conversations as $conversation)
    <a data-id="{{$conversation->getId()}}" class="chat-tab">{{$conversation->getName()}}</a>
    @endforeach
</nav>

<div class="chat-container">
    <div class="chat-header bg-dark d-flex justify-content-between">
        <h1 class="display-4 chat-title"></h1>
        <div class="chat-buttons d-flex flex-row-reverse">
            <a href="#" id="chat-btn-close"><i class="fas fa-times"></i></a>
            <a href="#" id="chat-btn-max"><i class="fas fa-external-link-alt"></i></a>
            <a href="#" id="chat-btn-min"><i class="fas fa-minus"></i></a>
        </div>
    </div>
    @foreach($conversations as $conversation)
    <div data-id="{{$conversation->getId()}}" class="chat-window">
        <div class="messages">
        @foreach($conversation->getMessages as $message)
            @if($message->isMine())
                <div class="message message-sent">
                    {{$message->getBody()}}
                </div>
            @else
                <div class="message message-received">
                    {{$message->getBody()}}
                </div>
            @endif
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