<?php

namespace App\Jobs\ITPortal\ITSupport\LeadsUser;

use App\Events\ITPortal\DevSupportJobs\LeadsUser\UpdateHistoryAssignedLeadDispositionsEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateHistoryAssignedLeadDispositions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'leads';
    protected $table = 'History';
    protected $historyId;
    protected $historyUserId;
    protected $reason;
    protected $getOldFieldValues;

    public function __construct($historyId, $historyUserId, $reason)
    {
        $this->historyId = $historyId;
        $this->historyUserId = $historyUserId;
        $this->reason = $reason;
        $this->getOldFieldValues = $this->getOldFieldValues();
    }

    public function handle()
    {
        $newFieldValues = [
            'HistoryUserID' => $this->historyUserId
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'HistoryUserID',
                'primary_key' => $this->getOldFieldValues->HistoryID,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->HistoryUserID,
                'new_value' => $newFieldValues['HistoryUserID']
            ]
        );

        $parameterValues = array(
            (object)[
                'parameter_name' => 'HistoryID',
                'value' => $this->historyId
            ]
        );

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->where('HistoryID', '=', $this->historyId)
            ->update($newFieldValues);

        // Dispatch Event for Auditing
        UpdateHistoryAssignedLeadDispositionsEvent::dispatch([
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
            ->select('HistoryID', 'HistoryUserID')
            ->where('HistoryID', '=', $this->historyId)
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
