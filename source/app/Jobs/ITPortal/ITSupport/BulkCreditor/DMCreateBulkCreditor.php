<?php

namespace App\Jobs\ITPortal\ITSupport\BulkCreditor;

use App\Events\ITPortal\DevSupportJobs\BulkCreditor\DMDebtsolvCreateBulkCreditorEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class DMCreateBulkCreditor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'bacs_dm';
    protected $table = 'DS_Bulk_Creditors';
    protected $creditor_id;
    protected $creditor_name;
    protected $to_email;
    protected $cc_email;
    protected $reason;

    public function __construct($creditor_id, $creditor_name, $to_email, $cc_email, $reason)
    {
        $this->creditor_id = $creditor_id;
        $this->creditor_name = $creditor_name;
        $this->to_email = $to_email;
        $this->cc_email = $cc_email;
        $this->reason = $reason;
    }

    public function handle()
    {
        $newFieldValues = [
            'CreditorID' => $this->creditor_id,
            'Name' => $this->creditor_name,
            'BulkCreditorID' => $this->creditor_id,
            'ToEmail' => $this->to_email,
            'CCEmail' => $this->cc_email,
            'FromEmail' => 'pdt@dfh.co.uk',
            'ContactType' => 1,
            'FilePassword' => 'debtfree',
            'EmailTemplateID' => 1,
            'BulkEmailGroupID' => null
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'CreditorID',
                'primary_key' => '',
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => '',
                'new_value' => $newFieldValues['CreditorID']
            ],
            (object)[
                'field_name' => 'Name',
                'primary_key' => '',
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => '',
                'new_value' => $newFieldValues['Name']
            ],
            (object)[
                'field_name' => 'BulkCreditorID',
                'primary_key' => '',
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => '',
                'new_value' => $newFieldValues['BulkCreditorID']
            ],
            (object)[
                'field_name' => 'ToEmail',
                'primary_key' => '',
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => '',
                'new_value' => $newFieldValues['ToEmail']
            ],
            (object)[
                'field_name' => 'CCEmail',
                'primary_key' => '',
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => '',
                'new_value' => $newFieldValues['CCEmail']
            ],
            (object)[
                'field_name' => 'FromEmail',
                'primary_key' => '',
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => '',
                'new_value' => $newFieldValues['FromEmail']
            ],
            (object)[
                'field_name' => 'ContactType',
                'primary_key' => '',
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => '',
                'new_value' => $newFieldValues['ContactType']
            ],
            (object)[
                'field_name' => 'FilePassword',
                'primary_key' => '',
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => '',
                'new_value' => $newFieldValues['FilePassword']
            ],
            (object)[
                'field_name' => 'EmailTemplateID',
                'primary_key' => '',
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => '',
                'new_value' => $newFieldValues['EmailTemplateID']
            ],
            (object)[
                'field_name' => 'BulkEmailGroupID',
                'primary_key' => '',
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => '',
                'new_value' => $newFieldValues['BulkEmailGroupID']
            ]
        );

        $parameterValues = array();

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->insert($newFieldValues);

        // Dispatch Event for Auditing
        DMDebtsolvCreateBulkCreditorEvent::dispatch([
            'job_name' => static::class,
            'reason' => $this->reason,
            'action_type' => 'INSERT',
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
