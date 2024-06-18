<?php

namespace App\Policies\ITPortal;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OfficeUserGate
{
    use HandlesAuthorization;

    private $allowedUserId = [1];

    public function view(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    public function create(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    public function edit(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }

    public function delete(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }
}
