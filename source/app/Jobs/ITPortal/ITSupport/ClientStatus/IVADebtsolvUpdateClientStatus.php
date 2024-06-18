<?php

namespace App\Jobs\ITPortal\ITSupport\ClientStatus;

use App\Events\ITPortal\DevSupportJobs\ClientStatus\IVADebtsolvUpdateClientStatusEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class IVADebtsolvUpdateClientStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'debtsolv_iva';
    protected $table = 'Client_Contact';
    protected $clientId;
    protected $clientStatus;
    protected $reason;
    protected $oldFieldValues;

    public function __construct($clientId, $clientStatus, $reason)
    {
        $this->clientId = $clientId;
        $this->clientStatus = $clientStatus;
        $this->reason = $reason;
        $this->oldFieldValues = $this->getOldFieldValues();
    }

    public function handle()
    {
        $newFieldValues = [
            'Status' => $this->clientStatus
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'Status',
                'primary_key' => $this->clientId,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->Status,
                'new_value' => $newFieldValues['Status']
            ]
        );

        $parameterValues = array(
            (object)[
                'parameter_name' => 'ID',
                'value' => $this->clientId,
            ]
        );

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->where('ID', '=', $this->clientId)
            ->update($newFieldValues);

        // Dispatch Event for Auditing
        IVADebtsolvUpdateClientStatusEvent::dispatch([
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
            ->select('Status')
            ->where('ID', '=', $this->clientId)
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
