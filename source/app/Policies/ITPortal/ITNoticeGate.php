<?php

namespace App\Policies\ITPortal;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ITNoticeGate
{
    private $allowedUST_ID = [1];

    use HandlesAuthorization;

    public function view(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUST_ID);
    }

    public function create(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUST_ID);
    }

    public function edit(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUST_ID);
    }

    public function delete(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUST_ID);
    }
}
