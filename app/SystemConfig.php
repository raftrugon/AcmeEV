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


    public function getInscriptionsStartDate(){
        return $this->inscriptions_start_date;
    }

    public function setInscriptionsStartDate($value){
        $this->inscriptions_start_date = $value;
    }


    public function getFirstProvisionalInscrListDate(){
        return $this->first_provisional_inscr_list_date;
    }

    public function setFirstProvisionalInscrListDate($value){
        $this->first_provisional_inscr_list_date = $value;
    }


    public function getSecondProvisionalInscrListDate(){
        return $this->second_provisional_inscr_list_date;
    }

    public function setSecondProvisionalInscrListDate($value){
        $this->second_provisional_inscr_list_date = $value;
    }


    public function getFinalInscrListDate(){
        return $this->final_inscr_list_date;
    }

    public function setFinalInscrListDate($value){
        $this->final_inscr_list_date = $value;
    }


    public function getEnrolmentStartDate(){
        return $this->enrolment_start_date;
    }

    public function setEnrolmentStartDate($value){
        $this->enrolment_start_date = $value;
    }


    public function getEnrolmentEndDate(){
        return $this->enrolment_end_date;
    }

    public function setEnrolmentEndDate($value){
        $this->enrolment_end_date = $value;
    }


    public function getProvisionalMinutesDate(){
        return $this->provisional_minutes_date;
    }

    public function setProvisionalMinutesDate($value){
        $this->provisional_minutes_date = $value;
    }


    public function getFinalMinutesDate(){
        return $this->final_minutes_date;
    }

    public function setFinalMinutesDate($value){
        $this->final_minutes_date = $value;
    }


    public function getAcademicYearEndDate(){
        return $this->academic_year_end_date;
    }

    public function setAcademicYearEndDate($value){
        $this->academic_year_end_date = $value;
    }

    public function getInscriptionsListStatus(){
        return $this->inscriptions_list_status;
    }

    public function setInscriptionsListStatus($value){
        $this->inscriptions_list_status = $value;
    }


}
