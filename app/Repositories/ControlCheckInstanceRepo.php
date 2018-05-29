<?php

namespace App\Repositories;

use App\ControlCheckInstance;

class ControlCheckInstanceRepo extends BaseRepo
{

    public function __construct()
    {

    }

    public function getModel()
    {
        return new ControlCheckInstance();
    }

    public function getControlCheckInstanceForStudent($control_check_id,$id_number){
        return ControlCheckInstance::join('users','control_check_instances.student_id','users.id')
            ->where('control_check_instances.control_check_id',$control_check_id)
            ->where('users.id_number',$id_number)
            ->select('control_check_instances.*')->first();
    }

    public function updateQualifications($ids,$qualifications) {
        for($i = 0; $i < count($ids); $i++) {
            $controlCheckInstance = ControlCheckInstance::where('id',$ids[$i])->first();
            $controlCheckInstance->setCalification($qualifications[$i]);
            $this->updateWithoutData($controlCheckInstance);
        }
        return 'true';
    }
}