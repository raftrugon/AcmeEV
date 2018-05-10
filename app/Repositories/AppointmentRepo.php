<?php

namespace App\Repositories;

use App\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AppointmentRepo extends BaseRepo
{

    protected $appointmentCalendarRepo;

    public function __construct(AppointmentCalendarRepo $appointmentCalendarRepo)
    {
        $this->appointmentCalendarRepo = $appointmentCalendarRepo;
    }

    public function getModel()
    {
        return new Appointment();
    }

    public function getAvailableDatesForRange($startDate,$endDate){
        $availablePeriods = $this->appointmentCalendarRepo->getModel()
            ->where('start','>',$startDate)
            ->where('end','<',$endDate)->get();

        $availableAppointments = array();

        foreach($availablePeriods as $availablePeriod){
            $startTime = Carbon::createFromFormat('Y-m-d H:i:s',$availablePeriod->getStart());
            $endTime = Carbon::createFromFormat('Y-m-d H:i:s',$availablePeriod->getEnd());
            while($startTime < $endTime){
                $availablePas = $this->appointmentCalendarRepo->getAvailablePasForStartTime($startTime)->count();
                $isAvailable = $this->getModel()
                    ->where('start',$startTime)
                    ->count() < $availablePas;
                $min = $startTime->minute;
//                $start = $min < 30 ? $startTime->copy()->subMinutes($min) : $startTime->copy()->subMinutes($min - 30);
//                $end = $min < 30 ? $startTime->copy()->addMinutes(30-$min) : $startTime->copy()->addMinutes(60-$min);
                $start = $startTime->copy()->subMinutes($min);
                $end = $startTime->copy()->addMinutes(60-$min);
                $availableAppointments[] = ['start'=>$start->format('Y-m-d H:i:s'),'end'=>$end->format('Y-m-d H:i:s'),'is_available'=>$isAvailable];
                $startTime->addMinutes(5);
            }
        }

        return $availableAppointments;
    }

}