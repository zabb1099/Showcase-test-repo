<?php

namespace App\Jobs\ITPortal\ITSupport\IVAMeeting;

use App\Events\ITPortal\DevSupportJobs\IVAMeeting\UpdateMeetingOutcomeEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateMeetingOutcome implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'debtsolv_iva';
    protected $table = 'Client_IVAMeeting';
    protected $id;
    protected $clientId;
    protected $meetingDecision;
    protected $reason;
    protected $getOldFieldValues;

    public function __construct($id, $clientId, $meetingDecision, $reason)
    {
        $this->id = $id;
        $this->clientId = $clientId;
        $this->meetingDecision = $meetingDecision;
        $this->reason = $reason;
        $this->getOldFieldValues = $this->getOldFieldValues();
    }

    public function handle()
    {
        $newFieldValues = [
            'MeetingDecision' => $this->meetingDecision
        ];

        $fieldValues = array(
            (object)[
                'field_name' => 'MeetingDecision',
                'primary_key' => $this->id,
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $this->getOldFieldValues->MeetingDecision,
                'new_value' => $newFieldValues['MeetingDecision']
            ]
        );

        $parameterValues = array(
            (object)[
                'parameter_name' => 'ID',
                'value' => $this->id,
            ],
            (object)[
                'parameter_name' => 'ClientID',
                'value' => $this->clientId,
            ]
        );

        // Action Job
        DB::connection($this->dbConnection)
            ->table($this->table)
            ->where([['ID', '=', $this->id], ['ClientID', '=', $this->clientId]])
            ->update($newFieldValues);

        // Dispatch Event for Auditing
        UpdateMeetingOutcomeEvent::dispatch([
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
            ->select('MeetingDecision')
            ->where([['ID', '=', $this->id], ['ClientID', '=', $this->clientId]])
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
