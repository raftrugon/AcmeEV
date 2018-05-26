<?php
namespace App\Http\ViewComposers;

use App\Conversation;
use App\Repositories\ConversationRepo;
use App\Repositories\MessageRepo;
use App\Repositories\UserRepo;
use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $users = User::orderBy('users.surname','ASC')->orderBy('users.name','DESC')->select('users.id',DB::raw('CONCAT(users.surname,", ",users.name) as full_name'))->get();
            $view->with('users',$users);
        }
    }
}