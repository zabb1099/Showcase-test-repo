<?php

namespace App\Jobs\ITPortal\ITSupport\BulkCreditor;

use App\Events\ITPortal\DevSupportJobs\BulkCreditor\IVADebtsolvUpdateBulkCreditorEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class IVAUpdateBulkCreditor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'bacs_iva';
    protected $table = 'DS_Bulk_Creditors';
    protected $id;
    protected $bulk_creditor_id;
    protected $to_email;
    protected $cc_email;
    protected $from_email;
    protected $contact_type;
    protected $file_password;
    protected $email_template_id;
    protected $bulk_email_group_id;
    protected $reason;
    protected $oldFieldValues;

    public function __construct($id, $bulk_creditor_id, $to_email, $cc_email, $from_email, $contact_type, $file_password, $email_template_id, $bulk_email_group_id, $reason)
    {
        $this->id = $id;
        $this->bulk_creditor_id = $bulk_creditor_id;
        $this->to_email = $to_email;
        $this->cc_email = $cc_email;
        $this->from_email = $from_email;
        $this->contact_type = $contact_type;
        $this->file_password = $file_password;
        $this->email_template_id = $email_template_id;
        $this->bulk_email_group_id = $bulk_email_group_id;
        $this->reason = $reason;
        $this->oldFieldValues = $this->getOldFieldValues();
    }

    public function handle()
    {
        $newFieldValues = [
            'BulkCreditorID' => $this->bulk_creditor_id,
            'ToEmail' => $this->to_email,
            'CCEmail' => $this->cc_email,
            'FromEmail' => $this->from_email,
            'ContactType' => $this->contact_type,
            'FilePassword' => $this->file_password,
            'EmailTemplateID' => $this->email_template_id,
            'BulkEmailGroupID' => $this->bulk_email_group_id
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'BulkCreditorID',
                'primary_key' => $this->id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->BulkCreditorID,
                'new_value' => $newFieldValues['BulkCreditorID']
            ],
            (object)[
                'field_name' => 'ToEmail',
                'primary_key' => $this->id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->ToEmail,
                'new_value' => $newFieldValues['ToEmail']
            ],
            (object)[
                'field_name' => 'CCEmail',
                'primary_key' => $this->id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->CCEmail,
                'new_value' => $newFieldValues['CCEmail']
            ],
            (object)[
                'field_name' => 'FromEmail',
                'primary_key' => $this->id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->FromEmail,
                'new_value' => $newFieldValues['FromEmail']
            ],
            (object)[
                'field_name' => 'ContactType',
                'primary_key' => $this->id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->ContactType,
                'new_value' => $newFieldValues['ContactType']
            ],
            (object)[
                'field_name' => 'FilePassword',
                'primary_key' => $this->id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->FilePassword,
                'new_value' => $newFieldValues['FilePassword']
            ],
            (object)[
                'field_name' => 'EmailTemplateID',
                'primary_key' => $this->id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->EmailTemplateID,
                'new_value' => $newFieldValues['EmailTemplateID']
            ],
            (object)[
                'field_name' => 'BulkEmailGroupID',
                'primary_key' => $this->id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->BulkEmailGroupID,
                'new_value' => $newFieldValues['BulkEmailGroupID']
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
        IVADebtsolvUpdateBulkCreditorEvent::dispatch([
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
            ->select('BulkCreditorID', 'ToEmail', 'CCEmail', 'FromEmail', 'ContactType', 'FilePassword', 'EmailTemplateID', 'BulkEmailGroupID')
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
