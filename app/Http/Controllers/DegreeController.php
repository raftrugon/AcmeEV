<?php

namespace App\Http\Controllers;

use App\Degree;
use App\Repositories\DegreeRepo;
use Illuminate\Http\Request;

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
}
