<?php

namespace App\Http\Controllers;

use App\Repositories\ConversationRepo;
use App\Repositories\MessageRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    protected $conversationRepo;
    protected $messageRepo;

    public function __construct(ConversationRepo $conversationRepo, MessageRepo $messageRepo){
        $this->conversationRepo = $conversationRepo;
        $this->messageRepo = $messageRepo;
    }

    public function postNewMessage(Request $request){
        try {
            $this->messageRepo->create(['conversation_id' => $request->input('conversation_id'), 'body' => $request->input('body'), 'sender_id' => Auth::id()]);
            return 'true';
        }catch(\Exception $e){
            return 'false';
        }
    }

    public function getUnreadMessages(){
        return $this->messageRepo->getUnreadMessages();
    }
}
