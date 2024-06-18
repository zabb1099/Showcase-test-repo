<?php

namespace App\Policies\ITPortal;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrintQueueGate
{
    use HandlesAuthorization;

    private $allowedUserId = [1];

    /**
     * Unlock Client Files.
     */
    public function accessPrintQueues(User $user) : bool
    {
        return in_array($user->UST_ID, $this->allowedUserId);
    }
}
