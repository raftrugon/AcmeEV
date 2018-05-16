<?php

namespace App\Http\Controllers;

use App\Degree;
use App\Repositories\DegreeRepo;
use App\Subject;
use App\SubjectInstance;
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

    public function getEditDegree(Degree $degree){
        return view('site.degree.create-edit', compact('degree'));
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
            );

            if ($request->input('id')) {
                $degreeBD = $this->degreeRepo->findOrFail($request->input('id'));
                $this->degreeRepo->update($degreeBD, $degree);
            } else {
                //Random Code Generation (ABC123456)
                $random = $random_string = chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(48,57)) . chr(rand(48,57)). chr(rand(48,57)). chr(rand(48,57)). chr(rand(48,57)). chr(rand(48,57));
                $degree['code'] = $random;
                $this->degreeRepo->create($degree);
            }

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return redirect()->action('DegreeController@getAll');
    }

    public function displayDegree(Degree $degree) {
        $subjects = Subject
            ::where('degree_id',$degree->getId())
            ->orderBy('school_year')->get();
        return view('site.degree.display',compact('degree','subjects'));
    }
}
