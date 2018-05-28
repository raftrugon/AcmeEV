<?php

namespace App\Http\Controllers;

use App\Degree;
use App\Repositories\DegreeRepo;
use App\Repositories\SystemConfigRepo;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DegreeController extends Controller
{

    protected $degreeRepo;
    protected $systemConfigRepo;

    public function __construct(DegreeRepo $degreeRepo, SystemConfigRepo $systemConfigRepo){
        $this->degreeRepo = $degreeRepo;
        $this->systemConfigRepo = $systemConfigRepo;
    }

    public function getAllButSelected(Request $request){
        return $this->degreeRepo->getAllButSelected($request->input('ids'))->get();
    }

    public function getAll(){
        $degrees = Degree::where('deleted',0)->get();
        $actual_state = $this->systemConfigRepo->getActualState();
        return view('site.degree.all', compact('degrees','actual_state'));
    }

    public function getNewDegree(){
        $actual_state = $this->systemConfigRepo->getActualState();
        return view('site.degree.create-edit', compact('actual_state'));
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
        $school_years = Subject::where('degree_id',$degree->getId())->orderBy('school_year')->get()->groupBy('school_year');
        return view('site.degree.display',compact('degree','school_years'));
    }
}
