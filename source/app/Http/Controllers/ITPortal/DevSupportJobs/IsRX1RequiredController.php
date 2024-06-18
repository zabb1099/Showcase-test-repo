<?php

namespace App\Http\Controllers\ITPortal\DevSupportJobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\DevSupportJobs\AuditReasonRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\IsRX1RequiredRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\ClientIdRequest;
use App\Jobs\ITPortal\ITSupport\IsRX1Required\IsRX1Required;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class IsRX1RequiredController extends Controller
{
    public function getIsRX1Required(ClientIdRequest $request) : Collection
    {
        return DB::connection('debtsolv_iva')
            ->table('DFH_Client_Contact')
            ->select(
                'Client_ID',
                'RX1_not_required',
                'Is_property_HA'
            )
            ->where('Client_ID', '=', $request->client_id)
            ->get();
    }

    public function updateIsRX1Required(ClientIdRequest $clientIdRequest, IsRX1RequiredRequest $isRX1RequiredRequest, AuditReasonRequest $reasonRequest)
    {
        return IsRX1Required::dispatchSync(
            $clientIdRequest->client_id,
            $isRX1RequiredRequest->RX1_not_required,
            $isRX1RequiredRequest->Is_property_HA,
            $reasonRequest->reason
        );
    }
}
