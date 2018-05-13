<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectInstance extends Model
{
    protected $guarded = [];

    public function getId() {
        return $this->id;
    }

    public function getAcademicYear() {
        return $this->academic_year;
    }

    public function setAcademicYear($value) {
        $this->academic_year=$value;
    }

    public function getSubject(){
        return $this->belongsTo('App\Subject','subject_id','id');
    }

    public function setSubject($value){
        $this->subject_id=$value;
    }

    public function getControlChecks(){
        return $this->hasMany('App\ControlCheck','subject_instance_id','id');
    }

    public function getAnnouncements(){
        return $this->hasMany('App\Announcement','subject_instance_id','id');
    }

    public function getFolders(){
        return $this->hasMany('App\Folder','subject_instance_id','id');
    }

    public function getGroups(){
            return $this->hasMany('App\Group','subject_instance_id','id');
    }

    public function getMinutes(){
            return $this->hasMany('App\Minute','subject_instance_id','id');
    }

    public function getEnrolments(){
            return $this->hasMany('App\Enrolment','subject_instance_id','id');
    }


}
