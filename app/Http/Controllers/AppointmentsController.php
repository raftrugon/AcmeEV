<?php

namespace App\Http\Controllers;

use App\Repositories\AppointmentRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentsController extends Controller
{
    protected $appointmentRepo;

    public function __construct(AppointmentRepo $appointmentRepo){
        $this->appointmentRepo = $appointmentRepo;
    }

    public function getCalendar(){
        return view('site.calendar');
    }

    public function getCalendarData(Request $request){
        $startDate = new Carbon($request->input('start'));
        $endDate = new Carbon($request->input('end'));
        return $this->appointmentRepo->getAvailableDatesForRange($startDate,$endDate);
    }

    public function postNewAppointment(){

    }

    public function postCancelAppointment(){

    }
}
