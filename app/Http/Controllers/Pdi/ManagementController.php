<?php

namespace App\Http\Controllers\Pdi;

use App\Degree;
use App\Http\Controllers\Controller;

class ManagementController extends Controller{

    public function __construct()
    {
    }

    public function getDegreeEditAddNextYearSubjects(Degree $degree){
        return view('site.pdi.management.addNextYearSubjects', compact('degree'));
    }
}