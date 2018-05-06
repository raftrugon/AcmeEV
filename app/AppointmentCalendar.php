<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentCalendar extends Model
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

    public function getEnd(){
        return $this->end;
    }

    public function setEnd($value){
        $this->end = $value;
    }

    public function getPas(){
        return $this->belongsTo('App\User','pas_id','id');
    }

    public function setPas($value){
        $this->pas_id = $value;
    }
}
