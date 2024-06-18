<?php

namespace App\Jobs\ITPortal\ITSupport\LeadsUser;

use App\Events\ITPortal\DevSupportJobs\LeadsUser\UpdateHistoryLeadDispositionsEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateHistoryLeadDispositions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'leads';
    protected $table = 'History';
    protected $historyId;
    protected $reason;
    protected $getOldFieldValues;

    public function __construct($historyId, $reason)
    {
        $this->historyId = $historyId;
        $this->reason = $reason;
        $this->getOldFieldValues = $this->getOldFieldValues();
    }

    public function handle()
    {
        $newFieldValues = [
            'HistoryIsDeleted' => 1
        ];

        $fieldValues = [];
        $oldValues = $this->getOldFieldValues;

        foreach ($oldValues as $key => $val) {
            $fieldValues[] = (object)[
                'field_name' => 'HistoryIsDeleted',
                'primary_key' => $val->HistoryID,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $val->HistoryIsDeleted,
                'new_value' => $newFieldValues['HistoryIsDeleted']
            ];
        }

        $parameterValues = [];

        foreach ($this->historyId as $key => $val) {
            $parameterValues[] = (object)[
                    'parameter_name' => 'HistoryID',
                    'value' => $val
            ];
        }

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->whereIn('HistoryID', $this->historyId)
            ->update($newFieldValues);

        // Dispatch Event for Auditing
        UpdateHistoryLeadDispositionsEvent::dispatch([
            'job_name' => static::class,
            'reason' => $this->reason,
            'action_type' => 'UPDATE',
            'parameter_values' => $parameterValues,
            'field_values' => $fieldValues
        ]);
    }

    private function getOldFieldValues(): Collection
    {
        return DB::connection($this->dbConnection)
            ->table($this->table)
            ->select('HistoryID', 'HistoryIsDeleted')
            ->whereIn('HistoryID', $this->historyId)
            ->get();
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
