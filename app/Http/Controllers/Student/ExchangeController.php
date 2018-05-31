<?php

namespace App\Http\Controllers\Student;

use App\Exchange;
use App\Group;
use App\Repositories\ExchangeRepo;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $isRepeated = Exchange::where('source_id',$source->getId())
                        ->where('user_id',Auth::id())
                        ->where('is_approved',0)
                        ->count('id') > 0;
        if($isRepeated) return 'repeated';

        $permutaExistente = Exchange::where('source_id',$target->getId())
                                    ->where('target_id',$source->getId())
                                    ->where('is_approved',0)
                                    ->oldest()
                                    ->first();
        DB::beginTransaction();
        try {
            $done = true;
            if (!is_null($permutaExistente)) {
                $permutaExistente->setIsApproved(1);
                $this->exchangeRepo->updateWithoutData($permutaExistente);
                $permutaExistente->getUser->getGroups()->toggle([$target->getId(), $source->getId()]);
                Auth::user()->getGroups()->toggle([$target->getId(), $source->getId()]);
            } else if ($target->getMaxStudents() > $target->getStudents->count()) {
                Auth::user()->getGroups()->toggle([$target->getId(), $source->getId()]);
            } else {
                $done = false;
                $permuta = new Exchange();
                $permuta->setSource($source->getId());
                $permuta->setTarget($target->getId());
                $permuta->setUser(Auth::id());
                $this->exchangeRepo->updateWithoutData($permuta);
            }
            DB::commit();
            if($done) return 'true';
            else return 'waiting';
        }catch(Exception $e){
            DB::rollback();
            return false;
        }

    }
}
