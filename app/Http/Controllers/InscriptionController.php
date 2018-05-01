<?php

namespace App\Http\Controllers;

use App\Degree;
use App\Repositories\DegreeRepo;
use App\Repositories\InscriptionRepo;
use App\Repositories\RequestRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InscriptionController extends Controller
{
    protected $inscriptionRepo;
    protected $requestRepo;

    public function __construct(InscriptionRepo $inscriptionRepo,RequestRepo $requestRepo){
        $this->inscriptionRepo = $inscriptionRepo;
        $this->requestRepo = $requestRepo;
    }

    public function getNewInscription(){
        $degrees = Degree::all();
        return view('site.inscriptions.create-edit',compact('degrees'));
    }

    public function postSaveInscription(Request $request){

        $validator = Validator::make($request->all(),[
            'g-recaptcha-response' => 'required|captcha'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $inscription = array(
           'name'=>$request->input('name'),
           'surname'=>$request->input('surname'),
           'nif'=>$request->input('nif'),
           'address'=>$request->input('address'),
           'phone_number'=>$request->input('phone_number'),
           'email'=>$request->input('email'),
           'grade'=>$request->input('grade'),
           'password'=>$request->input('password'),
        );
        $this->inscriptionRepo->create($inscription);
    }


}
