<?php

namespace App\Http\Controllers\Pas;

use App\Repositories\DegreeRepo;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasController extends Controller
{
    protected $degreeRepo;

    public function __construct(DegreeRepo $degreeRepo){
        $this->degreeRepo = $degreeRepo;
    }

    public function getPrintAllLists(Request $request){
        $degrees = $this->degreeRepo->getDegreesWithAcceptedRequests(explode(',',$request->input('degree_ids')));
        return PDF::loadView('site.pas.pdf.inscription-list',compact('degrees'))->download('inscriptions.pdf');
    }

    public function getDashboard(){
        return view('site.pas.dashboard');
    }


}
