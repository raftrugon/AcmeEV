$(function(){
   $('body').on('click','.chat-tab',function(){
       let id = $(this).data('id');
       if(id !== undefined) toggleTab(id);
   });
    $('body').on('submit','.new_message_form',function(){
        if($(this).find('input[name=body]').val() === '') return false;
        sendMessage($(this));
        return false;
    });
    $('body').on('keyup','.new-message-btn',function(e){
        if(e.keyCode === '13') $(this).closest('form').submit();
    });
   $('#chat-btn-min').click(function(){
       hideTab($('.chat-container').data('id'));
   });
    $('#chat-btn-close').click(function(){
        closeChat($('.chat-container').data('id'));
    });
    setInterval(retrieveMessages,2000);
});

function showTab(id = 0,userId = 0){
    if(id === 0){
        id =  $('.chat-window[data-user-id='+userId+']').data('id');
    }
    $('.chat-window:not([data-id='+id+'])').hide();
    let chat = $('.chat-window[data-id='+id+']');
    chat.show();
    $('.chat-title').html(chat.data('name'));
    $('.chat-container').show().data('id',id);
    chat.find('input[name=body]').focus();
    let messagesDiv = chat.find('.messages');
    messagesDiv.animate({ scrollTop: messagesDiv.prop("scrollHeight")}, 700);
    $('.chat-tab[data-id='+id+']').find('span').remove();
    $.post(urlOpenChat,{conversation_id:id});
}

function hideTab(id){
    $('.chat-window').hide();
    $('.chat-container').hide().data('id','');
    $.post(urlMinChat,{conversation_id:id});
}

function toggleTab(id){
    console.log($('.chat-container').data('id'));
    console.log(id);
    console.log($('.chat-container').data('id') !== id);
    if($('.chat-container').data('id') !== id){
        showTab(id);
    }else{
        hideTab(id);
    }
}

function addSentMessage(conversation_id,body){
    console.log(conversation_id+'--'+body);
    let messagesDiv = $('.chat-window[data-id='+conversation_id+']').find('.messages');
    if(messagesDiv.find('.message-sent').length === 0 || !messagesDiv.find('.message:last').hasClass('message-sent')) {
        let div = document.importNode(document.getElementById('message_sent_template').content.querySelector('div'),true);
        $(div).find('span').before(body+'<br/>');
        $(div).find('span').html(moment().format('DD/MM/YYYY HH:mm'));
        messagesDiv.append(div).animate({ scrollTop: messagesDiv.prop("scrollHeight")}, 700);
    }else{
        messagesDiv.find('.message-sent:last').find('span').before(body+'<br/>');
        messagesDiv.animate({ scrollTop: messagesDiv.prop("scrollHeight")}, 700);
    }
}

function addReceivedMessage(conversation_id,body,sender_id,sender_name){
    let messagesDiv = $('.chat-window[data-id='+conversation_id+']').find('.messages');
    if(messagesDiv.find('.message-received').length === 0 || !messagesDiv.find('.message:last').hasClass('message-received') || messagesDiv.find('.message:last').data('sender-id') !== sender_id) {
        let div = document.importNode(document.getElementById('message_received_template').content.querySelector('div'), true);
        if($('.chat-window[data-id='+conversation_id+']').hasClass('group-chat')) {
            $(div).data('sender-id', sender_id);
            $(div).find('span').before('<strong>' + sender_name + '</strong><br/>' + body + '<br/>');
        }else{
            $(div).find('span').before(body + '<br/>');
        }
        $(div).find('span').html(moment().format('DD/MM/YYYY HH:mm'));
        messagesDiv.append(div).animate({scrollTop: messagesDiv.prop("scrollHeight")}, 700);
    }else{
        messagesDiv.find('.message-received:last').find('span').before(body+'<br/>');
        messagesDiv.animate({ scrollTop: messagesDiv.prop("scrollHeight")}, 700);
    }
    let numberSpan = $('.chat-tab[data-id='+conversation_id+']').find('span');
    if($('.chat-container').data('id') !== conversation_id && numberSpan.length === 0) $('.chat-tab[data-id='+conversation_id+']').append('<span class="not-read-badge badge badge-primary">1</span>');
    else if($('.chat-container').data('id') !== conversation_id && numberSpan.length !== 0) numberSpan.html(parseInt(numberSpan.html())+1);
}

function sendMessage(form){
    $.post(urlNewMessage,form.serialize(),function(data){
       if(data==='true'){
           let msg = $(form).find('input[name=body]').val();
           let conversation_id = $(form).find('input[name=conversation_id]').val();
           addSentMessage(conversation_id,msg);
           $(form).find('input[name=body]').val('');
       }else{
           //alert('nope')
       }
    });
}

function retrieveMessages(){
    $.get(urlRetrieveMessages,function(data){
        $.each(data,function(i,value){
            if($('.chat-window[data-id='+value['conversation_id']+']').hasClass('group-chat')){
                groupMessage(value['full_name'], value['body'], value['sender_name'],value['conversation_id']);
            }else {
                message(value['full_name'], value['body'],value['conversation_id']);
            }
            if($.inArray(parseInt(value['conversation_id']),getActiveConversationsById())  === -1) retrieveChat(value['sender_id']);
            else {
                addReceivedMessage(value['conversation_id'], value['body'], value['sender_id'], value['sender_name']);
            }
        });
    });
}

function retrieveChat(id){
    $.post(urlNewChat,{user_id:id},function(data){
        //Añadimos la ventana del chat al html
        $('.chat-container').append(data['window']);
        //Añadimos el link del chat al html
        $('.groups-tab').before(data['link']);
        lastCreatedChat = '';
        showTab(data['id']);
    });
}

function getActiveConversationsByUser(){
    let ids = [];
    $('.chat-window').each(function () {
        ids.push($(this).data('user-id'));
    });
    return ids;
}

function getActiveConversationsById(){
    let ids = [];
    $('.chat-window').each(function () {
        ids.push($(this).data('id'));
    });
    return ids;
}

function closeChat(id){
    if($('.chat-window[data-id='+id+']').hasClass('group-chat')) return hideTab(id);
    $.post(urlCloseChat,{conversation_id:id},function(){
        $('.chat-window[data-id='+id+']').remove();
        $('.chat-tab[data-id='+id+']').remove();
        $('.chat-container').hide();
    });
}

function loadChats(id = 0){
    $.get(urlLoadChats,function(data){
        $('.chat-container').append(data['windows']);
        $('.chat-list').append(data['links']);
        $('.chat-picker').selectpicker({
            container:'body',
            liveSearchNormalize:true
        });
        $('.chat-picker').change(function(){
            let id = $('.chat-picker').find('option:selected').val();
            let name = $('.chat-picker').find('option:selected').html();
            if(id === '' || id === lastCreatedChat) return false;
            lastCreatedChat = id;
            $('.chat-picker').selectpicker('val','');
            if($.inArray(parseInt(id),getActiveConversationsByUser())  === -1) retrieveChat(id);
            else {
                showTab(0,id);
                lastCreatedChat = '';
            }
        });
        $('.groups-tab').popover({
            html : true,
            title: groupsPopoverTitle,
            trigger:'focus',
            container:'body',
            template:'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body nav flex-column nav-pills"></div></div>'
        });
        if(id !== 0) showTab(id);
    });
}

