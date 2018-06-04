<?php

namespace App\Http\Controllers\Student;

use App\Repositories\GroupRepo;
use App\Repositories\PeriodTimeRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    protected $groupRepo;
    protected $periodTimeRepo;

    public function __construct(GroupRepo $groupRepo,PeriodTimeRepo $periodTimeRepo)
    {
        $this->groupRepo = $groupRepo;
        $this->periodTimeRepo = $periodTimeRepo;
    }

    public function getSchedule(){
        return view('site.student.group.schedule');
    }

    public function getScheduleEvents(Request $request){
        try{
            return $this->groupRepo->getMySchedule($request->input('start'));
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }
    }

    public function getScheduleResources(Request $request){
        return Auth::user()->getGroups()
                ->join('subject_instances','groups.subject_instance_id','=','subject_instances.id')
                ->join('subjects','subject_instances.subject_id','=','subjects.id')
                ->where('subject_instances.academic_year',$this->groupRepo->getAcademicYear())
                ->select('subjects.school_year as id')
                ->get();
    }

//    public function getPrint(){
//        return \PDF::loadVIew('site.student.group.schedule')->download('horarios.pdf');
//    }
}
