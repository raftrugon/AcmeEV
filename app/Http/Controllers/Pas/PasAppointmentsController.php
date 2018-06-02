<?php

namespace App\Http\Controllers\Pas;

use App\Repositories\AppointmentCalendarRepo;
use App\Repositories\AppointmentRepo;
use App\SystemConfig;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasAppointmentsController extends Controller
{
    protected $appointmentCalendarRepo;
    protected $appointmentRepo;

    public function __construct(AppointmentCalendarRepo $appointmentCalendarRepo, AppointmentRepo $appointmentRepo)
    {
        $this->appointmentCalendarRepo = $appointmentCalendarRepo;
        $this->appointmentRepo = $appointmentRepo;
    }

    public function getCalendar()
    {
        try {
            $config = SystemConfig::first();
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }
        return view('site.pas.calendar', compact('config'));
    }

    public function getCalendarData(Request $request)
    {
        try {
            $startDate = new Carbon($request->input('start'));
            $endDate = new Carbon($request->input('end'));
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }

        return $this->appointmentCalendarRepo->getAvailableDatesForRange($startDate, $endDate)->get();
    }

    public function postNewCalendarDate(Request $request)
    {
        return $this->appointmentCalendarRepo->create($request->except('_token'));
    }

    public function postDeleteCalendarDate(Request $request)
    {
        return $this->appointmentCalendarRepo->delete($request->input('id'));
    }

    public function getAppointmentsInfo()
    {
        try {
            $minutesToSub = Carbon::now()->minute - (floor(Carbon::now()->minute / 5) * 5);
            $now = Carbon::now()->subMinutes($minutesToSub);
            $appointments = $this->appointmentRepo->getAppointmentsForNow($now);
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }

        return view('site.pas.appointment-info', compact('appointments', 'now'));
    }
}
