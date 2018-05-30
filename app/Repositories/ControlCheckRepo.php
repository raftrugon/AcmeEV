<?php

namespace App\Repositories;

use App\ControlCheck;
use App\ControlCheckInstance;
use App\Subject;
use App\User;
use Illuminate\Support\Facades\Auth;

class ControlCheckRepo extends BaseRepo
{

    protected $controlCheckInstanceRepo;

    public function __construct(ControlCheckInstanceRepo $controlCheckInstanceRepo)
    {
        $this->controlCheckInstanceRepo=$controlCheckInstanceRepo;
    }

    public function getModel()
    {
        return new ControlCheck();
    }

    public function getControlCheckInstancesForStudent(Subject $subject, User $user=null) {
        $user = isset($user)?$user:Auth::user();
        return $controlCheckInstances = $user->getControlCheckInstances()
            ->join('control_checks','control_check_instances.control_check_id','control_checks.id')
            ->join('subject_instances','control_checks.subject_instance_id','subject_instances.id')
            ->where('subject_instances.subject_id',$subject->getId())
            ->select('control_check_instances.*');
    }

    public function getControlChecksForLecturer(Subject $subject) {
        return $controlChecks = ControlCheck
            ::join('subject_instances','control_checks.subject_instance_id','subject_instances.id')
            ->where('subject_instances.subject_id',$subject->getId())
            ->select('control_checks.*');
    }

    public function deleteControlCheck($id) {
        try{
            $controlCheck = ControlCheck::where('id',$id)->first();
            $this->delete($controlCheck);
            return 'true';
        } catch(\Exception $e) {
            return 'false';
        }
    }

}
