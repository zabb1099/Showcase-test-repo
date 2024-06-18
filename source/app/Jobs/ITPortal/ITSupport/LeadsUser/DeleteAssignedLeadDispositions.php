<?php

namespace App\Jobs\ITPortal\ITSupport\LeadsUser;

use App\Events\ITPortal\DevSupportJobs\LeadsUser\DeleteAssignedLeadDispositionsEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeleteAssignedLeadDispositions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'leads';
    protected $table = 'AssignedClients';
    protected $assignedId;
    protected $reason;

    public function __construct($assignedId, $reason)
    {
        $this->assignedId = $assignedId;
        $this->reason = $reason;
    }

    public function handle()
    {
        $fieldValues = array();

        $parameterValues = [];

        foreach ($this->assignedId as $key => $val) {
            $parameterValues[] = (object)[
                'parameter_name' => 'AssignedID',
                'value' => $val
            ];
        }

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->whereIn('AssignedID', $this->assignedId)
            ->delete();

        // Dispatch Event for Auditing
        DeleteAssignedLeadDispositionsEvent::dispatch([
            'job_name' => static::class,
            'reason' => $this->reason,
            'action_type' => 'DELETE',
            'parameter_values' => $parameterValues,
            'field_values' => $fieldValues
        ]);
    }

    /**
     * Handle a job failure.
     *
     * @param Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        // Send user notification of failure, etc...
    }
}
