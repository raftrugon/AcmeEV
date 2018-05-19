<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = [];

    public function getId()
    {
        return $this->id;
    }

    public function getNumber() {
        return $this->number;
    }

    public function setNumber($value) {
        $this->number=$value;
    }

    public function getFloor() {
        return $this->floor;
    }

    public function setFloor($value) {
        $this->floor=$value;
    }

    public function getModule(){
        return $this->module;
    }

    public function setModule($value) {
        $this->module=$value;
    }

    public function getIsLaboratory() {
        return $this->is_laboratory;
    }

    public function setIsLaboratory($value) {
        $this->is_laboratory=$value;
    }

    public function getCapacity() {
        return $this->capacity;
    }

    public function setCapacity($value) {
        $this->capacity=$value;
    }

    public function getControlChecks() {
        return $this->hasMany('App\ControlCheck','room_id','id');
    }

    public function getPeriodTimes() {
        return $this->hasMany('App\PeriodTime','room_id','id');
    }

}
