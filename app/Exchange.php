<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    protected $guarded = ['is_approved'];

    public function getId(){
        return $this->id;
    }

    public function getIsApproved(){
        return $this->is_approved;
    }

    public function setIsApproved($value){
        $this->is_approved = $value;
    }

    public function getSource(){
        return $this->belongsTo('App\Group','source_id','id');
    }

    public function setSource($value){
        $this->source_id = $value;
    }

    public function getTarget(){
        return $this->belongsTo('App\Group','target_id','id');
    }

    public function setTarget($value){
        $this->target_id = $value;
    }

    public function getUser(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function setUser($value){
        $this->user_id = $value;
    }
}
