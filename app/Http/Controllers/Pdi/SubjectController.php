<?php

namespace App\Http\Controllers\Pdi;

use App\Group;
use App\Http\Controllers\Controller;
use App\Repositories\SubjectRepo;
use App\Subject;
use App\SubjectInstance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller {

    protected $subjectRepo;

    public function __construct(SubjectRepo $subjectRepo)
    {
        $this->subjectRepo=$subjectRepo;
    }

    public function getSubjectsForCoordinator() {
        $subjects = Subject::where('coordinator_id',Auth::id())->get();
        return view('site.pdi.subject.coordinator-all',compact('subjects'));
    }

    public function getSubjectInstances(Subject $subject) {
        $subjectInstances = SubjectInstance
            ::where('subject_id',$subject->getId())
            ->where('academic_year',">=",Carbon::now()->year)->get();
        return view('site.pdi.subject.subject-instances',compact('subjectInstances','subject'));
    }

    public function getGroupsForSubjectInstance(SubjectInstance $subjectInstance){
        $groups = Group::where('subject_instance_id',$subjectInstance->getId())->get();
        return view('site.pdi.subject.groups',compact('groups'));
    }
}