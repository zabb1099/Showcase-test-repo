<?php

namespace App\Http\Controllers\ITPortal\DevSupportJobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\DevSupportJobs\AuditReasonRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\ProcessPayout\IdRequest;
use App\Jobs\ITPortal\ITSupport\ProcessPayout\DMDebtsolvProcessPayout;
use App\Jobs\ITPortal\ITSupport\ProcessPayout\IVADebtsolvProcessPayout;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class ProcessPayoutController extends Controller
{
    /*
     * Process DM Payouts.
     */
    public function getAllDMPayouts() : Collection
    {
        return DB::connection('debtsolv')
            ->table('BulkProcesses')
            ->select('*')
            ->where('Status', '=', 10)
            ->orderByDesc('DateStarted')
            ->get();
    }

    public function DMDebtsolvProcessPayout(IdRequest $idRequest, AuditReasonRequest $reasonRequest)
    {
        return DMDebtsolvProcessPayout::dispatchSync(
            $idRequest->id,
            $reasonRequest->reason
        );
    }

    /*
     * Process IVA Payouts.
     */
    public function getAllIVAPayouts() : Collection
    {
        return DB::connection('debtsolv_iva')
            ->table('BulkProcesses')
            ->select('*')
            ->where('Status', '=', 10)
            ->orderByDesc('DateStarted')
            ->get();
    }

    public function IVADebtsolvProcessPayout(IdRequest $idRequest, AuditReasonRequest $reasonRequest)
    {
        return IVADebtsolvProcessPayout::dispatchSync(
            $idRequest->id,
            $reasonRequest->reason
        );
    }
}
