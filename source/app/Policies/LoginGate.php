<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LoginGate
{
    use HandlesAuthorization;

    private $allowedUserId = [1];
    private $isSuperUser = 1;

    /**
     * User can only log in if they're an administrator or a super user.
     */
    public function authorisedUser(User $user) : bool
    {
        if (in_array($user->UST_ID, $this->allowedUserId)) {
            return true;
        }

        return $user->USR_Unlimited == $this->isSuperUser;
    }

}
