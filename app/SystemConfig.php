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


    public function getBuildingOpenTime(){
        return $this->building_open_time;
    }

    public function setBuildingOpenTime($value){
        $this->building_open_time = $value;
    }


    public function getBuildingCloseTime(){
        return $this->building_close_time;
    }

    public function setBuildingCloseTime($value){
        $this->building_close_time = $value;
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

    public function getNameEn(){
        return $this->name_en;
    }

    public function setNameEn($value){
        $this->name_en = $value;
    }

    public function getNameEs(){
        return $this->name_es;
    }

    public function setNameEs($value){
        $this->name_es = $value;
    }

    public function getIcon(){
        return $this->icon;
    }

    public function setIcon($value){
        $this->icon = $value;
    }

    public function getBanner(){
        return $this->banner;
    }

    public function setBanner($value){
        $this->banner = $value;
    }








}
