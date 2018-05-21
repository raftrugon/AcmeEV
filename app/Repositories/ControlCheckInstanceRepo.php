<?php

namespace App\Repositories;

use App\ControlCheckInstance;

class ControlCheckInstanceRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
        return new ControlCheckInstance();
    }
}