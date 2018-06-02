<?php

namespace App\Http\Controllers\Pdi;

use App\Degree;
use App\Department;
use App\File;
use App\Folder;
use App\Group;
use App\Http\Controllers\Controller;
use App\Repositories\FileRepo;
use App\Repositories\FolderRepo;
use App\Repositories\SubjectInstanceRepo;
use App\Repositories\SubjectRepo;
use App\Subject;
use App\SubjectInstance;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller {

    protected $subjectRepo;
    protected $folderRepo;
    protected $fileRepo;

    public function __construct(SubjectRepo $subjectRepo,FolderRepo $folderRepo,FileRepo $fileRepo)
    {
        $this->subjectRepo=$subjectRepo;
        $this->folderRepo=$folderRepo;
        $this->fileRepo=$fileRepo;
    }

    public function getSubjectsForCoordinator() {
        $subjects = Subject::where('coordinator_id',Auth::id())->get();
        return view('site.pdi.subject.coordinator-all',compact('subjects'));
    }

    public function getSubjectInstances(Subject $subject) {
        if($subject->getCoordinator->getId()==Auth::user()->getId()){
            $subjectInstances = SubjectInstance
                ::where('subject_id',$subject->getId())
                ->where('academic_year',">=",Carbon::now()->year)->get();
            return view('site.pdi.subject.subject-instances',compact('subjectInstances','subject'));
        } else {
            return view('home');
        }
    }

    public function getGroupsForSubjectInstance(SubjectInstance $subjectInstance){
        if($subjectInstance->getSubject->getCoordinator==Auth::user()) {
            $groups = Group::where('subject_instance_id', $subjectInstance->getId())->get();
            return view('site.pdi.subject.groups', compact('groups'));
        } else {
            return view('home');
        }
    }

    public function getMySubjectList(){
        $subjects = $this->subjectRepo->getSubjectsForTeacher()->get();
        return view('site.pdi.subject.list',compact('subjects'));
    }

    public function postNewFolder(Request $request){
        try {
            $values = collect($request->all());
            $subject_id = SubjectInstance::where('subject_id', $values->get('subject_id'))->where('academic_year', Carbon::now()->year)->first()->getId();
            $values->put('subject_instance_id', $subject_id);
            $values = $values->except('subject_id');
            $this->folderRepo->create($values->toArray());
            return 'true';
        }catch(\Exception $e){
            return 'false';
        }catch(\Throwable $t){
            return 'false';
        }
    }

    public function postNewFile(Request $request){
        try{
            $folder = Folder::findOrFail($request->input('folder_id'));
            $subject = $folder->getSubjectInstance->getSubject;
            $relativeUrl = Storage::putFile('subjects/'.$subject->getCode().'/'.Carbon::now()->year.'/'.$folder->getId(),$request->file('url'));
            $url = Storage::url($relativeUrl);
            $this->fileRepo->create(['name'=>$request->input('name'),'url'=>$url,'folder_id' =>$folder->getId()]);
            return 'true';
        }catch(\Exception $e){
            return 'false';
        }catch(\Throwable $t){
            return 'false';
        }

    }

    public function postSaveFolder(Request $request){
        try {
            $folder = Folder::findOrFail($request->input('id'));
            $folder->setName($request->input('name'));
            $folder->setDescription($request->input('description'));
            $this->folderRepo->updateWithoutData($folder);
            return 'true';
        }catch(\Exception $e){
            return 'false';
        }catch(\Throwable $t){
            return 'false';
        }
    }

    public function postDeleteFolder(Request $request){
        try{
            $this->folderRepo->delete(Folder::findOrFail($request->input('id')));
            return 'true';
        }catch(\Exception $e){
            return 'false';
        }catch(\Throwable $t){
            return 'false';
        }
    }

    public function postDeleteFile(Request $request){
        try{
            $this->fileRepo->delete(File::findOrFail($request->input('id')));
            return 'true';
        }catch(\Exception $e){
            return 'false';
        }catch(\Throwable $t){
            return 'false';
        }
    }

    public function createOrEdit(Degree $degree,Subject $subject=null) {
        $departments = Department::all();
        return view('site.subject.create-edit',compact('subject','degree','departments'));
    }

    public function saveSubject(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'school_year'=>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $type = 'EDP';
            switch ($request->input('type')){
                case "0":
                    $type = 'OBLIGATORY';
                    break;
                case "1":
                    $type = 'BASIC';
                    break;
                case "2":
                    $type = 'OPTATIVE';
            }
            if ($request->input('id') == "0") {
                $subject = array(
                    'name' => $request->input('name'),
                    'code' => uniqid(),
                    'subject_type' => $type,
                    'school_year' => $request->input('school_year'),
                    'semester' => $request->input('semester')=="2" ? null : $request->input('semester'),
                    'degree_id' => $request->input('degree'),
                    'department_id' =>$request->input('department'),
                );
                $this->subjectRepo->create($subject);
            } else {
                $subject  =Subject::where('id',$request->input('id'))->first();
                $subject->setName($request->input('name'));
                $subject->setSubjectType($type);
                $subject->setSchoolYear($request->input('school_year'));
                $subject->setSemester($request->input('semester')==2 ? null : $request->input('semester'));
                $subject->setDepartment($request->input('department'));
                $this->subjectRepo->updateWithoutData($subject);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error',__('global.post.error'));
        }catch(\Throwable $t){
            DB::rollBack();
            return redirect()->back()->with('error',__('global.post.error'));
        }

        $departments = Department::all();
        return view("site.department.all",compact('departments'));
    }
}
