<?php

namespace App\Repositories;

use App\Conversation;
use Illuminate\Support\Facades\Auth;

class ConversationRepo extends BaseRepo
{

    protected $groupRepo;

    public function __construct(GroupRepo $groupRepo)
    {
        $this->groupRepo = $groupRepo;
    }

    public function getModel()
    {
        return new Conversation;
    }

    public function getMyConversations(){
        $myGroups = $this->groupRepo->getMyGroupsForThisYear()->get()->pluck('id')->toArray();
        return Conversation::where(function($subquery) use ($myGroups){
            $subquery->where('user1_id',Auth::id())
                ->orWhere('user2_id',Auth::id())
                ->orWhereIn('group_id',$myGroups);
        });
    }

    public function findConversation($userx,$usery){
        return $this->getModel()->where(function($sub) use ($usery,$userx){
                                $sub->where('user1_id',$userx)->where('user2_id',$usery);
                            })->orWhere(function($sub2) use ($usery,$userx){
                                $sub2->where('user1_id',$usery)->where('user2_id',$userx);
        });
    }
}