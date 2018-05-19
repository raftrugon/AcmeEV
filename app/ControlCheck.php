<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ControlCheck extends Model
{
    protected $guarded = [];

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($value)
    {
        $this->name = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->description = $value;
    }

    public function getRoom()
    {
        return $this->belongsTo('App\Room','room_id','id');
    }

    public function setRoom($value)
    {
        $this->room_id = $value;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($value)
    {
        $this->date = $value;
    }

    public function getIsSubmittable()
    {
        return $this->is_submittable;
    }

    public function setIsSubmittable($value)
    {
        $this->is_submittable=$value;
    }

    public function getWeight() {
        return $this->weight();
    }

    public function setWeight($value) {
        $this->weight=$value;
    }

    public function getMinimumMark() {
        return $this->minimum_mark;
    }

    public function setMainimumMark($value) {
        $this->minimum_mark=$value;
    }

    public function getControlCheckInstances() {
        return $this->hasMany('App\ControlCheckInstance','control_check_id','id');
    }

    public function getSubjectInstance() {
        return $this->belongsTo('App\SoubjectInstance','subject_instance_id','id');
    }

    public function setSubjectIntance($value) {
        $this->subject_instance_id = $value;
    }

}