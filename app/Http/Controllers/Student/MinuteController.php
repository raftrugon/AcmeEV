<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Minute;
use App\Repositories\MinuteRepo;
use Illuminate\Support\Facades\Auth;

class MinuteController extends Controller
{

    protected $minuteRepo;

    public function __construct(MinuteRepo $minuteRepo)
    {
        $this->minuteRepo = $minuteRepo;
    }

    public function getMinutesForStudent() {
        $academic_years = $this->minuteRepo->getMinutesForStudent()->orderBy('academic_year', 'DESC')->get()->groupBy('academic_year');
        return view('site.student.minute.my-minutes',compact('academic_years'));
    }
}