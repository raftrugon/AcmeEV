<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Repositories\EnrollmentRepo;
use App\Repositories\GroupRepo;
use App\Repositories\SubjectInstanceRepo;
use App\Repositories\SubjectRepo;
use App\Repositories\UserRepo;
use App\Subject;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{

    protected $enrollmentRepo;
    protected $subjectRepo;
    protected $subjectInstanceRepo;
    protected $userRepo;



    public function __construct(EnrollmentRepo $enrollmentRepo, SubjectRepo $subjectRepo, SubjectInstanceRepo $subjectInstanceRepo, UserRepo $userRepo)
    {
        $this->enrollmentRepo = $enrollmentRepo;
        $this->subjectRepo = $subjectRepo;
        $this->subjectInstanceRepo = $subjectInstanceRepo;
        $this->userRepo = $userRepo;
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
        $faker = Factory::create();

        DB::beginTransaction();
        try {
            $user = Auth()->user();
            $enrolled_subjects_id_array = $request->input('enrollment');
            $non_passed_subjects = $this->subjectRepo->getMyNonPassedSubjects()->get()->pluck('id');//Subject::all()->groupBy('school_year');

            if($enrolled_subjects_id_array == null || count($enrolled_subjects_id_array) == 0)
                return redirect()->back()->with('error',__('enrollment.empty'));

            foreach ($enrolled_subjects_id_array as $subject_id) {

                if(!$non_passed_subjects->contains($subject_id))
                    throw new \Exception('False post items.');

                $subject_instance = $this->subjectInstanceRepo->getCurrentInstance($subject_id);

                $enrollment = array(
                    'user_id' => $user->getId(),
                    'subject_instance_id' => $subject_instance->getId(),
                );

                $this->enrollmentRepo->create($enrollment);

                $group_id = $faker->randomElement($subject_instance->getGroups()->pluck('id')->toArray());
                $user->getGroups()->attach($group_id);

            }

            if($user->can('new')) {
                $user->revokePermissionTo('new');
                $user->givePermissionTo('current');
            }

            $this->userRepo->updateWithoutData($user);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->action('Student\EnrollmentController@getMyEnrollments');
    }


}
