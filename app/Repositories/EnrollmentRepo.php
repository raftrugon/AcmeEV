<?php

namespace App\Repositories;

use App\Enrollment;
use Illuminate\Support\Facades\Auth;

class EnrollmentRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
        return new Enrollment;
    }

    public function getMyEnrollments(){
        return Enrollment::join('subject_instances', 'enrollments.subject_instance_id', '=', 'subject_instances.id')->select('enrollments.*', 'subject_instances.academic_year')->where('user_id', Auth::id());
    }

    public function getMyActualEnrollments(){
        return Enrollment::join('subject_instances', 'enrollments.subject_instance_id', '=', 'subject_instances.id')->where('subject_instances.academic_year', $this->getAcademicYear())->select('enrollments.*')->where('user_id', Auth::id());
    }

}