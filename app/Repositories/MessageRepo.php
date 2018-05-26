<?php

namespace App\Repositories;

use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageRepo extends BaseRepo
{

    protected $conversationRepo;
    protected $groupRepo;

    public function __construct(ConversationRepo $conversationRepo, GroupRepo $groupRepo)
    {
        $this->conversationRepo = $conversationRepo;
        $this->groupRepo = $groupRepo;
    }

    public function getModel()
    {
        return new Message;
    }

    public function getUnreadMessages(){
        $myGroups = $this->groupRepo->getMyGroupsForThisYear()->get()->pluck('id')->toArray();
        $messages = Message::
            join('conversations','conversations.id','=','messages.conversation_id')
            ->join('users as senders','messages.sender_id','=','senders.id')
            ->where(function($subquery) use($myGroups) {
                $subquery->where('conversations.user1_id', Auth::id())
                    ->orWhere('conversations.user2_id', Auth::id())
                    ->orWhereIn('group_id',$myGroups);
            })
            ->where('messages.sender_id','<>',Auth::id())
            ->select('messages.*',DB::raw('concat(senders.name," ",senders.surname) as full_name'))
            ->get();
        $notread = $messages->filter(function ($value){
            return !in_array(Auth::id(),$value->getDeliveredTo());
        });
        $notread->each(function($mensaje){
            $mensaje->addDeliveredTo(Auth::id());
            $this->updateWithoutData($mensaje);
        });
        return $notread;
    }

    public function markUnreadAsReadForConversations($conversations){
        $mensajes = $conversations->map(function ($item,$key){
            return $item->getMessages;
        })->flatten();
        $mensajes->each(function($mensaje){
            if(!$mensaje->isRead() && !$mensaje->isMine()){
                $mensaje->addReadBy(Auth::id());
                $this->updateWithoutData($mensaje);
            }
        });
    }
}