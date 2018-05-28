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
        $academic_years = $this->minuteRepo->getMinutesForStudent()->get()->groupBy('academic_year');
        return view('site.student.minute.my-minutes',compact('academic_years'));
    }
}