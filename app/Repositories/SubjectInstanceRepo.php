<?php

namespace App\Repositories;

use App\SubjectInstance;

class SubjectInstanceRepo extends BaseRepo {

    public function __construct()
    {

    }

    public function getModel() {
        return new SubjectInstance;
    }

    public function getCurrentInstance($subject_id) {
        return SubjectInstance::where('subject_id',$subject_id)
            ->where('academic_year', $this->getAcademicYear())
            ->first();
    }

}