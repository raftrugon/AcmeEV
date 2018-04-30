<?php

namespace App\Repositories;

use App\Inscription;

class InscriptionRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
       return new Inscription;
    }
}