<?php

namespace App\Jobs\ITPortal\ITSupport\ClientType;

use App\Events\ITPortal\DevSupportJobs\ClientType\DMDebtsolvUpdateClientTypeEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class DMDebtsolvUpdateClientType implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'debtsolv';
    protected $table = 'Client_Status';
    protected $clientId;
    protected $clientType;
    protected $reason;
    protected $getOldFieldValues;

    public function __construct($clientId, $clientType, $reason)
    {
        $this->clientId = $clientId;
        $this->clientType = $clientType;
        $this->reason = $reason;
        $this->getOldFieldValues = $this->getOldFieldValues();
    }

    public function handle()
    {
        $newFieldValues = [
            'ClientType' => $this->clientType
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'ClientType',
                'primary_key' => $this->clientId,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->ClientType,
                'new_value' => $newFieldValues['ClientType']
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
        DMDebtsolvUpdateClientTypeEvent::dispatch([
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
            ->select('ClientType')
            ->where('ClientID', '=', $this->clientId)
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
