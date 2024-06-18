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

class CreatePhoenixV1Login implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'leads';
    protected $table = 'Users';
    protected $user_id;
    protected $username;
    protected $password_hash;
    protected $reason;
    protected $getOldFieldValues;

    public function __construct($user_id, $username, $password_hash, $reason)
    {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->password_hash = $password_hash;
        $this->reason = $reason;
        $this->getOldFieldValues = $this->getOldFieldValues();
    }

    public function handle()
    {
        $newFieldValues = [
            'username' => $this->username,
            'status' => 10,
            'auth_key' => Str::random(32),
            'password_hash' => Hash::make($this->password_hash)
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'username',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->username,
                'new_value' => $newFieldValues['username']
            ],
            (object)[
                'field_name' => 'status',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->status,
                'new_value' => $newFieldValues['status']
            ],
            (object)[
                'field_name' => 'auth_key',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->auth_key,
                'new_value' => $newFieldValues['auth_key']
            ],
            (object)[
                'field_name' => 'password_hash',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->password_hash,
                'new_value' => $newFieldValues['password_hash']
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
            ->select('username', 'status', 'auth_key', 'password_hash')
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
