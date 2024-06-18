<?php

namespace App\Jobs\ITPortal\ITSupport\UnlockClientFile;

use App\Events\ITPortal\DevSupportJobs\UnlockClientFile\FSSUnlockClientFileEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class FSSUnlockClientFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'leads';
    protected $table = 'tbl_Client_Lock';
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
            'Closed_By' => 549,
            'Date_Closed' => DB::raw('GETDATE()')
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'Closed_By',
                'primary_key' => $this->id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->Closed_By,
                'new_value' => $newFieldValues['Closed_By']
            ],
            (object)[
                'field_name' => 'Date_Closed',
                'primary_key' => $this->id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->Date_Closed,
                'new_value' => $newFieldValues['Date_Closed']
            ]
        );

        $parameterValues = array(
            (object)[
                'parameter_name' => 'ACC_ID',
                'value' => $this->id,
            ]
        );

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->where('ACC_ID', '=', $this->id)
            ->update($newFieldValues);

        // Dispatch Event for Auditing
        FSSUnlockClientFileEvent::dispatch([
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
            ->select('Closed_By', 'Date_Closed')
            ->where('ACC_ID', '=', $this->id)
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
