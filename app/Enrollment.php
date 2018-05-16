<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{

    public function getUserId(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function setUserId($value){
        $this->user_id=$value;
    }




    public function getSubjectInstanceId(){
        return $this->belongsTo('App\SubjectInstance','subject_instance_id','id');
    }

    public function setSubjectInstanceId($value){
        $this->subject_instance_id=$value;
    }
}
