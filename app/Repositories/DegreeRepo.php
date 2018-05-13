<?php

namespace App\Repositories;

use App\Degree;
use Illuminate\Support\Facades\DB;

class DegreeRepo extends BaseRepo
{
    protected $inscriptionRepo;

    public function __construct(InscriptionRepo $inscriptionRepo)
    {
        $this->inscriptionRepo = $inscriptionRepo;
    }

    public function getModel()
    {
        return new Degree;
    }

    public function getAllButSelected($ids){
        return Degree::whereNotIn('id',$ids)->orderBy('name','asc');
    }

    public function addNextYearSubjects() {

    }

    public function getDegreesWithAcceptedRequests($degree_ids){
        $result = array();
        foreach($this->getModel()->whereIn('id',$degree_ids)->orderBy('name','desc')->get() as $degree) {
            $result[$degree->getName()] = $this->inscriptionRepo->getAcceptedListForDegree($degree)->get();
        }
        return $result;
    }

}