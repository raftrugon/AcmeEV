<?php

namespace App\Http\Controllers\Pdi;

use App\Group;
use App\Http\Controllers\Controller;
use App\Repositories\GroupRepo;
use App\SubjectInstance;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{

    protected $groupRepo;

    public function __construct(GroupRepo $groupRepo)
    {
        $this->groupRepo = $groupRepo;
    }

    public function getGroupsForSubjectInstace(SubjectInstance $subjectInstance) {
        $groups = Group
            ::where('subject_instance_id',$subjectInstance->getId())->get();
        return view('site.pdi.group.all-for-subject-instance',compact('groups'));
    }

    public function editGroupLecturers(Group $group) {
        $theory_lecturer = $group->getTheoryLecturer;
        $practice_lecturer = $group->getPracticeLecturer;
        $department_lecturers = User
            ::where('department_id',Auth::user()->getDepartment->getId())->get();
        return view('site.pdi.group.edit',compact('theory_lecturer','practice_lecturer','department_lecturers','group'));
    }

    public function saveGroup(Request $request) {
        $group = Group::where('id',$request->input('group'))->first();
        $group->setTheoryLecturer($request->input('lecturers')[0]);
        $group->setPracticeLecturer($request->input('lecturers')[1]);
        $this->groupRepo->updateWithoutData($group);
        return 'true';
    }
}