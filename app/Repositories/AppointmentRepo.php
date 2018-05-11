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
        $startDate = $startDate->max(Carbon::now()->subDay());
        $availablePeriods = $this->appointmentCalendarRepo->getModel()
            ->where('start','>',$startDate)
            ->where('end','<',$endDate)->get();

        $availableAppointments = array();

        foreach($availablePeriods as $availablePeriod){
            $startTime = Carbon::createFromFormat('Y-m-d H:i:s',$availablePeriod->getStart());
            $endTime = Carbon::createFromFormat('Y-m-d H:i:s',$availablePeriod->getEnd());
            while($startTime < $endTime){
                $isAvailable = $this->checkAvailability($startTime);
                $min = $startTime->minute;
                $start = $startTime->copy()->subMinutes($min);
                $end = $startTime->copy()->addMinutes(60-$min);
                $availableAppointments[] = ['start'=>$start->format('Y-m-d H:i:s'),'end'=>$end->format('Y-m-d H:i:s'),
                    'is_available'=>$isAvailable,'real_start'=>$startTime->format('Y-m-d H:i:s'),
                    'tooltip'=>$startTime->format('H:i'),
                    'mine'=>Auth::check() ? in_array(Auth::id(),$this->getModel()->where('start',$startTime)->get()->pluck('student_id')->toArray()) : false];
                $startTime->addMinutes(5);
            }
        }

        return array_unique($availableAppointments,SORT_REGULAR);
    }

    public function checkAvailability($start){
        $availablePas = $this->appointmentCalendarRepo->getAvailablePasForStartTime($start)->count();
        return $this->getModel()
                ->where('start',$start)
                ->count() < $availablePas;
    }

    public function hasDayAppointment($array){
        $query = $this->getModel()->where('start','like',Carbon::createFromFormat('Y-m-d H:i:s',$array['start'])->format('Y-m-d').' %');
        if(Auth::check()) {
           $query->where('student_id', Auth::id());
        }else {
           $query->where('id_number', $array['id_number']);
        }
        return $query->count() > 0;
    }

}