<?php

namespace App\Repositories;

use App\SubjectInstance;

class SubjectInstanceRepo extends BaseRepo {

    public function __construct()
    {

    }

    public function getModel() {
        return new SubjectINstance;
    }

}