<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\EnrollmentRepo;

class EnrollmentController extends Controller
{

    protected $enrollmentRepo;

    public function __construct(EnrollmentRepo $enrollmentRepo){
        $this->enrollmentRepo = $enrollmentRepo;
    }


    public function getMyEnrollments(){
        $academic_years = $this->enrollmentRepo->getMyEnrollments()->get()->groupBy('academic_year');
        return view('site.student.enrollment.my-enrollments', compact('academic_years'));
    }
}
