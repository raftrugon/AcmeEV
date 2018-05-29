<?php

namespace App\Http\Controllers\Pdi;

use App\ControlCheck;
use App\ControlCheckInstance;
use App\Group;
use App\Http\Controllers\Controller;
use App\Repositories\ControlCheckInstanceRepo;
use App\Repositories\ControlCheckRepo;
use App\Repositories\FileRepo;
use App\Room;
use App\SubjectInstance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ControlCheckController extends Controller
{
    protected $controlCheckRepo;
    protected $controlCheckInstanceRepo;
    protected $fileRepo;

    public function __construct(ControlCheckRepo $controlCheckRepo,ControlCheckInstanceRepo $controlCheckInstanceRepo, FileRepo $fileRepo)
    {
        $this->controlCheckRepo=$controlCheckRepo;
        $this->controlCheckInstanceRepo=$controlCheckInstanceRepo;
        $this->fileRepo=$fileRepo;
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
                            'url'=>null,
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

    public function importGradesFromCsv(Request $request)
    {
        return $this->fileRepo->importGradesFromCsv($request->file('url'),$request->input('id'));
    }

    public function correctControlCheck(ControlCheck $controlCheck){
        $controlCheckInstances = $controlCheck->getControlCheckInstances;
        return view('site.pdi.controlCheck.correct',compact('controlCheckInstances'));
    }

    public function updateQualifications(Request $request) {
        $ids = $request->input('ids');
        $qualifications = $request->input('qualifications');
        for($i = 0; $i < count($ids); $i++) {
            $controlCheckInstance = ControlCheckInstance::where('id',$ids[$i])->first();
            $controlCheckInstance->setCalification($qualifications[$i]);
            $this->controlCheckInstanceRepo->updateWithoutData($controlCheckInstance);
        }
        return 'true';
    }
}