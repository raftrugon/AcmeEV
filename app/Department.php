<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($value) {
        $this->name=$value;
    }

    public function getCode() {
        return $this->code;
    }

    public function setCode($value) {
        $this->code=$value;
    }

    public function getWebsite() {
        return $this->website;
    }

    public function setWebsite($value) {
        $this->website=$value;
    }


    public function getSubjects(){
        $this->hasMany('App\Subject','department_id','id');
    }

    public function getPDIs() {
        $this->hasMany('App\User','department_id','id');
    }
}
