<?php

namespace App\Jobs\ITPortal\ITSupport\TestCaseFile;

use App\Events\ITPortal\DevSupportJobs\TestCaseFile\LeadsClientFileEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class LeadsClientFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'leads';
    protected $table = 'MarketingData';
    protected $clientId;
    protected $reason;
    protected $getOldFieldValues;

    public function __construct($clientId, $reason)
    {
        $this->clientId = $clientId;
        $this->reason = $reason;
        $this->getOldFieldValues = $this->getOldFieldValues();
    }

    public function handle()
    {
       $newFieldValues = [
            'MarketingDataLeadSourceID' => 101
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'MarketingDataLeadSourceID',
                'primary_key' => $this->getOldFieldValues->MarketingDataID,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->MarketingDataLeadSourceID,
                'new_value' => $newFieldValues['MarketingDataLeadSourceID']
            ]
        );

        $parameterValues = array(
            (object)[
                'parameter_name' => 'MarketingDataClientID',
                'value' => $this->clientId,
            ]
        );

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->where('MarketingDataClientID', '=', $this->clientId)
            ->update($newFieldValues);

        // Dispatch Event for Auditing
        LeadsClientFileEvent::dispatch([
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
            ->select('MarketingDataLeadSourceID', 'MarketingDataID')
            ->where('MarketingDataClientID', '=', $this->clientId)
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
