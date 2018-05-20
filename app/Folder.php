<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
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

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($value){
        $this->description = $value;
    }

    public function getParent(){
        return $this->belongsTo('App\Folder','parent_id','id');
    }

    public function setParent($value){
        $this->parent_id = $value;
    }

    public function getSubjectInstance(){
        return $this->belongsTo('App\SubjectInstance','subject_instance_id','id');
    }

    public function setSubjectInstance($value){
        $this->subject_instance_id = $value;
    }

    public function getGroup(){
        return $this->belongsTo('App\Group','group_id','id');
    }

    public function setGroup($value){
        $this->group_id = $value;
    }

    public function getSubFolders(){
        return $this->hasMany('App\Folder','parent_id','id');
    }

    public function getFiles(){
        return $this->hasMany('App\File','folder_id','id');
    }


}
