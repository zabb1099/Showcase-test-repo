<?php

namespace App\Jobs\ITPortal\ITSupport\CardPayment;

use App\Events\ITPortal\DevSupportJobs\CardPayment\DMDebtsolvCardPaymentEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class DMDebtsolvCardPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'debtsolv';
    protected $table = 'BulkProcesses';
    protected $id;
    protected $reason;
    protected $oldFieldValues;

    public function __construct($id, $reason)
    {
        $this->id = $id;
        $this->reason = $reason;
        $this->oldFieldValues = $this->getOldFieldValues();
    }

    public function handle()
    {
        $newFieldValues = [
            'Status' => 100
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'Status',
                'primary_key' => $this->id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->Status,
                'new_value' => $newFieldValues['Status']
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
        DMDebtsolvCardPaymentEvent::dispatch([
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
            ->where('BulkProcessID', '=', 20)
            ->where('Status', '!=', 100)
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
