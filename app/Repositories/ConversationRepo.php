<?php

namespace App\Repositories;

use App\Conversation;
use Illuminate\Support\Facades\Auth;

class ConversationRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
        return new Conversation;
    }

    public function getMyConversations(){
       return Conversation::where(function($subquery){
            $subquery->where('user1_id',Auth::id())
                ->orWhere('user2_id',Auth::id());
        });

    }
}