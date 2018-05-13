<?php

namespace App\Repositories;

use App\Inscription;
use App\Request;

class InscriptionRepo extends BaseRepo
{

    protected $requestRepo;

    public function __construct(RequestRepo $requestRepo)
    {
        $this->requestRepo = $requestRepo;
    }

    public function getModel()
    {
       return new Inscription;
    }

    public function getAcceptedListForDegree($degree){
        return $this->getModel()
            ->join('requests', 'inscriptions.id', '=', 'requests.inscription_id')
            ->where('requests.degree_id',$degree->getId())
            ->where('requests.accepted', true)
            ->orderBy('inscriptions.grade', 'desc');
    }



    public function firstInscriptionBatch(){
        $inscriptions = Inscription::orderBy('grade','desc')->get();
        foreach($inscriptions as $inscription){
            $hasBeenAccepted = 0;
            foreach($inscription->getRequests()->orderBy('priority','asc')->get() as $request){
                 $numAppliedToDegree = Request::where('degree_id',$request->getDegree->getId())->where('accepted',1)->count();
                 if($request->getDegree->getNewStudentsLimit() > $numAppliedToDegree){
                     $request->setAccepted(1);
                     $this->requestRepo->updateWithoutData($request);
                     $hasBeenAccepted = 1;
                     break;
                 }
            }
            if($hasBeenAccepted == 0) $inscription->setAgreed(0);
            $this->updateWithoutData($inscription);
        }
    }
}