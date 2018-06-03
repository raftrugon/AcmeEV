<?php

namespace App\Http\Controllers\Admin;

use App\Degree;
use App\Http\Controllers\Controller;
use App\Repositories\DegreeRepo;
use Illuminate\Http\Request;

class DegreeController extends Controller
{
    protected $degreeRepo;

    public function __construct(DegreeRepo $degreeRepo)
    {
        $this->degreeRepo=$degreeRepo;
    }

    public function deleteDegree(Request $request) {

        try{
            $degree = Degree::where('id',$request->input('id'))->first();
            $degree->delete();
            $this->degreeRepo->updateWithoutData($degree);
        }catch(\Exception $e){
            return 'false';
        }catch(\Throwable $t){
            return 'false';
        }

        return 'true';
    }

}
