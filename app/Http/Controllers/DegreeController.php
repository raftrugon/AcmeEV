<?php

namespace App\Http\Controllers;

use App\Degree;
use App\Repositories\DegreeRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DegreeController extends Controller
{

    protected $degreeRepo;

    public function __construct(DegreeRepo $degreeRepo){
        $this->degreeRepo = $degreeRepo;
    }

    public function getAllButSelected(Request $request){
        return $this->degreeRepo->getAllButSelected($request->input('ids'))->get();
    }

    public function getAll(){
        $degrees = Degree::all();
        return view('site.degree.all', compact('degrees'));
    }

    public function getNewDegree(){
        return view('site.degree.create-edit');
    }

    public function postSaveDegree(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'new_students_limit'=>'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $degree = array(
                'name' => $request->input('name'),
                'new_students_limit' => $request->input('new_students_limit'),
                'code' => 'AAA000005',
            );
            $this->degreeRepo->create($degree);

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        $degrees = Degree::all();
        return view('site.degree.all', compact('degrees'));
    }
}
