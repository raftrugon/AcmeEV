<?php

namespace App\Repositories;

use App\Degree;
use Carbon\Carbon;

class DegreeRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
        return new Degree;
    }

    public function getAllButSelected($ids){
        return Degree::whereNotIn('id',$ids)->orderBy('name','asc');
    }

    public function canCreateSubjectInstances(Degree $degree) {
        return $this->getModel()
            ->join('subjects','degrees.id','=','subjects.degree_id')
            ->join('subject_instances','subjects.id','=','subject_instances.subject_id')
            ->where('degrees.id',$degree->getId())
            ->where('academic_year',Carbon::now()->year+1)->get() == 0;

    }

}