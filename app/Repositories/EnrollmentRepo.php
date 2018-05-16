<?php

namespace App\Repositories;

use App\Enrollment;

class EnrollmentRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
        return new Enrollment;
    }

    /*public function getAnnouncementsBySubjectInstanceId($subject_instance_id){
        return Enrollment::where('subject_instance_id', $subject_instance_id);
    }*/

}