<?php
namespace App\Http\ViewComposers;

use App\Conversation;
use App\Repositories\ConversationRepo;
use App\Repositories\MessageRepo;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class GlobalViewComposer {

    protected $conversationRepo;
    protected $messageRepo;

    public function __construct(ConversationRepo $conversationRepo,MessageRepo $messageRepo){
        $this->conversationRepo = $conversationRepo;
        $this->messageRepo = $messageRepo;
    }

    public function compose(View $view) {
        if(Auth::check()){
            $conversations = $this->conversationRepo->getMyConversations()->get();
            $this->messageRepo->markUnreadAsReadForConversations($conversations);
            $view->with('conversations', $conversations);
        }
    }
}