<?php

namespace App\Jobs\ITPortal\ITSupport\ProcessPayout;

use App\Events\ITPortal\DevSupportJobs\ProcessPayout\IVADebtsolvProcessPayoutEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class IVADebtsolvProcessPayout implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'debtsolv_iva';
    protected $table = 'BulkProcesses';
    protected $id;
    protected $reason;
    protected $getOldFieldValues;

    public function __construct($id, $reason)
    {
        $this->id = $id;
        $this->reason = $reason;
        $this->getOldFieldValues = $this->getOldFieldValues();
    }

    public function handle()
    {
        $newFieldValues = [
            'Status' => 100,
            'Notes' => 'Stopped by IT'
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'Status',
                'primary_key' => $this->id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->Status,
                'new_value' => $newFieldValues['Status']
            ],
            (object)[
                'field_name' => 'Notes',
                'primary_key' => $this->id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->Notes,
                'new_value' => $newFieldValues['Notes']
            ]
        );

        $parameterValues = array(
            (object)[
                'parameter_name' => 'ID',
                'value' => $this->id,
            ]
        );

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->where('ID', '=', $this->id)
            ->update($newFieldValues);

        // Dispatch Event for Auditing
        IVADebtsolvProcessPayoutEvent::dispatch([
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
            ->select('Status', 'Notes')
            ->where('Status', '=', 10)
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
