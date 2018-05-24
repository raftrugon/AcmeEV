<?php

namespace App\Repositories;

use App\Minute;
use Illuminate\Support\Facades\Auth;

class MinuteRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
        return new Minute;
    }

    public function getMinutesForStudent() {
        return $minutes = Minute::join('enrollments','minutes.enrollment_id','=','enrollments.id')
            ->join('subject_instances','enrollments.subject_instance_id','=','subject_instances.id')
            ->groupBy('subject_instances.academic_year')
            ->select('minutes.*', 'subject_instances.academic_year')
            ->where('enrollments.user_id',Auth::user()->getId());
    }
}