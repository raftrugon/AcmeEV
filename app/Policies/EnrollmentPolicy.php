<?php

namespace App\Policies;

use App\Repositories\SystemConfigRepo;
use App\Repositories\UserRepo;
use App\User;
use App\Enrollment;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnrollmentPolicy
{
    use HandlesAuthorization;

    protected $userRepo;
    protected $systemConfigRepo;

    public function __construct(UserRepo $userRepo, SystemConfigRepo $systemConfigRepo)
    {
        $this->userRepo=$userRepo;
        $this->systemConfigRepo = $systemConfigRepo;
    }

    public function enroll(User $user)
    {
        $return = true;

        if(!$this->userRepo->canUserEnroll())
            $return = false;
        elseif($this->systemConfigRepo->getSystemConfig()->getActualState() != 3)
            $return = false;

        return $return;
    }


    public function update(User $user, Enrollment $enrollment)
    {
        //
    }


    public function delete(User $user, Enrollment $enrollment)
    {
        //
    }
}
