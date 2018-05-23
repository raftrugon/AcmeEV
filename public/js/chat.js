$(function(){
   $('.chat-tab').click(function(){
        toggleTab($(this).data('id'),$(this).html());
   });
   $('#chat-btn-min').click(function(){
       hideTab($(this).data('id'));
   });
    $('#chat-btn-close').click(function(){
        let id = $('.chat-container').data('id');
        $('.chat-window[data-id='+id+']').remove();
        $('.chat-tab[data-id='+id+']').remove();
        $('.chat-container').hide();
    });
    $('.new_message_form').submit(function(){
        if($(this).find('input[name=body]').val() === '') return false;
       sendMessage($(this));
       return false;
    });
    $('.new-message-btn').keyup(function(e){
        if(event.keyCode === '13') $(this).closest('form').submit();
    });
    setInterval(retrieveMessages,2000);
});

function showTab(id,title){
    $('.chat-window:not([data-id='+id+'])').hide();
    $('.chat-window[data-id='+id+']').show();
    $('.chat-title').html(title);
    $('.chat-container').show().data('id',id);
    $('.chat-window[data-id='+id+']').find('input[name=body]').focus();
    let messagesDiv = $('.chat-window[data-id='+id+']').find('.messages');
    messagesDiv.animate({ scrollTop: messagesDiv.prop("scrollHeight")}, 700);
}

function hideTab(id){
    $('.chat-window').hide();
    $('.chat-container').hide().data('id','');
}

function toggleTab(id,title){
    if($('.chat-container').data('id') !== id){
        showTab(id,title);
    }else{
        hideTab(id);
    }
}

function addSentMessage(conversation_id,body){
    console.log(conversation_id+'--'+body);
    let div = document.importNode(document.getElementById('message_sent_template').content.querySelector('div'),true);
    div.textContent = body;
    let messagesDiv = $('.chat-window[data-id='+conversation_id+']').find('.messages');
    messagesDiv.append(div).animate({ scrollTop: messagesDiv.prop("scrollHeight")}, 700);

}

function addReceivedMessage(conversation_id,body){
    console.log(conversation_id+'--'+body);
    let div = document.importNode(document.getElementById('message_received_template').content.querySelector('div'),true);
    div.textContent = body;
    let messagesDiv = $('.chat-window[data-id='+conversation_id+']').find('.messages');
    messagesDiv.append(div).animate({ scrollTop: messagesDiv.prop("scrollHeight")}, 700);
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
            message(value['full_name'],value['body']);
            addReceivedMessage(value['conversation_id'],value['body']);
            showTab(value['conversation_id']);
        });
    });
}

