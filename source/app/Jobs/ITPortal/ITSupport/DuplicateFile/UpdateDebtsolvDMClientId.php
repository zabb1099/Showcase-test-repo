<?php

namespace App\Jobs\ITPortal\ITSupport\DuplicateFile;

use App\Events\ITPortal\DevSupportJobs\DuplicateFile\UpdateDebtsolvDMClientIdEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateDebtsolvDMClientId implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'leads';
    protected $table = 'Clients';
    protected $debtsolvClientId;
    protected $leadsClientId;
    protected $reason;
    protected $oldFieldValues;

    public function __construct($debtsolv_client_id, $leads_client_id, $reason)
    {
        $this->debtsolvClientId = $debtsolv_client_id;
        $this->leadsClientId = $leads_client_id;
        $this->reason = $reason;
        $this->oldFieldValues = $this->getOldFieldValues();
    }

    public function handle()
    {
        $newFieldValues = [
            'DS_IVA_CL_ID' => $this->debtsolvClientId
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'DS_IVA_CL_ID',
                'primary_key' => $this->leadsClientId,
                'database_name' => config('database.connections.' . $this->dbConnection. '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->DS_IVA_CL_ID,
                'new_value' => $newFieldValues['DS_IVA_CL_ID']
            ]
        );

        $parameterValues = array(
            (object)[
                'parameter_name' => 'ClientID',
                'value' => $this->leadsClientId
            ]
        );

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->where('ClientID', '=', $this->leadsClientId)
            ->update($newFieldValues);

        // Dispatch Event for Auditing
        UpdateDebtsolvDMClientIdEvent::dispatch([
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
            ->select('DS_IVA_CL_ID')
            ->where('ClientID', '=', $this->leadsClientId)
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
