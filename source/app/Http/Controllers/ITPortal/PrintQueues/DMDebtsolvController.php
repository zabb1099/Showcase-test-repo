<?php

namespace App\Http\Controllers\ITPortal\PrintQueues;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DMDebtsolvController extends Controller
{
    protected $connection = 'debtsolv_ceres';
    private $sub5Mins;
    private $sub10Mins;
    private $sub1Hour;

    public function __construct()
    {
        $this->sub5Mins = Carbon::now('Europe/London')->subMinutes(5);
        $this->sub10Mins = Carbon::now('Europe/London')->subMinutes(10);
        $this->sub1Hour = Carbon::now('Europe/London')->subHour();
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'letters' => [
                'count' => $this->getLettersCount(),
                'status' => $this->getLettersStatus()
            ],
            'emails' => [
                'count' => $this->getEmailsCount(),
                'status' => $this->getEmailsStatus()
            ],
            'sms' => [
                'count' => $this->getSMSsCount(),
                'status' => $this->getSMSsStatus()
            ],
            'actionGroups' => [
                'count' => $this->getActionGroupsCount()
            ],
            'total' => $this->getTotalCount()
        ]);
    }

    // Letters
    public function getLettersCount(): int
    {
        return DB::connection($this->connection)
            ->table('PrintQueue_StdLetters')
            ->where('ReadyToPrint', '=', 1)
            ->count();
    }

    public function getLettersStatus(): string
    {
        $result = DB::connection($this->connection)
            ->table('PrintQueue_StdLetters')
            ->selectRaw('MAX(DatePrinted) DatePrinted')
            ->get();

        $lastGenerated = isset($result[0]->DatePrinted) ? $result[0]->DatePrinted : '';

        if ($this->sub5Mins->lessThan($lastGenerated) || $this->getLettersCount() == 0) {
            return 'green';
        } else if ($this->sub10Mins->greaterThanOrEqualTo($lastGenerated)) {
            return 'red';
        } else {
            return 'amber';
        }
    }

    // Emails
    public function getEmailsCount(): int
    {
        return DB::connection($this->connection)
            ->table('EMessage_Queue')
            ->where([['ReadyToSend', '=', 1], ['TemplateID', '!=', 2173]])
            ->count();
    }

    public function getEmailsStatus(): string
    {
        $result = DB::connection($this->connection)
            ->table('EMessage_Queue')
            ->selectRaw('MAX(DateSent) as DateSent')
            ->get();

        $lastGenerated = isset($result[0]->DateSent) ? $result[0]->DateSent : '';

        if ($this->sub5Mins->lessThan($lastGenerated) || $this->getEmailsCount() == 0) {
            return 'green';
        } else if ($this->sub10Mins->greaterThanOrEqualTo($lastGenerated) && $this->sub1Hour->lessThan($lastGenerated)) {
            return 'red';
        } else if ($this->sub1Hour->greaterThanOrEqualTo($lastGenerated)) {
            return 'emailsDown';
        } else {
            return 'amber';
        }
    }

    // SMSs
    public function getSMSsCount(): int
    {
        return DB::connection($this->connection)
            ->table('SMSQueue_StdSMS')
            ->where('AwaitingSending', '=', 1)
            ->count();
    }

    public function getSMSsStatus(): string
    {
        $result = DB::connection($this->connection)
            ->table('SMSQueue_StdSMS')
            ->selectRaw('MAX(DateSent) as DateSent')
            ->get();

        $lastGenerated = isset($result[0]->DateSent) ? $result[0]->DateSent : '';

        if ($this->sub5Mins->lessThan($lastGenerated) || $this->getSMSsCount() == 0) {
            return 'green';
        } else if ($this->sub10Mins->greaterThanOrEqualTo($lastGenerated)) {
            return 'red';
        } else {
            return 'amber';
        }
    }

    // Action Groups
    public function getActionGroupsCount(): int
    {
        return DB::connection($this->connection)
            ->table('PrintQueue_ActionGroups')
            ->where('ReadyToPrint', '=', 1)
            ->count();
    }

    // Total
    public function getTotalCount(): int
    {
        return $this->getLettersCount() + $this->getEmailsCount() + $this->getSMSsCount() + $this->getActionGroupsCount();
    }
}
