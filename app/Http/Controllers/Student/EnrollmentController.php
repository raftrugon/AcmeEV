<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\EnrollmentRepo;
use App\Repositories\SubjectRepo;
use App\Subject;

class EnrollmentController extends Controller
{

    protected $enrollmentRepo;
    protected $subjectRepo;

    public function __construct(EnrollmentRepo $enrollmentRepo, SubjectRepo $subjectRepo){
        $this->enrollmentRepo = $enrollmentRepo;
        $this->subjectRepo = $subjectRepo;
    }


    public function getMyEnrollments(){
        $academic_years = $this->enrollmentRepo->getMyEnrollments()->orderBy('academic_year', 'DESC')->get()->groupBy('academic_year');
        return view('site.student.enrollment.my-enrollments', compact('academic_years'));
    }


    public function getEnroll(){
        $subjects_years = $this->subjectRepo->getMyNonPassedSubjects()->get()->groupBy('school_year');//Subject::all()->groupBy('school_year');
        return view('site.student.enrollment.enroll', compact('subjects_years'));
    }
}
