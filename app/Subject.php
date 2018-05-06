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
    public function getCode(){
        return $this->code;
    }
    public function getSubjectType(){
        return $this->subjectType;
    }
    public function getSchoolYear(){
        return $this->schoolYear;
    }
    public function getSemester(){
        return $this->semester;
    }

    public function getDepartment(){
        return $this->belongsTo('App\Department','department_id','id');
    }
    public function getDegree(){
        return $this->belongsTo('App\Degree','degree_id','id');
    }
    public function getSubjectInstances(){
        return $this->hasMany('App\SubjectInstance','subject_id','id');
    }
    public function getCoordinator(){
        return $this->belongsTo('App\User','coordinator_id','id');
    }
}
