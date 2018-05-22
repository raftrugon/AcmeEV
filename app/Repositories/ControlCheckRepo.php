<?php

namespace App\Repositories;

use App\ControlCheck;

class ControlCheckRepo extends BaseRepo
{
    public function __construct()
    {
    }

    public function getModel()
    {
        return new ControlCheck();
    }
}
