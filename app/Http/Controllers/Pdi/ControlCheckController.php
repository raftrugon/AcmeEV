<?php

namespace App\Http\Controllers\Pdi;

use App\ControlCheck;
use App\Group;
use App\Http\Controllers\Controller;
use App\Repositories\ControlCheckInstanceRepo;
use App\Repositories\ControlCheckRepo;
use App\Room;
use App\SubjectInstance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControlCheckController extends Controller
{
    protected $controlCheckRepo;
    protected $controlCheckInstanceRepo;

    public function __construct(ControlCheckRepo $controlCheckRepo,ControlCheckInstanceRepo $controlCheckInstanceRepo)
    {
        $this->controlCheckRepo=$controlCheckRepo;
        $this->controlCheckInstanceRepo=$controlCheckInstanceRepo;
    }

    public function getControlChecksForStudent(Group $group) {
        $controlChecks = ControlCheck::where('subject_instance_id',$group->getSubjectInstance()->getId());
        return view('site.student.subjectInstance.controlChecks.all',compact('controlChecks'));
    }

    public function createControlCheck(SubjectInstance $subjectInstance) {
        $rooms = Room::all();
        return view('site.pdi.controlCheck.create-edit',compact('subjectInstance','rooms'));
    }

    public function postControlCheck(Request $request) {
        $subjectInstance = SubjectInstance::where('id',$request->input('subjectInstance'))->first();
        try {
            $controlCheck = array(
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'room_id' => $request->input('room'),
                'date' => $request->input('date'),
                'is_submittable' => is_null($request->input('isSubmittable'))?false:true,
                'weight' => $request->input('weight'),
                'minimum_mark' => $request->input('minimumMark'),
                'subject_instance_id' => $subjectInstance->getId(),
            );
            $saved = $this->controlCheckRepo->create($controlCheck);
            foreach ($subjectInstance->getGroups as $group) {
                foreach ($group->getStudents as $student) {
                        $controlCheckInstance = array(
                            'calification' => null,
                            'control_check_id' => $saved->getId(),
                            'student_id' => $student->getId(),
                        );
                        $this->controlCheckInstanceRepo->create($controlCheckInstance);
                }
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        return view('home');
    }


}