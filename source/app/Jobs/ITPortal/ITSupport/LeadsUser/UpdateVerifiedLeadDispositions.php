<?php

namespace App\Jobs\ITPortal\ITSupport\LeadsUser;

use App\Events\ITPortal\DevSupportJobs\LeadsUser\UpdateVerifiedLeadDispositionsEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateVerifiedLeadDispositions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'leads';
    protected $table = 'tbl_Client_SIP3_Status';
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
            'Date_Completed' => NULL,
            'Completed_By' => NULL
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'Date_Completed',
                'primary_key' => $this->clientId,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->Date_Completed,
                'new_value' => $newFieldValues['Date_Completed']
            ],
            (object)[
                'field_name' => 'Completed_By',
                'primary_key' => $this->clientId,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->Completed_By,
                'new_value' => $newFieldValues['Completed_By']
            ]
        );

        $parameterValues = array(
            (object)[
                'parameter_name' => 'Client_ID',
                'value' => $this->clientId
            ]
        );

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->where('Client_ID', '=', $this->clientId)
            ->update($newFieldValues);

        // Dispatch Event for Auditing
        UpdateVerifiedLeadDispositionsEvent::dispatch([
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
            ->select('Date_Completed', 'Completed_By')
            ->where('Client_ID', $this->clientId)
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
