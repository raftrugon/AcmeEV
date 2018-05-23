<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    protected $guarded = [];

    public function getId(){
        return $this->id;
    }

    public function getBody(){
        return $this->body;
    }

    public function setBody($value){
        $this->body = $value;
    }

    public function getSender(){
        return $this->belongsTo('App\User','sender_id','id');
    }

    public function setSender($value){
        $this->sender_id = $value;
    }

    public function getConversation(){
        return $this->belongsTo('App\Conversation','conversation_id','id');
    }

    public function setConversation($value){
        $this->conversation_id = $value;
    }

    public function getTimestamp(){
        return \Carbon\Carbon::createFromFormat('Y-m-d HH:ii:ss',$this->created_at);
    }

    public function isMine(){
        return $this->getSender->getId() == Auth::id();
    }

    public function getDeliveredTo(){
        return is_null($this->delivered_to) ? array() : explode(',',$this->delivered_to);
    }

    public function addDeliveredTo($value){
        $this->delivered_to = is_null($this->delivered_to) ? $value : $this->delivered_to.','.$value;
    }

    public function isDelivered(){
        return in_array(Auth::id(),$this->getDeliveredTo());
    }
}
