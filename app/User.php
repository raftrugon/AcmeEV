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

    public function getFullName(){
        return $this->getName() . ' ' . $this->getSurname();
    }

    public function getDepartment() {
        return $this->belongsTo('App\Department','department_id','id');
    }

    public function setDepartment($value) {
        $this->department_id=$value;
    }
}
