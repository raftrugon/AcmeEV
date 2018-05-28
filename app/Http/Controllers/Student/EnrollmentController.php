<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\EnrollmentRepo;
use App\Repositories\SubjectInstanceRepo;
use App\Repositories\SubjectRepo;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{

    protected $enrollmentRepo;
    protected $subjectRepo;
    protected $subjectInstanceRepo;

    public function __construct(EnrollmentRepo $enrollmentRepo, SubjectRepo $subjectRepo, SubjectInstanceRepo $subjectInstanceRepo)
    {
        $this->enrollmentRepo = $enrollmentRepo;
        $this->subjectRepo = $subjectRepo;
        $this->subjectInstanceRepo = $subjectInstanceRepo;
    }


    public function getMyEnrollments()
    {
        $academic_years = $this->enrollmentRepo->getMyEnrollments()->orderBy('academic_year', 'DESC')->get()->groupBy('academic_year');
        return view('site.student.enrollment.my-enrollments', compact('academic_years'));
    }


    public function getEnroll()
    {
        $subjects_years = $this->subjectRepo->getMyNonPassedSubjects()->get()->groupBy('school_year');//Subject::all()->groupBy('school_year');
        return view('site.student.enrollment.enroll', compact('subjects_years'));
    }

    public function postPostEnroll(Request $request)
    {
        /*$validator = Validator::make($request->all(),[
            'name'=>'required',
            'new_students_limit'=>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }*/

        DB::beginTransaction();
        try {
            $user = Auth()->user();
            $enrolled_subjects_id_array = $request->input('enrollment');

            foreach ($enrolled_subjects_id_array as $subject_id) {

                $subject_instance = $this->subjectInstanceRepo->getCurrentInstance($subject_id);

                $enrollment = array(
                    'user_id' => $user->getId(),
                    'subject_instance_id' => $subject_instance->getId(),
                );

                $this->enrollmentRepo->create($enrollment);

            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->action('Student\EnrollmentController@getMyEnrollments');
    }


}
