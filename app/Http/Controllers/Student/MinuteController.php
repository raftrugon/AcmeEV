<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\MinuteRepo;

class MinuteController extends Controller
{

    protected $minuteRepo;

    public function __construct(MinuteRepo $minuteRepo)
    {
        $this->minuteRepo = $minuteRepo;
    }

    public function getMinutesForStudent() {
        try{
            $academic_years = $this->minuteRepo->getMinutesForStudent()->get()->groupBy('academic_year');
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }

        return view('site.student.minute.my-minutes',compact('academic_years'));
    }
}