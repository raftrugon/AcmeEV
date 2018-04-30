<?php

namespace App\Http\Controllers;

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
}
