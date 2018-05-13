<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded = [];

    public function getId() {
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }
    public function setName($value){
        $this->name=$value;
    }
    public function getCode(){
        return $this->code;
    }
    public function setCode($value){
        $this->code=$value;
    }
    public function getSubjectType(){
        return $this->subject_type;
    }
    public function setSubjectType($value){
        $this->subject_type=$value;
    }
    public function getSchoolYear(){
        return $this->school_year;
    }
    public function setSchoolYear($value){
        $this->school_year=$value;
    }
    public function getSemester(){
        return $this->semester;
    }
    public function setSemester($value){
        $this->semester=$value;
    }

    public function getDepartment(){
        return $this->belongsTo('App\Department','department_id','id');
    }
    public function setDepartment($value){
        $this->department_id=$value;
    }
    public function getDegree(){
        return $this->belongsTo('App\Degree','degree_id','id');
    }
    public function setDegree($value){
        $this->degree_id=$value;
    }
    public function getSubjectInstances(){
        return $this->hasMany('App\SubjectInstance','subject_id','id');
    }
    public function getCoordinator(){
        return $this->belongsTo('App\User','coordinator_id','id');
    }
    public function setCoordinator($value){
        return $this->cooridnator_id=$value;
    }
}
