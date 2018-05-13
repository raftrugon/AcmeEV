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
    protected $systemConfigRepo;

    public function __construct(RequestRepo $requestRepo, SystemConfigRepo $systemConfigRepo)
    {
        $this->requestRepo = $requestRepo;
        $this->systemConfigRepo = $systemConfigRepo;
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



    public function inscriptionBatch(){
        DB::beginTransaction();
        try {
            $systemConfig = SystemConfig::first();
            $iteration = $systemConfig->getInscriptionsListStatus();
            //Para el segundo y definitivo listado quitamos las adjudicaciones a los que no las han confirmado(agreed = 0)
            if ($iteration > 1) DB::table('requests')->join('inscriptions', 'requests.inscription_id', '=', 'inscriptions.id')->where('inscriptions.agreed', 0)->update(['accepted' => 0]);
            $inscriptions = Inscription::orderBy('grade', 'desc');
            //Para el segundo y definitivo listado solo iteramos sobre los que no tuvieron adjudicación en los anteriores listados
            if ($iteration > 1) $inscriptions->whereNull('agreed');
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
                        //Le seteamos el agreed de null a 0 para que si no confirma la request se le retire en el próximo listado
                        $inscription->setAgreed(0);
                        $this->updateWithoutData($inscription);
                        break;
                    }
                }
            }
            $iteration++;
            $systemConfig->setInscriptionsListStatus($iteration);
            $this->systemConfigRepo->updateWithoutData($systemConfig);
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
                return [];
            }
        } else {
            return [];
        }
    }
}