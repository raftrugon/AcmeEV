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
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$this->created_at);
    }

    public function isMine(){
        return $this->getSender->getId() == Auth::id();
    }

    public function getReadBy(){
        return is_null($this->read_by) ? array() : explode(',',$this->read_by);
    }

    public function addReadBy($value){
        $this->read_by = is_null($this->read_by) ? $value : $this->read_by.','.$value;
    }

    public function isRead(){
        return in_array(Auth::id(),$this->getReadBy()) || $this->isMine();
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
