<?php

namespace App\Repositories;

use App\Request;

class RequestRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
        return new Request();
    }
}