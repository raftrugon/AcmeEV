<?php

namespace App\Policies;

use App\Repositories\SystemConfigRepo;
use App\User;
use App\SystemConfig;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class SystemConfigPolicy
{
    use HandlesAuthorization;

    protected $systemConfigRepo;

    public function __construct(SystemConfigRepo $systemConfigRepo)
    {
        $this->systemConfigRepo = $systemConfigRepo;
    }

    public function userLogged()
    {
        $return = true;

        try{
            Auth::user()->getId();
        } catch (\Exception $e){
            $return = false;
        } catch (\Throwable $t){
            $return = false;
        }

        return $return;
    }

    public function stateEditDegreesDepartmentsSubjects()
    {
        $return = true;
        $actual_state = $this->systemConfigRepo->getActualState();

        if($actual_state > 2 && $actual_state < 10)
            $return = false;

        return $return;
    }

    public function stateEditMinutes()
    {
        $return = false;
        $actual_state = $this->systemConfigRepo->getActualState();

        if($actual_state == 7 || $actual_state == 9)
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

    public function stateAccessTimeTable()
    {
        $return = false;
        $actual_state = $this->systemConfigRepo->getActualState();

        if($actual_state == 4)
            $return = true;

        return $return;
    }

    public function stateExchangeGroups()
    {
        $return = false;
        $actual_state = $this->systemConfigRepo->getActualState();

        if($actual_state == 5)
            $return = true;

        return $return;
    }



}
