<?php

namespace App\Http\Controllers\Pdi;

use App\Degree;
use App\Group;
use App\Http\Controllers\Controller;
use App\PeriodTime;
use App\Repositories\GroupRepo;
use App\Repositories\PeriodTimeRepo;
use App\Room;
use App\SubjectInstance;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{

    protected $groupRepo;
    protected $periodTimeRepo;

    public function __construct(GroupRepo $groupRepo,PeriodTimeRepo $periodTimeRepo)
    {
        $this->groupRepo = $groupRepo;
        $this->periodTimeRepo = $periodTimeRepo;
    }

    public function getGroupsForSubjectInstace(SubjectInstance $subjectInstance) {
        $groups = Group
            ::where('subject_instance_id',$subjectInstance->getId())->get();
        return view('site.pdi.group.all-for-subject-instance',compact('groups'));
    }

    public function editGroupLecturers(Group $group) {
        $theory_lecturer = $group->getTheoryLecturer;
        $practice_lecturer = $group->getPracticeLecturer;
        $department_lecturers = User
            ::where('department_id',Auth::user()->getDepartment->getId())->get();
        return view('site.pdi.group.edit',compact('theory_lecturer','practice_lecturer','department_lecturers','group'));
    }

    public function saveGroup(Request $request) {
        $group = Group::where('id',$request->input('group'))->first();
        $group->setTheoryLecturer($request->input('lecturers')[0]);
        $group->setPracticeLecturer($request->input('lecturers')[1]);
        $this->groupRepo->updateWithoutData($group);
        return 'true';
    }

    public function getSchedulingView(){
        $degrees = Degree::all();
        return view('site.pdi.group.timetable.all',compact('degrees'));
    }

    public function getAvailableSubjectsAndRooms(Request $request){
        $subject_instances = SubjectInstance::join('subjects','subject_instances.subject_id','=','subjects.id')
                                    ->join('groups','subject_instances.id','=','groups.subject_instance_id')
                                    ->where('subjects.degree_id',$request->input('degree_id'))
                                    ->where('subjects.school_year',$request->input('school_year'))
                                    ->where('groups.number',$request->input('group_number'))
                                    ->where('subject_instances.academic_year',$this->groupRepo->getAcademicYear())
                                    ->select('subject_instances.id','subjects.name')
                                    ->distinct('subject_instances.id')
                                    ->get();
        $rooms = Room::leftJoin('period_times','rooms.id','=','period_times.room_id')
                    ->havingRaw('(day <> "'.$request->input('day').'" or start > "'.$request->input('start').'" or end < "'.$request->input('end').'" or period_time_id is null)')
                    ->select('rooms.id','period_times.day','period_times.start','period_times.end','period_times.id as period_time_id',
                        DB::raw('
                                (CASE 
                                    WHEN rooms.is_laboratory = 1 THEN CONCAT(rooms.module," - ",rooms.floor,".",rooms.number," (LAB)")
                                    ELSE CONCAT(rooms.module," - ",rooms.floor,".",rooms.number)
                                END) as name
                        ')
                    )
                    ->orderBy('name','ASC')
                    ->groupBy('rooms.id')
                    ->get();
        return compact('subject_instances','rooms');
    }

    public function getGroupsForYearAndDegree(Request $request){
       return Degree::findOrFail($request->input('degree_id'))->getSubjects()
                        ->join('subject_instances','subjects.id','=','subject_instances.subject_id')
                        ->join('groups','subject_instances.id','=','groups.subject_instance_id')
                        ->where('subjects.school_year',$request->input('year'))
                        ->where('subject_instances.academic_year',$this->groupRepo->getAcademicYear())
                        ->groupBy('groups.number')
                        ->select('groups.number as id','groups.number')
                        ->get();
    }

    public function postNewTimetableTime(Request $request){
        try {
            $group_id = Group::where('subject_instance_id', $request->input('subject_instance_id'))
                ->where('number', $request->input('group_number'))
                ->first()->getId();
            $this->periodTimeRepo->create([
                'group_id' => $group_id,
                'room_id' => $request->input('room_id'),
                'start' => $request->input('start'),
                'end' => $request->input('end'),
                'day' => $request->input('day'),
            ]);
            return 'true';
        }catch(\Exception $e){
            throw $e;
            return 'false';
        }
    }

    public function getScheduledForDegreeAndYear(Request $request){
        $start = substr($request->input('start'),0,10);
        $monday = Carbon::createFromFormat('Y-m-d',$start);
        $period_times = PeriodTime::join('groups','period_times.group_id','=','groups.id')
            ->join('subject_instances','groups.subject_instance_id','=','subject_instances.id')
            ->join('subjects','subject_instances.subject_id','=','subjects.id')
            ->join('rooms','period_times.room_id','=','rooms.id')
            ->where('subjects.degree_id',$request->input('degree_id'))
            ->where('subjects.school_year',$request->input('school_year'))
            ->where('subject_instances.academic_year',$this->groupRepo->getAcademicYear())
            ->select(
                'period_times.id as id',
                'groups.number as resourceId',
                'period_times.start as start',
                'period_times.end as end',
                'period_times.day as day',
                DB::raw('
                     (CASE 
                            WHEN rooms.is_laboratory = 1 THEN CONCAT(subjects.name," (",rooms.module," - ",rooms.floor,".",rooms.number,") [LAB]")
                            ELSE CONCAT(subjects.name," (",rooms.module," - ",rooms.floor,".",rooms.number,")")
                        END) as title
                ')
            )
            ->get();
        $period_times = $period_times->map(function($period) use ($monday){
           $day = $monday->copy()->addDays(intval($period['day']) - 1);
           $period['start'] = $day->copy()->setTimeFromTimeString($period['start'])->format('Y-m-d H:i:s');
           $period['end'] = $day->copy()->setTimeFromTimeString($period['end'])->format('Y-m-d H:i:s');
           return $period;
        });

        return $period_times;
    }
}