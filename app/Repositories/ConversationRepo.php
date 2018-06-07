<?php

namespace App\Repositories;

use App\Conversation;
use App\Group;
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
        $myGroups = $this->getMyGroupsForThisYear()->pluck('id')->toArray();
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

    public function getMyGroupsForThisYear(){
        if(Auth::user()->hasRole('student')) {
            return Auth::user()->getGroups()
                ->join('subject_instances', 'groups.subject_instance_id', '=', 'subject_instances.id')
                ->where('academic_year', $this->getAcademicYear())
                ->select('groups.*')
                ->get();
        }elseif(Auth::user()->hasRole('pdi')){
            return Group::where(function($sub) {
                $sub->where('theory_lecturer_id', Auth::id())
                    ->orWhere('practice_lecturer_id', Auth::id());
                })
                ->join('subject_instances', 'groups.subject_instance_id', '=', 'subject_instances.id')
                ->where('academic_year', $this->getAcademicYear())
                ->select('groups.*')
                ->get();

        }
        else{
            return collect(array());
        }
    }
}