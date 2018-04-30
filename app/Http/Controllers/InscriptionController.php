<?php

namespace App\Http\Controllers;

use App\Degree;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
    public function __construct(){

    }

    public function getNewInscription(){
        $degrees = Degree::all();
        return view('site.inscriptions.create-edit',compact('degrees'));
    }

}
