<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Enrollment extends Pivot
{

    protected $guarded = [];
    protected $table = 'enrollments';

    public function getId(){
        return $this->id;
    }




    public function getUserId(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function setUserId($value){
        $this->user_id=$value;
    }




    public function getSubjectInstance(){
        return $this->belongsTo('App\SubjectInstance','subject_instance_id','id');
    }

    public function setSubjectInstance($value){
        $this->subject_instance_id=$value;
    }

    public function getMinutes() {
        return $this->hasMany('App\Minute','enrollment_id','id');
    }
}
