<?php

namespace App\Jobs\ITPortal\ITSupport\FSSUser;

use App\Events\ITPortal\DevSupportJobs\FSSUser\DeleteBFGPortalLoginEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeleteBFGPortalLogin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'fss';
    protected $table = 'Users';
    protected $user_id;
    protected $reason;
    protected $oldFieldValues;

    public function __construct($user_id, $reason)
    {
        $this->user_id = $user_id;
        $this->reason = $reason;
        $this->oldFieldValues = $this->getOldFieldValues();
    }

    public function handle()
    {
        $newFieldValues = [
            'UserIsDeleted' => 1
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'UserIsDeleted',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->UserIsDeleted,
                'new_value' => $newFieldValues['UserIsDeleted']
            ]
        );

        $parameterValues = array(
            (object)[
                'parameter_name' => 'UserID',
                'value' => $this->user_id,
            ]
        );

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->where('UserID', $this->user_id)
            ->update($newFieldValues);

        // Dispatch Event for Auditing
        DeleteBFGPortalLoginEvent::dispatch([
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
            ->select('UserIsDeleted')
            ->where('UserID', '=', $this->user_id)
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
