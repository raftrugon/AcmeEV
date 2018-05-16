<?php

namespace App\Repositories;

use App\Inscription;
use App\SystemConfig;
use App\User;

class UserRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
        return new User;
    }

    public function createBatchFromInscriptions(){
        $inscriptions = Inscription::join('requests','inscription.id','=','requests.inscription_id')
            ->where('requests.accepted',1)
            ->select('inscriptions.*')
            ->groupBy('inscriptions.id')
            ->get();
    }

}