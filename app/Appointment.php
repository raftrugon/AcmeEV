<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $guarded = [];

    public function getId(){
        return $this->id;
    }

    public function getStart(){
        return $this->start;
    }

    public function setStart($value){
        $this->start = $value;
    }

    public function getIdNumber(){
        return $this->id_number;
    }

    public function setIdNumber($value){
        $this->id_number = $value;
    }

    public function getStudent(){
        return $this->belongsTo('App\User','student_id','id');
    }

    public function setStudent($value){
        $this->student_id = $value;
    }
}
