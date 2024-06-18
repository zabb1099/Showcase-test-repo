<?php

namespace App\Jobs\ITPortal\ITSupport\IVABond;

use App\Events\ITPortal\DevSupportJobs\IVABond\RemoveDuplicateBondEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RemoveDuplicateBond implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dbConnection = 'debtsolv_iva';
    protected $table = 'Payment_ScheduledAdditionals';
    protected $clientId;
    protected $reason;
    protected $updates = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($clientId, $reason)
    {
        $this->clientId = $clientId;
        $this->reason = $reason;
    }

    /**
     * The handle function executes the job.
     *
     * There are two possible scenarios. The first scenario is the most common, and it happens when for a
     * particular ClientID, there are statuses ten and nine.
     * In this case, the duplicate record with status nine will be converted in negative.
     * The second scenario consists of having only status ten. In this case, it needs to remove the duplicates
     * and leave the one created by Sathish.
     *
     */
    public function handle()
    {
        $resultStatusNine = $this->getStatusNine();
        $resultStatusTen = $this->getStatusTen();
        $resultStatusTenInsertedByAdmin = $this->getStatusTenInsertedByAdmin();

        $this->statusMix($resultStatusNine, $resultStatusTen);
        $this->statusTens($resultStatusNine, $resultStatusTen, $resultStatusTenInsertedByAdmin);

        $fieldValues = [];

        foreach ($this->updates as $update) {
            $fieldValues[] = (object)[
                'field_name' => 'ClientID',
                'primary_key' => $update['primaryKey'],
                'database_name' => config('database.connections.' . $this->dbConnection . '.database'),
                'table_name' => $this->table,
                'old_value' => $update['oldClientId'],
                'new_value' => $update['newClientId']
            ];
        }

        $parameterValues = array(
            (object)[
                'parameter_name' => 'ClientID',
                'value' => $this->clientId
            ]
        );

        // Dispatch Event for Auditing
        RemoveDuplicateBondEvent::dispatch([
            'job_name' => static::class,
            'reason' => $this->reason,
            'action_type' => 'UPDATE',
            'parameter_values' => $parameterValues,
            'field_values' => $fieldValues
        ]);
    }

    /**
     *
     * The method statusMix updates the duplicated ClientID when the statuses are ten and nine.
     *
     */
    private function statusMix($resultStatusNine, $resultStatusTen)
    {
        if (count($resultStatusNine) > 0 && $resultStatusTen) {
            foreach ($resultStatusTen as $index => $arrStatusTen) {
                $diff = array_diff_assoc((array)$resultStatusNine[0], (array)$arrStatusTen);
                if (count($diff) === 2 && array_key_exists('ID', $diff) || array_key_exists('Status', $diff)) {
                    $this->updateStatus($resultStatusNine[0]);
                }
            }
        }
    }

    /**
     *
     * The method statusTens updates the duplicated ClientID when the statuses are ten.
     *
     */
    private function statusTens($resultStatusNine, $resultStatusTen, $resultStatusTenInsertedByAdmin)
    {
        if (count($resultStatusNine) === 0 && $resultStatusTen) {
            foreach ($resultStatusTen as $index => $arrStatusTen) {
                if ($resultStatusTenInsertedByAdmin[0]->Description === $arrStatusTen->Description
                    && $resultStatusTenInsertedByAdmin[0]->Status === $arrStatusTen->Status
                    && $resultStatusTenInsertedByAdmin[0]->Amount === $arrStatusTen->Amount
                    && $resultStatusTenInsertedByAdmin[0]->Transactiontype === $arrStatusTen->Transactiontype
                    && $resultStatusTenInsertedByAdmin[0]->UserID !== $arrStatusTen->UserID) {
                    $this->updateStatus($arrStatusTen);
                }
            }
        }
    }

    /**
     *
     * The method getStatusNine retrieves data from Payment_ScheduledAdditionals for a given ClientID and status nine.
     *
     */
    private function getStatusNine(): Collection
    {
        return DB::connection($this->dbConnection)
            ->table($this->table)
            ->select('ID', 'ClientID', 'Description', 'Status', 'Amount', 'Transactiontype', 'UserID')
            ->where('clientID', '=', $this->clientId)
            ->where('Status', 9)
            ->get();
    }

    /**
     *
     * The method getStatusTen retrieves data from Payment_ScheduledAdditionals for a given ClientID and status ten.
     *
     */
    private function getStatusTen(): Collection
    {
        return DB::connection($this->dbConnection)
            ->table($this->table)
            ->select('ID', 'ClientID', 'Description', 'Status', 'Amount', 'Transactiontype', 'UserID')
            ->where('clientID', '=', $this->clientId)
            ->where('Status', 10)
            ->get();
    }

    /**
     *
     * The method getStatusTenInsertedByAdmin retrieves data from Payment_ScheduledAdditionals for a given ClientID,
     * status ten and the userID is Sathish.
     *
     */
    private function getStatusTenInsertedByAdmin(): Collection
    {
        return DB::connection($this->dbConnection)
            ->table($this->table)
            ->select('ID', 'ClientID', 'Description', 'Status', 'Amount', 'Transactiontype', 'UserID')
            ->where('clientID', '=', $this->clientId)
            ->where('Status', 10)
            ->where('UserID', 6361)
            ->get();
    }

    /**
     *
     * The method updateStatus updates the duplicated record from Payment_ScheduledAdditionals for a given ClientID.
     *
     */
    private function updateStatus($result)
    {
        $this->updates[] = [
            'oldClientId' => $result->ClientID,
            'newClientId' => -$result->ClientID,
            'primaryKey' => $result->ID
        ];

        DB::connection($this->dbConnection)
            ->table($this->table)
            ->where([['ID', '=', $result->ID], ['ClientID', '=', $result->ClientID]])
            ->update([
                'ClientID' => -$result->ClientID
            ]);
    }

}
