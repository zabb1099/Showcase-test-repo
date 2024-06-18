<?php

namespace App\Jobs\ITPortal\ITSupport\IVABond;

use App\Events\ITPortal\DevSupportJobs\IVABond\BondRenewalDateEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class BondRenewalDate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'debtsolv_iva';
    protected $table = 'Bond_RenewalSchedule';
    protected $id;
    protected $date;
    protected $reason;
    protected $getOldFieldValues;

    public function __construct($id, $date, $reason)
    {
        $this->id = $id;
        $this->date = $date;
        $this->reason = $reason;
        $this->getOldFieldValues = $this->getOldFieldValues();
    }

    public function handle()
    {
        $newFieldValues = [
            'Date' => $this->date
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'Date',
                'primary_key' => $this->id,
                'database_name' => config('database.connections.' . $this->dbConnection. '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->Date,
                'new_value' => $newFieldValues['Date']
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
            ->select('Date')
            ->where('ID', '=', $this->id)
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
