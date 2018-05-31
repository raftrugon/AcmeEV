<?php

namespace App\Repositories;

use App\Inscription;
use App\Request;
use App\SystemConfig;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class InscriptionRepo extends BaseRepo
{

    protected $requestRepo;

    public function __construct(RequestRepo $requestRepo)
    {
        $this->requestRepo = $requestRepo;
    }

    public function getModel()
    {
       return new Inscription;
    }

    public function getAcceptedListForDegree($degree){
        return $this->getModel()
            ->join('requests', 'inscriptions.id', '=', 'requests.inscription_id')
            ->where('requests.degree_id',$degree->getId())
            ->where('requests.accepted', true)
            ->orderBy('inscriptions.grade', 'desc');
    }



    public function inscriptionBatch($actual_state){
        DB::beginTransaction();
        try {

            //Para el definitivo listado quitamos las adjudicaciones a los que no las han confirmado(agreed 0)
            if ($actual_state == 2)
                DB::table('requests')->join('inscriptions', 'requests.inscription_id', '=', 'inscriptions.id')->where('inscriptions.agreed', 0)->update(['accepted' => 0]);

            $inscriptions = Inscription::orderBy('grade', 'desc');

            //Para el definitivo listado solo iteramos sobre los que no consiguieron plaza.
            if ($actual_state == 2)
                $inscriptions = $inscriptions->where('agreed', null);


            //iteramos sobre las inscripciones por orden de nota
            foreach ($inscriptions->get() as $inscription) {

                //iteramos sobre las requests por orden de prioridad
                foreach ($inscription->getRequests()->orderBy('priority', 'asc')->get() as $request) {

                    //Buscamos cuantos estudiantes están ya asignados a este grado
                    $numAppliedToDegree = Request::where('degree_id', $request->getDegree->getId())->where('accepted', 1)->count();


                    //Si hay hueco en el grado se lo asignamos
                    if ($request->getDegree->getNewStudentsLimit() > $numAppliedToDegree) {

                        //Lo seteamos a aceptado
                        $request->setAccepted(1);
                        $this->requestRepo->updateWithoutData($request);

                        //Le seteamos el agreed de 0 a null en la segunda iteración para que si no confirma la request se le retire
                        $inscription->setAgreed(0);
                        $this->updateWithoutData($inscription);
                        break;
                    }
                }
            }


            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
            throw $e;
        }catch(\Throwable $t){
            DB::rollBack();
            throw $t;
        }
    }

    public function getResultsForUser($id_number,$password){
        $inscription = $this->getModel()->where('id_number',$id_number)->first();
        if(isset($inscription)){
            if(Hash::check($password,$inscription->getPassword())){
                return $inscription->getRequests()->join('degrees','requests.degree_id','=','degrees.id')->orderBy('priority','asc')
                    ->select('requests.priority','degrees.name','requests.accepted', DB::Raw(is_null($inscription->getAgreed()) ? 0 : $inscription->getAgreed() . ' as agreed'));
            } else {
                return Request::where('id',0);
            }
        } else {
            return Request::where('id',0);
        }
    }
}