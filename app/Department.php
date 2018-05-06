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

    public function getCode() {
        return $this->code;
    }

    public function getWebsite() {
        return $this->website;
    }


    public function getSubjects(){
        $this->hasMany('App\Subject','department_id','id');
    }

    public function getPDIs() {
        $this->hasMany('App\User','department_id','id');
    }
}
