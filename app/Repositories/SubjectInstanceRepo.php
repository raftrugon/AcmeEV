<?php

namespace App\Repositories;

use App\ControlCheck;
use App\SubjectInstance;
use Illuminate\Support\Facades\Auth;

class SubjectInstanceRepo extends BaseRepo {



    public function getModel() {
        return new SubjectInstance;
    }


    public function isUserTeacherNOFUNCIONAL($subject_instance)
    {
        $res = false;
        $user = Auth::user();
        $groups = $subject_instance->getGroups()->get();

        foreach ($groups as $group) {
            if ($group->getTheoryLecturer->getId() == $user->getId()) {
                $res = true;
                break;
            } elseif ($group->getPracticeLecturer->getId() == $user->getId()) {
                $res = true;
                break;
            }
        }

        return $res;
    }

    public function getCurrentInstance($subject_id) {
        return SubjectInstance::where('subject_id',$subject_id)
            ->where('academic_year', $this->getAcademicYear())
            ->first();
    }

    public function canAddControlChecks($subjectInstanceId){
        return ControlCheck::where('subject_instance_id',$subjectInstanceId)
                ->sum('weight')<1 ? 1:0;
    }
}