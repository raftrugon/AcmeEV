<?php

namespace App\Policies;

use App\User;
use App\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;


    public function exchangeGroup(User $user, Group $group)
    {
        $return = true;

        $subject = $group->getSubjectInstance->getSubject;

        if($subject->getCoordinator->getId() != $user->getId())
            $return = false;

        return $return;

    }

}
