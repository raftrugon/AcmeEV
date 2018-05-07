<?php

namespace App\Http\Controllers\Pas;

use App\Repositories\AppointmentCalendarRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasAppointmentsController extends Controller
{
    protected $appointmentCalendarRepo;

    public function __construct(AppointmentCalendarRepo $appointmentCalendarRepo){
        $this->appointmentCalendarRepo = $appointmentCalendarRepo;
    }

    public function getCalendar(){
        return view('site.pas.calendar');
    }

    public function getCalendarData(Request $request){
        $startDate = new Carbon($request->input('start'));
        $endDate = new Carbon($request->input('end'));
        return $this->appointmentCalendarRepo->getAvailableDatesForRange($startDate,$endDate)->get();
    }

    public function postNewCalendarDate(Request $request){
        return $this->appointmentCalendarRepo->create($request->except('_token'));
    }

    public function postDeleteCalendarDate(Request $request){
        return $this->appointmentCalendarRepo->delete($request->input('id'));
    }
}
