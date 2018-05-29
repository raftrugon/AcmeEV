<?php

namespace App\Repositories;

use App\Group;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GroupRepo extends BaseRepo {

    public function __construct()
    {

    }

    public function getModel() {
        return new Group;
    }

    public function getMyGroupsForThisYear(){
        return Auth::user()->getGroups()
            ->join('subject_instances','groups.subject_instance_id','=','subject_instances.id')
            ->where('academic_year',$this->getAcademicYear())
            ->select('groups.*');
    }

    public function getMySchedule($start){
        $start = substr($start,0,10);
        $monday = Carbon::createFromFormat('Y-m-d',$start);
        $groups = $this->getMyGroupsForThisYear()->get();
        return $groups->map(function($group) use($monday) {
            $subject = $group->getSubjectInstance->getSubject;
            $periods = $group->getPeriodTimes->map(function($period) use ($monday,$subject,$group){
                $day = $monday->copy()->addDays(intval($period['day']) - 1);
                $period['start'] = $day->copy()->setTimeFromTimeString($period['start'])->format('Y-m-d H:i:s');
                $period['end'] = $day->copy()->setTimeFromTimeString($period['end'])->format('Y-m-d H:i:s');
                $room = $period->getRoom;
                $period['room'] = $room->getModule() . "-" . $room->getFloor() . "." . $room->getNumber();
                if($room->getIsLaboratory()){
                    $period['room'] .= " (LAB)";
                    $period['borderColor'] = '#ffc107';
                    $period['textColor'] = '#ffc107';
                    $period['teacher'] = $group->getPracticeLecturer->getFullName();
                }else{
                    $period['teacher'] = $group->getTheoryLecturer->getFullName();
                }
                $period['title'] = $subject->getName() . ' [' . $period['room'] . ']';
                $period['group'] =  __('group.number') . ': ' . $group->getNumber();
                $period['resourceId'] = $subject->getSchoolYear();
                $period['group_id'] = $group->getId();
                return $period;
            });
           return $periods;
        })->flatten();
    }

}