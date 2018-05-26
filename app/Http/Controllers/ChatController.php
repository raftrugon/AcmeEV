<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Repositories\ConversationRepo;
use App\Repositories\GroupRepo;
use App\Repositories\MessageRepo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class ChatController extends Controller
{
    protected $conversationRepo;
    protected $messageRepo;
    protected $groupRepo;

    public function __construct(ConversationRepo $conversationRepo, MessageRepo $messageRepo, GroupRepo $groupRepo){
        $this->conversationRepo = $conversationRepo;
        $this->messageRepo = $messageRepo;
        $this->groupRepo = $groupRepo;
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

    public function getLoadChats(){
        $conversations = Conversation::find(Session::get('conversations',array()));
        $myGroups = $this->groupRepo->getMyGroupsForThisYear()->get()->pluck('id')->toArray();
        $groupConversations = Conversation::whereIn('group_id',$myGroups)
            ->get();
        $conversations = $conversations->merge($groupConversations);
        $users = User::orderBy('surname','ASC')->orderBy('name','ASC')->get();
        $windows = View::make('layouts.chat.conversations',compact('conversations'))->render();
        $links = View::make('layouts.chat.links',compact('conversations','users'))->render();
        return compact('windows','links');
    }

    public function postNewChat(Request $request){
        $conversation = $this->conversationRepo->findConversation(Auth::id(),$request->input('user_id'))->first();
        if(is_null($conversation)) $conversation = $this->conversationRepo->create(['user1_id'=>Auth::id(),'user2_id'=>$request->input('user_id')]);
        $conversation['name'] = $conversation->getName();
        $window = View::make('layouts.chat.conversations',['conversations'=>array($conversation)])->render();
        $link = '<a data-id="'.$conversation->getId().'" class="chat-tab">'.$conversation->getName();
        if($conversation->isUnread()) $link .= '<span class="not-read-badge badge badge-primary">!</span>';
        $link .= '</a>';
        $id = $conversation->getId();
        $name = $conversation->getName();
        Session::push('conversations',$conversation->getId());
        return compact('window','link','id','name');
    }

    public function postCloseChat(Request $request){
        $ids = Session::pull('conversations',array());
        unset($ids[array_search($request->input('conversation_id'),$ids)]);
        Session::put('conversations',$ids);
        Session::forget('conversation.opened');
    }

    public function postOpenChat(Request $request){
        $conversation = Conversation::findOrFail($request->input('conversation_id'));
        $conversation->getMessages->each(function($mensaje){
            if(!$mensaje->isRead() && !$mensaje->isMine()){
                $mensaje->addReadBy(Auth::id());
                $this->messageRepo->updateWithoutData($mensaje);
            }
        });
        Session::put('conversation.opened',$conversation->getId());
    }

    public function postMinChat(Request $request){
        $conversation = Conversation::findOrFail($request->input('conversation_id'));
        Session::forget('conversation.opened');

    }
}
