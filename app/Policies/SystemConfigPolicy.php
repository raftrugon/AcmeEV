<?php

namespace App\Policies;

use App\Repositories\SystemConfigRepo;
use App\User;
use App\SystemConfig;
use Illuminate\Auth\Access\HandlesAuthorization;

class SystemConfigPolicy
{
    use HandlesAuthorization;

    protected $systemConfigRepo;

    public function __construct(SystemConfigRepo $systemConfigRepo)
    {
        $this->systemConfigRepo = $systemConfigRepo;
    }


    public function stateEditDegreesDepartmentsSubjects()
    {
        $return = true;
        $actual_state = $this->systemConfigRepo->getActualState();

        if($actual_state > 2 && $actual_state < 8)
            $return = false;

        return $return;
    }

    public function stateEditMinutes()
    {
        $return = false;
        $actual_state = $this->systemConfigRepo->getActualState();

        if($actual_state == 5 || $actual_state == 7)
            $return = true;

        return $return;
    }

    public function stateListInscriptions()
    {
        $return = false;
        $actual_state = $this->systemConfigRepo->getActualState();

        if($actual_state == 1 || $actual_state == 2)
            $return = true;

        return $return;
    }



}
