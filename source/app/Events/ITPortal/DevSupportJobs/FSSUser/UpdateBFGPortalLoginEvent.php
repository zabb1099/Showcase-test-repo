<?php

namespace App\Events\ITPortal\DevSupportJobs\FSSUser;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateBFGPortalLoginEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auditingParameters;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($auditingParameters)
    {
        $this->auditingParameters = $auditingParameters;
    }

}
