<?php

namespace App\Http\Controllers\Pas;

use App\Http\Controllers\Controller;
use App\Minute;
use App\Repositories\MinuteRepo;
use App\User;
use Illuminate\Http\Request;

class MinuteController extends Controller
{

    protected $minuteRepo;

    public function __construct(MinuteRepo $minuteRepo)
    {
        $this->minuteRepo = $minuteRepo;
    }

    public function getMinutesForStudent(User $user) {
        $academic_years = $this->minuteRepo->getMinutesForStudent($user)->get()->groupBy('academic_year');
        return view('site.pas.student-minutes',compact('academic_years'));
    }

    public function updateMinutes(Request $request) {
        $ids = $request->input('ids');
        $qualifications = $request->input('qualifications');
        for($i = 0; $i < count($ids); $i++) {
           $minute = Minute::where('id',$ids[$i])->first();
           $minute->setQualification($qualifications[$i]);
           $this->minuteRepo->updateWithoutData($minute);
        }
        return 'true';
    }
}