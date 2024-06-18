<?php

namespace App\Jobs\ITPortal\ITSupport\FSSUser;

use App\Events\ITPortal\DevSupportJobs\FSSUser\UpdateBFGPortalLoginEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Throwable;

class UpdateBFGPortalLogin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'fss';
    protected $table = 'Users';
    protected $user_id;
    protected $username;
    protected $user_first_name;
    protected $user_last_name;
    protected $user_full_name;
    protected $user_email;
    protected $phone_number;
    protected $iva_user_id;
    protected $dm_user_id;
    protected $permission_group;
    protected $password_hash;
    protected $reason;
    protected $oldFieldValues;

    public function __construct($user_id, $username, $user_first_name, $user_last_name, $user_full_name, $user_email, $phone_number, $iva_user_id, $dm_user_id, $permission_group, $password_hash, $reason)
    {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->user_first_name = $user_first_name;
        $this->user_last_name = $user_last_name;
        $this->user_full_name = $user_full_name;
        $this->user_email = $user_email;
        $this->phone_number = $phone_number;
        $this->iva_user_id = $iva_user_id;
        $this->dm_user_id = $dm_user_id;
        $this->permission_group = $permission_group;
        $this->password_hash = $password_hash;
        $this->reason = $reason;
        $this->oldFieldValues = $this->getOldFieldValues();
    }

    public function handle()
    {
        $newFieldValues = [
            'username' => $this->username,
            'UserFullName' => $this->user_full_name,
            'UserFirstName' => $this->user_first_name,
            'UserLastName' => $this->user_last_name,
            'UserEmailAddress' => $this->user_email,
            'UserTelephoneNumber' => $this->phone_number,
            'UserDSUserID' => $this->dm_user_id,
            'UserIVAUserID' => $this->iva_user_id,
            'UST_ID' => $this->permission_group,
            'auth_key' => Str::random(32),
            'password_hash' => Hash::make($this->password_hash)
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
                'field_name' => 'UserFullName',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->UserFullName,
                'new_value' => $newFieldValues['UserFullName']
            ],
            (object)[
                'field_name' => 'UserFirstName',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->UserFirstName,
                'new_value' => $newFieldValues['UserFirstName']
            ],
            (object)[
                'field_name' => 'UserLastName',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->UserLastName,
                'new_value' => $newFieldValues['UserLastName']
            ],
            (object)[
                'field_name' => 'UserEmailAddress',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->UserEmailAddress,
                'new_value' => $newFieldValues['UserEmailAddress']
            ],
            (object)[
                'field_name' => 'UserTelephoneNumber',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->UserTelephoneNumber,
                'new_value' => $newFieldValues['UserTelephoneNumber']
            ],
            (object)[
                'field_name' => 'UserDSUserID',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->UserDSUserID,
                'new_value' => $newFieldValues['UserDSUserID']
            ],
            (object)[
                'field_name' => 'UserIVAUserID',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->UserIVAUserID,
                'new_value' => $newFieldValues['UserIVAUserID']
            ],
            (object)[
                'field_name' => 'UST_ID',
                'primary_key' => $this->user_id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->oldFieldValues->UST_ID,
                'new_value' => $newFieldValues['UST_ID']
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
            ->where('UserID', '=', $this->user_id)
            ->update($newFieldValues);

        // Dispatch Event for Auditing
        UpdateBFGPortalLoginEvent::dispatch([
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
            ->select('username', 'auth_key', 'password_hash', 'UserFullName', 'UserFirstName', 'UserLastName', 'UserEmailAddress', 'UserTelephoneNumber', 'UserDSUserID', 'UserIVAUserID', 'UST_ID')
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
