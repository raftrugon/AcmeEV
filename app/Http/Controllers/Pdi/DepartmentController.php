<?php

namespace App\Http\Controllers\Pdi;

use App\Department;
use App\Http\Controllers\Controller;
use App\Repositories\DepartmentRepo;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{

    protected $departmentRepo;

    public function __construct(DepartmentRepo $departmentRepo)
    {
        $this->departmentRepo = $departmentRepo;
    }

    public function createOrEdit(Department $department = null)
    {
        try {
            return view('site.department.create-edit', compact('department'));
        } catch (\Exception $e) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        } catch (\Throwable $t) {
            return redirect()->action('HomeController@index')->with('error', __('global.get.error'));
        }
    }

    public function saveDepartment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'website' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            if ($request->input('id') == "0") {
                $department = array(
                    'name' => $request->input('name'),
                    'code' => uniqid(),
                    'website' => $request->input('website'),
                );
                $this->departmentRepo->create($department);
            } else {
                $department = Department::where('id', $request->input('id'))->first();
                $department->setName($request->input('name'));
                $department->setWebsite($request->input('website'));
                $this->departmentRepo->updateWithoutData($department);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __('global.post.error'));
        } catch (\Throwable $t) {
            DB::rollBack();
            return redirect()->back()->with('error', __('global.post.error'));
        }
        $departments = Department::all();
        return view("site.department.all", compact('departments'));
    }
}
