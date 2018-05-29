<?php

namespace App\Repositories;

use App\PeriodTime;

class PeriodTimeRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
        return new PeriodTime;
    }
}