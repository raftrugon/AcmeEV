<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
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

    public function getCode(){
        return $this->code;
    }

    public function setCode($value){
        $this->code = $value;
    }

    public function getNewStudentsLimit(){
        return $this->new_students_limit;
    }

    public function setNewStudentsLimit($value){
        $this->new_students_limit = $value;
    }

        public function getSubjects(){
            return $this->hasMany('App\Subject','degree_id','id');
    }

    public function isDeleted() {
        return $this->deleted;
    }

    public function delete() {
        $this->deleted = true;
    }

    public function canCreateSubjectInstances() {
        return Degree
                ::join('subjects','degrees.id','=','subjects.degree_id')
                ->join('subject_instances','subjects.id','=','subject_instances.subject_id')
                ->where('degrees.id',$this->getId())
                ->where('academic_year',Carbon::now()->year+1)->count() == 0;
    }
}
