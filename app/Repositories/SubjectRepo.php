<?php

namespace App\Repositories;

use App\Subject;

class SubjectRepo extends BaseRepo {

    public function __construct()
    {

    }

    public function getModel() {
        return new Subject;
    }

}