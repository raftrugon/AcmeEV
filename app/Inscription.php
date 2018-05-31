<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inscription extends Model
{

    use SoftDeletes;

    protected $guarded = ['agreed'];
    protected $dates = ['deleted_at'];

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($value){
        $this->name = $value;
    }

    public function getSurname(){
        return $this->surname;
    }

    public function setSurname($value){
        $this->surname = $value;
    }

    public function getFullName(){
        return $this->name . ' ' . $this->surname;
    }

    public function getIdNumber(){
        return $this->id_number;
    }

    public function setIdNumber($value){
        $this->id_number = $value;
    }

    public function getAddress(){
        return $this->address;
    }

    public function setAddress($value){
        $this->address = $value;
    }

    public function getPhoneNumber(){
        return $this->phone_number;
    }

    public function setPhoneNumber($value){
        $this->phone_number = $value;
    }

    public function getGrade(){
        return $this->grade;
    }

    public function setGrade($value){
        $this->grade = $value;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($value){
        $this->password = $value;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($value){
        $this->email = $value;
    }

    public function getAgreed(){
        return $this->agreed;
    }

    public function setAgreed($value){
        $this->agreed = $value;
    }


    public function getRequests(){
        return $this->hasMany('App\Request','inscription_id','id');
    }
}
