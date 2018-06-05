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
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{

    protected $groupRepo;
    protected $periodTimeRepo;

    public function __construct(GroupRepo $groupRepo, PeriodTimeRepo $periodTimeRepo)
    {
        $this->groupRepo = $groupRepo;
        $this->periodTimeRepo = $periodTimeRepo;
    }

    public function getGroupsForSubjectInstace(SubjectInstance $subjectInstance)
    {
        try {
            $groups = Group
                ::where('subject_instance_id', $subjectInstance->getId())->get();
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }

        return view('site.pdi.group.all-for-subject-instance', compact('groups'));
    }

    public function editGroupLecturers(Group $group)
    {
        try {
            $theory_lecturer = $group->getTheoryLecturer;
            $practice_lecturer = $group->getPracticeLecturer;
            $department_lecturers = User
                ::where('department_id', Auth::user()->getDepartment->getId())->get();
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }
        return view('site.pdi.group.edit', compact('theory_lecturer', 'practice_lecturer', 'department_lecturers', 'group'));
    }

    public function saveGroup(Request $request, Group $group)
    {
        try {
            $group->setTheoryLecturer($request->input('lecturers')[0]);
            $group->setPracticeLecturer($request->input('lecturers')[1]);
            $this->groupRepo->updateWithoutData($group);
        } catch (\Exception $e) {
            return 'false';
        } catch (\Throwable $t) {
            return 'false';
        }
        return 'true';
    }

    public function getSchedulingView()
    {
        $degrees = Degree::all();
        return view('site.pdi.group.timetable.all', compact('degrees'));
    }

    public function getAvailableSubjectsAndRooms(Request $request)
    {
//        try {
            $subject_instances = SubjectInstance::join('subjects', 'subject_instances.subject_id', '=', 'subjects.id')
                ->join('groups', 'subject_instances.id', '=', 'groups.subject_instance_id')
                ->where('subjects.degree_id', $request->input('degree_id'))
                ->where('subjects.school_year', $request->input('school_year'))
                ->where('groups.number', $request->input('group_number'))
                ->where('subject_instances.academic_year', $this->groupRepo->getAcademicYear())
                ->select('subject_instances.id', 'subjects.name')
                ->distinct('subject_instances.id')
                ->get();
            $rooms = Room::select('rooms.id', DB::raw('
                                (CASE 
                                    WHEN rooms.is_laboratory = 1 THEN CONCAT(rooms.module," - ",rooms.floor,".",rooms.number," (LAB)")
                                    ELSE CONCAT(rooms.module," - ",rooms.floor,".",rooms.number)
                                END) as name
                        '))
                ->whereNotExists(function ($query) use ($request) {
                    $query->select(DB::raw(1))
                        ->from('period_times')
                        ->where('day', $request->input('day'))
                        ->where(function ($sub) use ($request) {
                            $sub->where(function ($sub1) use ($request) {
                                $sub1->where('start', '<=', $request->input('start'))
                                    ->where('end', '>', $request->input('start'));
                            })
                                ->orWhere(function ($sub2) use ($request) {
                                    $sub2->where('start', '<', $request->input('end'))
                                        ->where('end', '>=', $request->input('end'));
                                })
                                ->orWhere(function ($sub3) use ($request) {
                                    $sub3->where('start', '>=', $request->input('start'))
                                        ->where('end', '<=', $request->input('end'));
                                });
                        })
                        ->whereRaw('period_times.room_id = rooms.id');
                })
                ->groupBy('rooms.id')
                ->get()->sortBy('name');
//        } catch (\Exception $e) {
//            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
//        } catch (\Throwable $t) {
//            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
//        }

        return compact('subject_instances', 'rooms');
    }

    public function getGroupsForYearAndDegree(Request $request)
    {
        try {
            return Degree::findOrFail($request->input('degree_id'))->getSubjects()
                ->join('subject_instances', 'subjects.id', '=', 'subject_instances.subject_id')
                ->join('groups', 'subject_instances.id', '=', 'groups.subject_instance_id')
                ->where('subjects.school_year', $request->input('year'))
                ->where('subject_instances.academic_year', $this->groupRepo->getAcademicYear())
                ->groupBy('groups.number')
                ->select('groups.number as id', 'groups.number', 'groups.id as real_id')
                ->get();
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }
    }

    public function postNewTimetableTime(Request $request)
    {
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
        } catch (\Exception $e) {
            return 'false';
        } catch (\Throwable $t) {
            return 'false';
        }
    }

    public function getScheduledForDegreeAndYear(Request $request)
    {
        try {
            $start = substr($request->input('start'), 0, 10);
            $monday = Carbon::createFromFormat('Y-m-d', $start);
            $period_times = PeriodTime::join('groups', 'period_times.group_id', '=', 'groups.id')
                ->join('subject_instances', 'groups.subject_instance_id', '=', 'subject_instances.id')
                ->join('subjects', 'subject_instances.subject_id', '=', 'subjects.id')
                ->join('rooms', 'period_times.room_id', '=', 'rooms.id')
                ->where('subjects.degree_id', $request->input('degree_id'))
                ->where('subjects.school_year', $request->input('school_year'))
                ->where('subject_instances.academic_year', $this->groupRepo->getAcademicYear())
                ->select(
                    'period_times.id as id',
                    'groups.number as resourceId',
                    'period_times.start as start',
                    'period_times.end as end',
                    'period_times.day as day',
                    'rooms.is_laboratory as lab',
                    DB::raw('
                     (CASE 
                            WHEN rooms.is_laboratory = 1 THEN CONCAT(subjects.name," (",rooms.module," - ",rooms.floor,".",rooms.number,") [LAB]")
                            ELSE CONCAT(subjects.name," (",rooms.module," - ",rooms.floor,".",rooms.number,")")
                        END) as title
                ')
                )
                ->get();
            $period_times = $period_times->map(function ($period) use ($monday) {
                $day = $monday->copy()->addDays(intval($period['day']) - 1);
                $period['start'] = $day->copy()->setTimeFromTimeString($period['start'])->format('Y-m-d H:i:s');
                $period['end'] = $day->copy()->setTimeFromTimeString($period['end'])->format('Y-m-d H:i:s');
                if ($period['lab'] == 1) $period['color'] = '#ffc107';
                return $period;
            });
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }

        return $period_times;
    }
}