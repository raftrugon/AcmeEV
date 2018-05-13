<?php

namespace App\Http\Controllers\Pdi;

use App\Degree;
use App\Http\Controllers\Controller;
use App\Repositories\SubjectInstanceRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagementController extends Controller{

    protected $subjectInstanceRepo;

    public function __construct(SubjectInstanceRepo $subjectInstanceRepo)
    {
        $this->subjectInstanceRepo=$subjectInstanceRepo;
    }

    public function getDegreeEditAddNextYearSubjects(Degree $degree){
        return view('site.pdi.management.addNextYearSubjects', compact('degree'));
    }

    public function createNextYearDegree(Request $request){

        $year = 1;
        foreach($request->input('subjects') as $subjectArray){
            foreach ($subjectArray as $subjectId){
                try{
                    $subjectInstance = array(
                        'academic_year' => Carbon::now()->year+1,
                        'subject_id' => $subjectId,
                    );
                    $this->subjectInstanceRepo->create($subjectInstance);
                    DB::commit();
                } catch(\Exception $e) {
                    DB::rollBack();
                }
            }
            $year++;
        }
        return 'true';
    }
}