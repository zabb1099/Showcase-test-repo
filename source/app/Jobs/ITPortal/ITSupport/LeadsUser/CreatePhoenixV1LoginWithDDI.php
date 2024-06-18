<?php

namespace App\Jobs\ITPortal\ITSupport\LeadsUser;

use App\Events\ITPortal\DevSupportJobs\LeadsUser\CreatePhoenixV1LoginEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;

class CreatePhoenixV1LoginWithDDI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'leads';
    protected $table = 'Users';
    protected $user_id;
    protected $username;
    protected $password_hash;
    protected $ddi;
    protected $reason;
    protected $oldFieldValues;

    public function __construct($user_id, $username, $password_hash, $ddi, $reason)
    {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->password_hash = $password_hash;
        $this->ddi = $ddi;
        $this->reason = $reason;
        $this->oldFieldValues = $this->getOldFieldValues();
    }

    public function handle()
    {
        $newFieldValues = [
            'username' => $this->username,
            'status' => 10,
            'auth_key' => Str::random(32),
            'password_hash' => Hash::make($this->password_hash),
            'DDI' => $this->ddi,
            'Mobile_DDI' => '447866142941',
            'm_queue_id' => 2401,
            'queue_id' => 192
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'username',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->username,
                'new_value' => $newFieldValues['username']
            ],
            (object)[
                'field_name' => 'status',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->status,
                'new_value' => $newFieldValues['status']
            ],
            (object)[
                'field_name' => 'auth_key',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->auth_key,
                'new_value' => $newFieldValues['auth_key']
            ],
            (object)[
                'field_name' => 'password_hash',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->password_hash,
                'new_value' => $newFieldValues['password_hash']
            ],
            (object)[
                'field_name' => 'DDI',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->DDI,
                'new_value' => $newFieldValues['DDI']
            ],
            (object)[
                'field_name' => 'Mobile_DDI',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->Mobile_DDI,
                'new_value' => $newFieldValues['Mobile_DDI']
            ],
            (object)[
                'field_name' => 'm_queue_id',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->m_queue_id,
                'new_value' => $newFieldValues['m_queue_id']
            ],
            (object)[
                'field_name' => 'queue_id',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->queue_id,
                'new_value' => $newFieldValues['queue_id']
            ]
        );

        $parameterValues = array(
            (object)[
                'parameter_name' => 'UserID',
                'value' => $this->user_id,
            ],
            (object)[
                'parameter_name' => 'UserLoginName',
                'value' => $this->username,
            ]
        );

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->where([['UserID', '=', $this->user_id], ['UserLoginName', '=', $this->username]])
            ->update($newFieldValues);

        // Dispatch Event for Auditing
        CreatePhoenixV1LoginEvent::dispatch([
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
            ->select('username', 'status', 'auth_key', 'password_hash', 'DDI', 'Mobile_DDI', 'm_queue_id', 'queue_id')
            ->where([['UserID', '=', $this->user_id], ['UserLoginName', '=', $this->username]])
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
