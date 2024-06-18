<?php

namespace App\Jobs\ITPortal\ITSupport\XMLGeneration;

use App\Events\ITPortal\DevSupportJobs\TestCaseFile\LeadsClientFileEvent;
use App\Events\ITPortal\DevSupportJobs\XMLGeneration\XMLGenerationEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class GenerateXML implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'debtsolv_iva';
    protected $table = 'DFH_Upload_XML_Queue';
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
            'Ready_to_Print' => 1
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'Ready_to_Print',
                'primary_key' => $this->getOldFieldValues->Q_ID,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->Ready_to_Print,
                'new_value' => $newFieldValues['Ready_to_Print']
            ]
        );

        $parameterValues = array(
            (object)[
                'parameter_name' => 'ClientID',
                'value' => $this->clientId,
            ]
        );

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->where('ClientID', '=', $this->clientId)
            ->update($newFieldValues);

        // Dispatch Event for Auditing
        XMLGenerationEvent::dispatch([
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
            ->select('Ready_to_Print', 'Q_ID')
            ->where('ClientID', '=', $this->clientId)
            ->where ('pr_type', '=', 1)
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
