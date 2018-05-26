<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Conversation extends Model
{
    protected $guarded = [];
    
    public function getId(){
        return $this->id;
    }
    
    public function getUser1(){
        return $this->belongsTo('App\User','user1_id','id');
    }
    
    public function setUser1($value){
        $this->user1_id = $value;
    }

    public function getUser2(){
        return $this->belongsTo('App\User','user2_id','id');
    }

    public function setUser2($value){
        $this->user2_id = $value;
    }

    public function getGroup(){
        return $this->belongsTo('App\Group','group_id','id');
    }

    public function setGroup($value){
        $this->group_id = $value;
    }

    public function getMessages(){
        return $this->hasMany('App\Message','conversation_id','id');
    }

    public function getName(){
        return is_null($this->getGroup) ?
            ($this->getUser1->getId() == Auth::id() ? $this->getUser2->getFullName() : $this->getUser1->getFullName())
            : $this->getGroup->getSubjectInstance->getSubject->getName();
    }

    public function getOtherId(){
        return is_null($this->getGroup) ?
            ($this->getUser1->getId() == Auth::id() ? $this->getUser2->getId() : $this->getUser1->getId())
            : $this->getGroup->getId();
    }

    public function isUnread(){
        return $this->getMessages->filter(function($message){
                                        return !$message->isRead();
                                    })->count() > 0;
    }

}
