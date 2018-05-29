<?php

namespace App\Repositories;

use App\Inscription;
use App\SystemConfig;
use App\User;

class UserRepo extends BaseRepo
{
    protected $subjectRepo;

    public function __construct(SubjectRepo $subjectRepo)
    {
        $this->subjectRepo=$subjectRepo;
    }

    public function getModel()
    {
        return new User;
    }

    public function isUserFinished()
    {
        return $this->subjectRepo->getMyNonPassedSubjects() == 0;
    }

    public function createBatchFromInscriptions(){
        $inscriptions = Inscription::join('requests','inscription.id','=','requests.inscription_id')
            ->where('requests.accepted',1)
            ->select('inscriptions.*')
            ->groupBy('inscriptions.id')
            ->get();
    }

}