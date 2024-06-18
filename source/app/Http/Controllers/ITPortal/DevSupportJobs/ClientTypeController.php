<?php

namespace App\Http\Controllers\ITPortal\DevSupportJobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\DevSupportJobs\AuditReasonRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\ClientType\DM\ClientIdDMRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\ClientType\DM\ClientTypeDMRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\ClientType\IVA\ClientIdIVARequest;
use App\Http\Requests\ITPortal\DevSupportJobs\ClientType\IVA\ClientTypeIVARequest;
use App\Http\Resources\ITPortal\DevSupportJobs\ClientType\DM\ClientTypeDescriptionDMResource;
use App\Http\Resources\ITPortal\DevSupportJobs\ClientType\DM\ClientTypeDMResource;
use App\Http\Resources\ITPortal\DevSupportJobs\ClientType\IVA\ClientTypeDescriptionIVAResource;
use App\Http\Resources\ITPortal\DevSupportJobs\ClientType\IVA\ClientTypeIVAResource;
use App\Jobs\ITPortal\ITSupport\ClientType\DMDebtsolvUpdateClientType;
use App\Jobs\ITPortal\ITSupport\ClientType\IVADebtsolvUpdateClientType;
use App\Models\ITPortal\DevSupportJobs\ClientType\DM\ClientTypeDescriptionDM;
use App\Models\ITPortal\DevSupportJobs\ClientType\DM\ClientTypeDM;
use App\Models\ITPortal\DevSupportJobs\ClientType\IVA\ClientTypeDescriptionIVA;
use App\Models\ITPortal\DevSupportJobs\ClientType\IVA\ClientTypeIVA;
use Illuminate\Http\JsonResponse;


class ClientTypeController extends Controller
{
    /**
     * Search for a client's type on a client's file in Debtsolv DM.
     */
    public function getDMDebtsolvClientType(ClientIdDMRequest $request) : JsonResponse
    {
        return response()->json([
            'clientType' => ClientTypeDMResource::collection(ClientTypeDM::where('ClientID', $request->client_id)->get()),
            'clientTypeDescription' => ClientTypeDescriptionDMResource::collection(ClientTypeDescriptionDM::all())
        ]);
    }

    /**
     * Update a client's type on a client's file in Debtsolv DM.
     */
    public function updateDMDebtsolvClientType(ClientIdDMRequest $clientIdRequest, ClientTypeDMRequest $clientTypeRequest, AuditReasonRequest $reasonRequest)
    {
        return DMDebtsolvUpdateClientType::dispatchSync(
            $clientIdRequest->client_id,
            $clientTypeRequest->client_type,
            $reasonRequest->reason
        );
    }

    /**
     * Search for a client's type on a client's file in Debtsolv IVA.
     */
    public function getIVADebtsolvClientType(ClientIdIVARequest $request) : JsonResponse
    {
        return response()->json([
            'clientType' => ClientTypeIVAResource::collection(ClientTypeIVA::where('ClientID', $request->client_id)->get()),
            'clientTypeDescription' => ClientTypeDescriptionIVAResource::collection(ClientTypeDescriptionIVA::all())
        ]);
    }

    /**
     * Update a client's type on a client's file in Debtsolv IVA.
     */
    public function updateIVADebtsolvClientType(ClientIdIVARequest $clientIdRequest, ClientTypeIVARequest $clientTypeRequest, AuditReasonRequest $reasonRequest)
    {
        return IVADebtsolvUpdateClientType::dispatchSync(
            $clientIdRequest->client_id,
            $clientTypeRequest->client_type,
            $reasonRequest->reason
        );
    }
}
