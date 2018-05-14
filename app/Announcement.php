<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{

    protected $guarded = [];

    public function getId(){
        return $this->id;
    }




    public function getTitle(){
        return $this->title;
    }

    public function setTitle($value){
        $this->title = $value;
    }




    public function getBody(){
        return $this->body;
    }

    public function setBody($value){
        $this->body = $value;
    }




    public function getCreationMoment(){
        return $this->creation_moment;
    }

    public function setCreationMoment($value){
        $this->creation_moment = $value;
    }
}
