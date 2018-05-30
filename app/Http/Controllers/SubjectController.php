<?php

namespace App\Http\Controllers;

use App\ControlCheckInstance;
use App\File;
use App\Folder;
use App\Repositories\ControlCheckRepo;
use App\Repositories\SubjectInstanceRepo;
use App\Repositories\SubjectRepo;
use App\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class SubjectController extends Controller
{

    protected $subjectRepo;
    protected $controlCheckRepo;
    protected $subjectInstanceRepo;

    public function __construct(SubjectRepo $subjectRepo, ControlCheckRepo $controlCheckRepo, SubjectInstanceRepo $subjectInstanceRepo)
    {
        $this->subjectRepo=$subjectRepo;
        $this->controlCheckRepo=$controlCheckRepo;
        $this->subjectInstanceRepo=$subjectInstanceRepo;
    }

    public function getSubjectDisplay(Subject $subject){
        $announcements = $subject->getSubjectInstances()->where('academic_year',Carbon::now()->year)->first()->getAnnouncements;
        $controlCheckInstances = $this->controlCheckRepo->getControlCheckInstancesForStudent($subject,null)->get();
        $controlChecks = $this->controlCheckRepo->getControlChecksForLecturer($subject)->get();
        $canCreateControlChecks = $this->subjectInstanceRepo->canAddControlChecks(
            $this->subjectInstanceRepo->getCurrentInstance($subject->getId())->getId());
        if(Auth::user()->hasRole('student'))
            return view('site.subject.display',compact('subject','announcements','controlCheckInstances'));
        elseif(Auth::user()->hasRole('pdi'))
            return view('site.subject.display',compact('subject','announcements','controlChecks','canCreateControlChecks'));
    }

    public function getFileSystemData(Request $request){
        $folderId = $request->input('folderId');
        $parent = isset($folderId) ? Folder::findOrFail($folderId)->getParent : null;
        $parentId = isset($parent) ? $parent->getId() : null;
        return ['content'=>view('site.subject.includes.filesystem-data', $this->subjectRepo->getFoldersAndFiles($request->input('subjectId'),$request->input('folderId')))->render(),
            'parentId'=>$parentId,'currentName'=>isset($folderId) ?  Folder::findOrFail($folderId)->getName() : '/'];
    }

    public function getDownloadFile(File $file){
        $extension = \Illuminate\Support\Facades\File::extension(URL::to($file->getUrl()));
        return Storage::download(substr($file->getUrl(),8),$file->getName().'.'.$extension);
    }
}
