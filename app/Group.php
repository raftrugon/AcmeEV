<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];

    public function getId() {
        return $this->id;
    }

    public function getNumber() {
        return $this->number;
    }

    public function setNumber($value) {
        $this->number=$value;
    }

    public function getSubjectInstance() {
        return $this->belongsTo('App\SubjectInstance','subject_instance_id','id');
    }

    public function setSubjectInstance($value) {
        $this->subject_instance_id=$value;
    }

    public function getTheoryLecturer() {
        return $this->belongsTo('App\User','theory_lecturer_id','id');
    }

    public function setTheoryLecturer($value) {
        $this->theory_lecturer_id=$value;
    }

    public function getPracticeLecturer() {
        return $this->belongsTo('App\User','practice_lecturer_id','id');
    }

    public function setPracticeLecturer($value) {
        $this->practice_lecturer_id=$value;
    }

    public function getStudents() {
        return $this->belongsToMany('App\User', 'student_group', 'group_id', 'student_id');
    }

    public function getFolders() {
        return $this->hasMany('App\Folder','group_id','id');
    }

    public function getExchangeFrom() {
        return $this->hasMany('App\Exchange','group_from_id','id');
    }

    public function getExchangeTo() {
        return $this->hasMany('App\Exchange','group_to_id','id');
    }

    public function getPeriodTimes() {
        return $this->hasMany('App\PeriodTime', 'group_id', 'id');
    }
}
