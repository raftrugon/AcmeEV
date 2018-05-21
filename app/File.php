<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = [];


    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($value){
        $this->name = $value;
    }

    public function getUrl(){
        return $this->url;
    }

    public function setUrl($value){
        $this->value = $value;
    }

    public function getFolder(){
        return $this->belongsTo('App\Folder','folder_id','id');
    }

    public function setFolder($value){
        $this->folder_id = $value;
    }
}
