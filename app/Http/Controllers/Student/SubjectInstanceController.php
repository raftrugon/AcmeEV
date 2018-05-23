<?php

namespace App\Http\Controllers\Student;

use App\Repositories\EnrollmentRepo;
use App\Http\Controllers\Controller;

class SubjectInstanceController extends Controller
{

    protected $enrollmentRepo;

    public function __construct(EnrollmentRepo $enrollmentRepo){
        $this->enrollmentRepo = $enrollmentRepo;
    }

    public function getMySubjectInstances(){
        $academic_years = $this->enrollmentRepo->getMyEnrollments()->orderBy('academic_year', 'DESC')->get()->groupBy('academic_year');
        return view('site.student.subjectInstance.my-subjects', compact('academic_years'));
    }
}
