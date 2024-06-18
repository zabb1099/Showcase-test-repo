<?php

namespace App\Http\Controllers\ITPortal\DevSupportJobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\DevSupportJobs\AuditReasonRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\CardPayment\DMCardPaymentIdRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\CardPayment\IVACardPaymentIdRequest;
use App\Jobs\ITPortal\ITSupport\CardPayment\DMDebtsolvCardPayment;
use App\Jobs\ITPortal\ITSupport\CardPayment\IVADebtsolvCardPayment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class CardPaymentController extends Controller
{
    /*
     * Get all errored card payments - DM
     */
    public function getAllDMCardPayments() : Collection
    {
        return DB::connection('debtsolv')
            ->table('BulkProcesses')
            ->select('*')
            ->where('BulkProcessID', '=', 20)
            ->where('Status', '!=', 100)
            ->orderByDesc('DateStarted')
            ->get();
    }

    /*
    * Fix all errored card payments - DM
    */
    public function DMDebtsolvCardPayment(DMCardPaymentIdRequest $idRequest, AuditReasonRequest $reasonRequest)
    {
        return DMDebtsolvCardPayment::dispatchSync(
            $idRequest->id,
            $reasonRequest->reason
        );
    }

    /*
 * Get all errored card payments - IVA
 */
    public function getAllIVACardPayments() : Collection
    {
        return DB::connection('debtsolv_iva')
            ->table('BulkProcesses')
            ->select('*')
            ->where('BulkProcessID', '=', 20)
            ->where('Status', '!=', 100)
            ->orderByDesc('DateStarted')
            ->get();
    }

    /*
    * Fix all errored card payments - IVA
    */
    public function IVADebtsolvCardPayment(IVACardPaymentIdRequest $idRequest, AuditReasonRequest $reasonRequest)
    {
        return IVADebtsolvCardPayment::dispatchSync(
            $idRequest->id,
            $reasonRequest->reason
        );
    }
}
