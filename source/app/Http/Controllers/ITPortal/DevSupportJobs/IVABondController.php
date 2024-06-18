<?php

namespace App\Http\Controllers\ITPortal\DevSupportJobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\DevSupportJobs\AuditReasonRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\ClientIdRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\DateRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\IdRequest;
use App\Jobs\ITPortal\ITSupport\IVABond\BondRenewalDate;
use App\Jobs\ITPortal\ITSupport\IVABond\RemoveDuplicateBond;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class IVABondController extends Controller
{
    /**
     * Remove Duplicate Bond(s).
     */
    public function RemoveDuplicateBond(ClientIdRequest $request, AuditReasonRequest $reasonRequest)
    {
        $duplicates = DB::connection('debtsolv_iva')
                ->table('Payment_ScheduledAdditionals')
                ->selectRaw('Description, COUNT(Description) AS Total')
                ->where('ClientID', '=', $request->client_id)
                ->groupBy('Description')
                ->havingRaw('COUNT(Description) > 1')
                ->get();

        if (!$duplicates->isEmpty()) {
            return RemoveDuplicateBond::dispatchSync(
                $request->client_id,
                $reasonRequest->reason
            );
        }

        return response()->json('There are no duplicate bonds to remove.', 400);
    }

    /**
     * Update Bond Renewal Date.
     */
    public function getBondRenewalDate(ClientIdRequest $request) : Collection
    {
        return DB::connection('debtsolv_iva')
            ->table('Bond_RenewalSchedule')
            ->select(
                'ID',
                'ClientID',
                'Date AS date'
            )
            ->where('ClientID', '=', $request->client_id)
            ->get();
    }

    public function UpdateBondRenewalDate(idRequest $idRequest, DateRequest $dateRequest, AuditReasonRequest $reasonRequest)
    {
        return BondRenewalDate::dispatchSync(
            $idRequest->id,
            $dateRequest->date,
            $reasonRequest->reason
        );
    }
}
