<?php

namespace App\Repositories;

use App\Message;
use Illuminate\Support\Facades\Auth;

class MessageRepo extends BaseRepo
{

    protected $conversationRepo;

    public function __construct(ConversationRepo $conversationRepo)
    {
        $this->conversationRepo = $conversationRepo;
    }

    public function getModel()
    {
        return new Message;
    }

    public function getUnreadMessages(){
        $messages = Message::
            join('conversations','conversations.id','=','messages.conversation_id')
            ->where(function($subquery) {
                $subquery->where('conversations.user1_id', Auth::id())
                    ->orWhere('conversations.user2_id', Auth::id());
            })
            ->where('messages.sender_id','<>',Auth::id())
            ->select('messages.*')
            ->get();
        $notread = $messages->filter(function ($value){
            return !in_array(Auth::id(),$value->getDeliveredTo());
        });

        $notread->each(function($value){
            $value->addDeliveredTo(Auth::id());
            $this->updateWithoutData($value);
        });

        return $notread;
    }

    public function markUnreadAsReadForConversations($conversations){
        $mensajes = $conversations->map(function ($item,$key){
            return $item->getMessages;
        })->flatten();
        $mensajes->each(function($mensaje){
            if(!$mensaje->isDelivered() && !$mensaje->isMine()){
                $mensaje->addDeliveredTo(Auth::id());
                $this->updateWithoutData($mensaje);
            }
        });
    }
}