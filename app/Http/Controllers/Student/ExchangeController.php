<?php

namespace App\Http\Controllers\Student;

use App\Exchange;
use App\Group;
use App\Repositories\ExchangeRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ExchangeController extends Controller
{
    protected $exchangeRepo;

    public function __construct(ExchangeRepo $exchangeRepo){
        $this->exchangeRepo = $exchangeRepo;
    }

    public function getCreate(Request $request){
        $source = Group::findOrFail($request->input('group_id'));
        $target_options = Group::where('subject_instance_id',$source->getSubjectInstance->getId())->where('id','<>',$source->getId())->get()->map(function($group){
            return '<option value="'.$group->getId().'">'.__('group.number').': '.$group->getNumber().'</option>';
        })->toArray();
        $source_id = $source->getId();
        $source_number = $source->getNumber();
        $source_subject = $source->getSubjectInstance->getSubject->getName();
        $source_period_times = $source->getPeriodTimes->map(function($period){
           return $period->day . $period->start . $period->end;
        });
        array_unshift($target_options,'<option value="" selected disabled>'.__('group.select.default').'</option>');

        return compact('target_options','source_number','source_period_times','source_subject','source_id');
    }

    public function getTargetDataAndAvailability(Request $request){
        $target = Group::findOrFail($request->input('group_id'));
        $target_period_times = $target->getPeriodTimes->map(function($period){
            return $period->day . $period->start . $period->end;
        });
        $availability = $target->getMaxStudents() > $target->getStudents->count();
        return compact('availability','target_period_times');
    }

    public function postSave(Request $request){
        $target = Group::findOrFail($request->input('target_id'));
        $source = Group::findOrFail($request->input('source_id'));
        $permutaExistente = Exchange::where('source_id',$target->getId())
                                    ->where('target_id',$source->getId())
                                    ->where('is_approved',0)
                                    ->oldest()
                                    ->first();
        if(!is_null($permutaExistente)){
            $permutaExistente->setIsApproved(1);
            $this->exchangeRepo->updateWithoutData($permutaExistente);
            $permutaExistente->getUser->toggle([$target->getId(),$source->getId()]);
            Auth::user()->toggle([$target->getId(),$source->getId()]);
        }else if($target->getMaxStudents() > $target->getStudents->count()){
            Auth::user()->toggle([$target->getId(),$source->getId()]);
        }else{
            $permuta = new Exchange();
            $permuta->setSource($source->getId());
            $permuta->setTarget($target->getId());
            $permuta->setUser(Auth::id());
            $this->exchangeRepo->updateWithoutData($permuta);
        }

        //TODO: FALTA IMPLEMENTAR LAS RESPUESTAS AL CLIENTE (SUCCESS PARA LOS DOS PRIMEROS CASOS, WARNING PARA EL TERCERO. AÑADIR ADEMÁS UNA TRANSACTION EN EL PRIMER CASO.
    }
}
