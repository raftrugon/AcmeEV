<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ControlCheckInstance extends Model
{
    protected $guarded = [];

    public function getId() {
        return $this->id;
    }

    public function getCalification() {
        return $this->calification;
    }

    public function setCalification($value) {
        $this->calification=$value;
    }

    public function getControlCheck() {
        return $this->belongsTo('App\ControlCheck','control_check_id','id');
    }

    public function setControlCheck($value) {
        $this->control_check_id=$value;
    }

    public function getStudent() {
        return $this->belongsTo('App\Student','student_id','id');
    }

    public function setStudent($value) {
        $this->student_id=$value;
    }

    public function getURL() {
        return $this->url;
    }

    public function setURL($value) {
        $this->url=$value;
    }
}
