<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Minute extends Model
{
    protected $guarded = [];

    public function getId()
    {
        return $this->id;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($value) {
        $this->status=$value;
    }

    public function getQualification() {
        return $this->qualification;
    }

    public function setQualification($value) {
        $this->qualification=$value;
    }

    public function getSummon() {
        return $this->summon;
    }

    public function setSummon($value) {
        $this->summon=$value;
    }

    public function getEnrollment() {
        return $this->belongsTo('App\Enrollment','enrollment_id','id');
    }

    public function setEnrollment($value) {
        $this->enrollment_id=$value;
    }
}