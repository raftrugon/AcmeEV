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
use Carbon\Carbon;
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

    public function createOrEdit(SubjectInstance $subjectInstance, ControlCheck $controlCheck=null) {
        $rooms = Room::all();
        return view('site.pdi.controlCheck.create-edit',compact('subjectInstance','controlCheck','rooms'));
    }

    public function postControlCheck(Request $request) {
        $subjectInstance = SubjectInstance::where('id',$request->input('subjectInstance'))->first();
        try {
            if($request->input('id')=="0") {
                $controlCheck = array(
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'room_id' => $request->input('room'),
                    'date' => $request->input('date'),
                    'is_submittable' => is_null($request->input('isSubmittable')) ? false : true,
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
                            'url' => null,
                        );
                        $this->controlCheckInstanceRepo->create($controlCheckInstance);
                    }
                }
                DB::commit();
            } else {
                $controlCheck = ControlCheck::where('id',$request->input('id'))->first();
                $controlCheck->setName($request->input('name'));
                $controlCheck->setDescription($request->input('description'));
                $controlCheck->setRoom($request->input('room'));
                $controlCheck->setDate($request->input('date'));
                $controlCheck->setIsSubmittable(is_null($request->input('isSubmittable')) ? false : true);
                $controlCheck->setWeight($request->input('weight'));
                $controlCheck->setMinimumMark($request->input('minimumMark'));
                $this->controlCheckRepo->updateWithoutData($controlCheck);
            }
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error',__('global.post.error'));
        }catch(\Throwable $t){
            DB::rollBack();
            return redirect()->back()->with('error',__('global.post.error'));
        }

        $subject = SubjectInstance::where('id',$request->input('subjectInstance'))->first()->getSubject;
        $announcements = $subject->getSubjectInstances()->where('academic_year',Carbon::now()->year)->first()->getAnnouncements;
        $controlChecks = $this->controlCheckRepo->getControlChecksForLecturer($subject)->get();
        return view('site.subject.display',compact('subject','announcements','controlChecks'));
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
        return $this->controlCheckInstanceRepo->updateQualifications($request->input('ids'),$request->input('qualifications'));
    }

    public function deleteControlCheck(Request $request) {
        return $this->controlCheckRepo->deleteControlCheck($request->input('id'));
    }
}