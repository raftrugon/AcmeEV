<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemConfig extends Model
{

    protected $guarded = [];


    public function getId(){
        return $this->id;
    }

    //

    public function getMaxSummonsNumber(){
        return $this->max_summons_number;
    }

    public function setMaxSummonsNumber($value){
        $this->max_summons_number = $value;
    }


    public function getMaxAnnualSummonsNumber(){
        return $this->max_annual_summons_number;
    }

    public function setMaxAnnualSummonsNumber($value){
        $this->max_annual_summons_number = $value;
    }


    public function getSecretariatOpenTime(){
        return $this->secretariat_open_time;
    }

    public function setSecretariatOpenTime($value){
        $this->secretariat_open_time = $value;
    }


    public function getSecretariatCloseTime(){
        return $this->secretariat_close_time;
    }

    public function setSecretariatCloseTime($value){
        $this->secretariat_close_time = $value;
    }


    public function getActualState(){
        return $this->actual_state;
    }

    public function setActualState($value){
        $this->actual_state = $value;
    }


    public function getInscriptionsListStatus(){
        return $this->inscriptions_list_status;
    }

    public function setInscriptionsListStatus($value){
        $this->inscriptions_list_status = $value;
    }






}
