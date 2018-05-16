<?php

namespace App\Http\Controllers;

use App\Department;
use App\Repositories\DepartmentRepo;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller{

    protected $departmentRepo;

    public function __construct(DepartmentRepo $departmentRepo)
    {
        $this->departmentRepo=$departmentRepo;
    }

    public function getAll() {
        $departments = Department::all();
        return view("site.department.all",compact('departments'));
    }

    public function getNewDepartment(){
        return view('site.department.create-edit');
    }

    public function postSaveDepartment(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'website'=>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $department = array(
                'name' => $request->input('name'),
                'code' => uniqid(),
                'website' => $request->input('website'),
            );
            $this->departmentRepo->create($department);

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        return view('site.inscriptions.success');
    }

    public function displayDepartment(Department $department) {
        $pdis = User
            ::whereNotNull('department_id')
            ->where('department_id', $department->getId())->get();
        $subjects = Subject
            ::where('department_id', $department->getId())
            ->orderBy('school_year')->get();
        return view('site.department.display',compact('department','pdis','subjects'));
    }
}
