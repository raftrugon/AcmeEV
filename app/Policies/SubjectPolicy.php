<?php

namespace App\Policies;

use App\Repositories\SubjectRepo;
use App\User;
use App\Subject;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
{
    use HandlesAuthorization;

    protected $subjectRepo;

    public function __construct(SubjectRepo $subjectRepo){
        $this->subjectRepo = $subjectRepo;
    }

    /**
     * Determine whether the user can view the subject.
     *
     * @param  \App\User  $user
     * @param  \App\Subject  $subject
     * @return mixed
     */
    public function view(User $user, Subject $subject)
    {
        if(!is_null($user->getSubjectInstances()->where('academic_year',$this->subjectRepo->getAcademicYear())->where('subject_id',$subject->getId())->first())) {
            return true;
        }else if($this->subjectRepo->getSubjectsForTeacher()->pluck('id')->contains($subject->getId())
        ){
            return true;
        }else {
            return false;
        }
    }

    /**
     * Determine whether the user can create subjects.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the subject.
     *
     * @param  \App\User  $user
     * @param  \App\Subject  $subject
     * @return mixed
     */
    public function update(User $user, Subject $subject)
    {
        //
    }

    /**
     * Determine whether the user can delete the subject.
     *
     * @param  \App\User  $user
     * @param  \App\Subject  $subject
     * @return mixed
     */
    public function delete(User $user, Subject $subject)
    {
        //
    }
}
