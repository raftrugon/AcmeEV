<?php

namespace App\Http\Controllers;

use App\Department;
use App\Repositories\DepartmentRepo;
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
}
