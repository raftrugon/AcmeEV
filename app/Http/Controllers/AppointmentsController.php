<?php

namespace App\Http\Controllers;

use App\Repositories\AppointmentRepo;
use App\SystemConfig;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentsController extends Controller
{
    protected $appointmentRepo;

    public function __construct(AppointmentRepo $appointmentRepo){
        $this->appointmentRepo = $appointmentRepo;
    }

    public function getCalendar(){
        $config = SystemConfig::first();
        return view('site.calendar',compact('config'));
    }

    public function getCalendarData(Request $request){
        $startDate = new Carbon($request->input('start'));
        $endDate = new Carbon($request->input('end'));
        return $this->appointmentRepo->getAvailableDatesForRange($startDate,$endDate);
    }

    public function postUpdateAppointment(Request $request){
        $appointment = Auth::check() ? $this->appointmentRepo->getModel()->where('start',$request->input('start'))->where('student_id',Auth::id())->first() : null;
        if($appointment){
            try {
                $this->appointmentRepo->delete($appointment->getId());
                return 'true';
            }catch(\Exception $e){
                return 'false';
            }catch(\Throwable $t){
                return 'false';
            }
        } else {
            $is_available = $this->appointmentRepo->checkAvailability($request->input('start'));
            $has_day_appointment = $this->appointmentRepo->hasDayAppointment($request->except('_token'));
            if ($is_available && !$has_day_appointment) {
                try {
                    if (Auth::check()) $request->merge(['student_id' => Auth::user()->getId()]);
                    $this->appointmentRepo->create($request->except('_token'));
                    return 'true';
                }catch(\Exception $e){
                    return 'false';
                }catch(\Throwable $t){
                    return 'false';
                }
            } elseif($has_day_appointment) {
                return __('calendar.appointment.max-per-day');
            } else {
                return __('calendar.appointment.no-availability');
            }
        }
    }

    public function postCancelAppointment(){

    }
}
