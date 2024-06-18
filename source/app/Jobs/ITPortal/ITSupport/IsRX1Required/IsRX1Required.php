<?php

namespace App\Jobs\ITPortal\ITSupport\IsRX1Required;

use App\Events\ITPortal\DevSupportJobs\IVABond\BondRenewalDateEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class IsRX1Required implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'debtsolv_iva';
    protected $table = 'DFH_Client_Contact';
    protected $clientId;
    protected $RX1_not_required;
    protected $Is_property_HA;
    protected $reason;
    protected $getOldFieldValues;

    public function __construct($clientId, $RX1_not_required, $Is_property_HA, $reason)
    {
        $this->clientId = $clientId;
        $this->RX1_not_required = $RX1_not_required;
        $this->Is_property_HA = $Is_property_HA;
        $this->reason = $reason;
        $this->getOldFieldValues = $this->getOldFieldValues();
    }

    public function handle()
    {
        $newFieldValues = [
            'RX1_not_required' => $this->RX1_not_required,
            'Is_property_HA' => $this->Is_property_HA
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'RX1_not_required',
                'primary_key' => $this->clientId,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->RX1_not_required,
                'new_value' => $newFieldValues['RX1_not_required']
            ],
            (object)[
                'field_name' => 'Is_property_HA',
                'primary_key' => $this->clientId,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->Is_property_HA,
                'new_value' => $newFieldValues['Is_property_HA']
            ]
        );

        $parameterValues = array(
            (object)[
                'parameter_name' => 'Client_ID',
                'value' => $this->clientId,
            ]
        );

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->where('Client_ID', '=', $this->clientId)
            ->update($newFieldValues);

        // Dispatch Event for Auditing
        BondRenewalDateEvent::dispatch([
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
            ->select('RX1_not_required', 'Is_property_HA')
            ->where('Client_ID', '=', $this->clientId)
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
