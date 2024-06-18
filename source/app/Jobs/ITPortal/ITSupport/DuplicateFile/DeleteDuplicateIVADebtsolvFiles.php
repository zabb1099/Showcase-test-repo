<?php

namespace App\Jobs\ITPortal\ITSupport\DuplicateFile;

use App\Events\ITPortal\DevSupportJobs\DuplicateFile\DeleteDuplicateIVADebtsolvFilesEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;


class DeleteDuplicateIVADebtsolvFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'debtsolv_iva';
    protected $table = 'Client_Contact';
    protected $clientIdsToDelete;
    protected $reason;

    public function __construct($client_ids_to_delete, $reason)
    {
        $this->clientIdsToDelete = $client_ids_to_delete;
        $this->reason = $reason;
    }

    public function handle()
    {
        $fieldValues = array();

        $parameterValues = [];

        foreach ($this->clientIdsToDelete as $key => $val) {
            $parameterValues[] = (object)[
                'parameter_name' => 'ID',
                'value' => $val
            ];
        }

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->whereIn('ID', $this->clientIdsToDelete)
            ->delete();


        // Dispatch Event for Auditing
        DeleteDuplicateIVADebtsolvFilesEvent::dispatch([
            'job_name' => static::class,
            'reason' => $this->reason,
            'action_type' => 'DELETE',
            'parameter_values' => $parameterValues,
            'field_values' => $fieldValues
        ]);
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
