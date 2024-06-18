<?php

namespace App\Jobs\ITPortal\ITSupport\LeadsUser;

use App\Events\ITPortal\DevSupportJobs\LeadsUser\UpdateAssignedLeadDispositionsEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateAssignedLeadDispositions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'leads';
    protected $table = 'AssignedClients';
    protected $assignedId;
    protected $assignedUserId;
    protected $reason;
    protected $getOldFieldValues;

    public function __construct($assignedId, $assignedUserId, $reason)
    {
        $this->assignedId = $assignedId;
        $this->assignedUserId = $assignedUserId;
        $this->reason = $reason;
        $this->getOldFieldValues = $this->getOldFieldValues();
    }

    public function handle()
    {
        $newFieldValues = [
            'AssignedUserID' => $this->assignedUserId
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'AssignedUserID',
                'primary_key' => $this->getOldFieldValues->AssignedID,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->AssignedUserID,
                'new_value' => $newFieldValues['AssignedUserID']
            ]
        );

        $parameterValues = array(
            (object)[
                'parameter_name' => 'AssignedID',
                'value' => $this->assignedId
            ]
        );

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->where('AssignedID', '=', $this->assignedId)
            ->update($newFieldValues);

        // Dispatch Event for Auditing
        UpdateAssignedLeadDispositionsEvent::dispatch([
            'job_name' => static::class,
            'reason' => $this->reason,
            'action_type' => 'UPDATE',
            'parameter_values' => $parameterValues,
            'field_values' => $fieldValues
        ]);
    }

    private function getOldFieldValues()
    {
        return DB::connection($this->dbConnection)
            ->table($this->table)
            ->select('AssignedID', 'AssignedUserID')
            ->where('AssignedID', '=', $this->assignedId)
            ->first();
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
