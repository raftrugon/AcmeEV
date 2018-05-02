<?php

namespace App\Http\Controllers;

use App\Degree;
use App\Repositories\DegreeRepo;
use App\Repositories\InscriptionRepo;
use App\Repositories\RequestRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'name'=>'required',
            'surname'=>'required',
            'nif'=>'required|unique:users',
            'address'=>'required',
            'phone_number'=>'required',
            'email'=>'required|email|unique:users',
            'grade'=>'required|min:5|max:14',
            'option1'=>'required',
            'password'=>'required',
            'password_repeat'=>'required|same:password',
            'g-recaptcha-response' => 'required'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $inscription = array(
                'name' => $request->input('name'),
                'surname' => $request->input('surname'),
                'nif' => $request->input('nif'),
                'address' => $request->input('address'),
                'phone_number' => $request->input('phone_number'),
                'email' => $request->input('email'),
                'grade' => $request->input('grade'),
                'password' => bcrypt($request->input('password')),
            );
            $inscription = $this->inscriptionRepo->create($inscription);

            if ($request->input('option1')) {
                $this->requestRepo->create(['priority' => 1, 'degree_id' => $request->input('option1'), 'inscription_id' => $inscription->getId()]);

                if ($request->input('option2')) {
                    $this->requestRepo->create(['priority' => 2, 'degree_id' => $request->input('option2'), 'inscription_id' => $inscription->getId()]);

                    if ($request->input('option3')) {
                        $this->requestRepo->create(['priority' => 3, 'degree_id' => $request->input('option3'), 'inscription_id' => $inscription->getId()]);

                        if ($request->input('option4')) {
                            $this->requestRepo->create(['priority' => 4, 'degree_id' => $request->input('option4'), 'inscription_id' => $inscription->getId()]);

                            if ($request->input('option5')) {
                                $this->requestRepo->create(['priority' => 5, 'degree_id' => $request->input('option5'), 'inscription_id' => $inscription->getId()]);
                            }
                        }
                    }
                }
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }
        return view('site.inscriptions.success');
    }


}
