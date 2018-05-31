<?php

namespace App\Http\Controllers;

use App\Degree;
use App\Inscription;
use App\Repositories\DegreeRepo;
use App\Repositories\InscriptionRepo;
use App\Repositories\RequestRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

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
            'id_number'=>'required|unique:users',
            'address'=>'required',
            'phone_number'=>'required',
            'email'=>'required|email|unique:users',
            'grade'=>'required',
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
                'id_number' => $request->input('id_number'),
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
            return redirect()->action('HomeController@index')->with('error',__('inscription.error'));
        }
        return redirect()->action('HomeController@index')->with('success',__('inscription.success'));
    }

    public function getResultsInscription(){
        return view('site.inscriptions.list');
    }

    public function getResultsInscriptionData(Request $request){
        $results = $this->inscriptionRepo->getResultsForUser($request->input('id_number'),$request->input('password'));
        $priorityOfAccepted = $results->get()->pluck('accepted')->search(true);
        return DataTables::of($results)
            ->editColumn('accepted',function($request){
                if($request->accepted && !$request->agreed) {
                    return '<button type="button" class="btn btn-light btn-sm agree-btn">' . __('inscription.agree') . '</button>';
                }elseif($request->accepted && $request->agreed){
                    return '<i class="far fa-check-circle" style="font-size:1.5em"></i>';
                }else{
                    return '';
                }
            })
            ->rawColumns(['accepted'])
            ->setRowClass(function ($request) use ($priorityOfAccepted) {
                if($priorityOfAccepted !== false){
                    $priorityOfAccepted++;
                    if($request->priority < $priorityOfAccepted) return 'bg-danger';
                    elseif ($request->priority == $priorityOfAccepted) return 'bg-success';
                    else return 'bg-secondary';
                }else{
                    return 'bg-danger';
                }
            })
            ->make(true);
    }

    public function postAgreeToInscription(Request $request){
        try {
            $inscription = Inscription::where('id_number',$request->input('id_number'))->first();
            if(is_null($inscription) || !Hash::check($request->input('password'),$inscription->getPassword())){
                return 'credentials';
            }
            $inscription->setAgreed(true);
            $this->inscriptionRepo->updateWithoutData($inscription);
            return 'true';
        }catch(\Exception $e){
            return 'false';
        }
    }


}
