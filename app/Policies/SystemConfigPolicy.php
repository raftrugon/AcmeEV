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

        if($this->systemConfigRepo->getActualState() > 1 && $this->systemConfigRepo->getActualState() < 7)
            $return = false;

        return $return;
    }


}
