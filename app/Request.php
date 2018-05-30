<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{

    use SoftDeletes;

    protected $guarded = ['accepted'];
    protected $dates = ['deleted_at'];

    public function getId(){
        return $this->id;
    }

    public function getPriority(){
        return $this->priority;
    }

    public function setPriority($value){
        $this->priority = $value;
    }

    public function getAccepted(){
        return $this->accepted;
    }

    public function setAccepted($value){
        $this->accepted = $value;
    }

    public function getInscription(){
        return $this->belongsTo('App\Inscription','inscription_id','id');
    }

    public function setInscription($value){
        $this->inscription_id = $value;
    }

    public function getDegree(){
        return $this->belongsTo('App\Degree','degree_id','id');
    }

    public function setDegree($value){
        $this->degree_id = $value;
    }

}
