<?php

namespace App\Repositories;

use App\AppointmentCalendar;
use Illuminate\Support\Facades\Auth;

class AppointmentCalendarRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
        return new AppointmentCalendar();
    }

    public function getAvailableDatesForRange($startDate,$endDate){
        return $this->getModel()
            ->where('start','>',$startDate)
            ->where('end','<',$endDate)
            ->where('pas_id',Auth::user()->getId());
    }

}