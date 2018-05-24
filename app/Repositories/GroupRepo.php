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

}