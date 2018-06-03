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
use App\Repositories\UserRepo;
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

class StudentController extends Controller
{

    protected $userRepo;

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function getStudentsWithStatusZeroMinutes() {
        $students = $this->userRepo->getStudentsWithStatusZeroMinutes()->get();
        return view('site.student.list',compact('students'));
    }
}