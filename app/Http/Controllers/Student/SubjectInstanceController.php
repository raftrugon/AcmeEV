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
        try{
        $academic_years = $this->enrollmentRepo->getMyEnrollments()->orderBy('academic_year', 'DESC')->get()->groupBy('academic_year');
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }

        return view('site.student.subjectInstance.my-subjects', compact('academic_years'));
    }
}
