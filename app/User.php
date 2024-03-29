<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        ''
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($value){
        $this->name = $value;
    }

    public function getSurName(){
        return $this->surname;
    }

    public function setSurName($value){
        $this->surname = $value;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($value) {
        $this->email = $value;
    }

    public function getPersonalEmail() {
        return $this->personal_email;
    }

    public function setPersonalEmail($value) {
        $this->personal_email = $value;
    }


    public function getAddress() {
        return $this->address;
    }

    public function setAddress($value) {
        $this->address = $value;
    }


    public function getPhoneNumber() {
        return $this->phone_number;
    }

    public function setPhoneNumber($value) {
        $this->phone_number = $value;
    }

    public function getFullName(){
        return $this->getName() . ' ' . $this->getSurname();
    }

    public function getDepartment() {
        return $this->belongsTo('App\Department','department_id','id');
    }

    public function setDepartment($value) {
        $this->department_id=$value;
    }


    public function getEnrollments(){
        return $this->hasMany('App\Enrollment','user_id','id');
    }

    public function getControlCheckInstances() {
        return $this->hasMany('App\ControlCheckInstance','student_id','id');
    }

    public function getGroups() {
        return $this->belongsToMany('App\Group', 'student_group', 'student_id', 'group_id');
    }

    public function getDegree(){
	return $this->belongsTo('App\Degree','degree_id','id');
    }

    public function setDegree($value){
    $this->degree_id=$value;
    }

    public function getIdNumber() {
        return $this->id_number;
    }

    public function setIdNumber($value){
        $this->id_number = $value;
    }

    public function getSubjectInstances() {
        return $this->belongsToMany('App\SubjectInstance', 'enrollments', 'user_id', 'subject_instance_id')->using('App\Enrollment');
    }


}
