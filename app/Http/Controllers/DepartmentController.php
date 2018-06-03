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

    public function displayDepartment(Department $department) {
        try{
        $pdis = User
            ::whereNotNull('department_id')
            ->where('department_id', $department->getId())->get();
        $subjects = Subject
            ::where('department_id', $department->getId())
            ->orderBy('school_year')->get();
        }catch(\Exception $e){
            return redirect()->action('HomeController@index')->with('error',__('global.get.error'));
        }catch(\Throwable $t){
            return redirect()->action('HomeController@index')->with('error',__('global.get.error'));
        }

        return view('site.department.display',compact('department','pdis','subjects'));
    }

    public function getPdis(Request $request) {
        return Department::where('id',$request->input('id'))->first()->getPDIs;
    }
}
