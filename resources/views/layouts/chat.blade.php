<nav class="nav nav-pills nav-justified chat-list">

</nav>

<div class="chat-container">
    <div class="chat-header bg-dark d-flex justify-content-between">
        <h1 class="display-4 chat-title"></h1>
        <div class="chat-buttons d-flex flex-row-reverse">
            <a href="#" id="chat-btn-close"><i class="fas fa-times"></i></a>
            <a href="#" id="chat-btn-min"><i class="fas fa-minus"></i></a>
        </div>
    </div>
    {{--Insert Conversations Here--}}
</div>

<template id="message_sent_template">
    <div class="message message-sent">
        <span class="timestamp"></span>
    </div>
</template>

<template id="message_received_template">
    <div class="message message-received">
        <span class="timestamp"></span>
    </div>
</template>

<template id="chat_window_template">
    <div data-id="" class="chat-window">
        <div class="messages"></div>
        <div class="send-div">
            <form class="new_message_form form-inline">
                <input type="hidden" name="conversation_id" value=""/>
                <input type="text" name="body" class="new-message-input form-control" value=""/>
                <button type="submit" class="btn btn-outline-success new-message-btn"><i class="far fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
</template>