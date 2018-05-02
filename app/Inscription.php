<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    protected $guarded = ['agreed'];

    public function getId(){
        return $this->id;
    }


    public function getRequests(){
        $this->hasMany('App\Request','inscription_id','id');
    }
}
