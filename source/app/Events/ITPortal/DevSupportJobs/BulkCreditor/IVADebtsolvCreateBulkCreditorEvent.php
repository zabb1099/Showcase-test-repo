<?php

namespace App\Events\ITPortal\DevSupportJobs\BulkCreditor;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class IVADebtsolvCreateBulkCreditorEvent
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
