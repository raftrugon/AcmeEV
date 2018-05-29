<?php

namespace App\Repositories;

use App\Enrollment;
use App\Exchange;
use Illuminate\Support\Facades\Auth;

class ExchangeRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
        return new Exchange;
    }

}