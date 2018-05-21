<?php

namespace App\Repositories;

use App\Degree;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DegreeRepo extends BaseRepo
{

    public function __construct(InscriptionRepo $inscriptionRepo)
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

    public function getDegreesWithAcceptedRequests($degree_ids){
        $result = array();
        foreach($this->getModel()->whereIn('id',$degree_ids)->orderBy('name','desc')->get() as $degree) {
            $result[$degree->getName()] = $this->inscriptionRepo->getAcceptedListForDegree($degree)->get();
        }
        return $result;
    }

}