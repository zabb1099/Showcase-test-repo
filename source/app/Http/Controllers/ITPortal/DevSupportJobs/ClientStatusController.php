<?php

namespace App\Http\Controllers\ITPortal\DevSupportJobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\DevSupportJobs\AuditReasonRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\ClientStatus\DM\ClientIdDMRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\ClientStatus\DM\ClientStatusDMRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\ClientStatus\IVA\ClientIdIVARequest;
use App\Http\Requests\ITPortal\DevSupportJobs\ClientStatus\IVA\ClientStatusIVARequest;
use App\Http\Resources\ITPortal\DevSupportJobs\ClientStatus\DM\ClientStatusDescriptionDMResource;
use App\Http\Resources\ITPortal\DevSupportJobs\ClientStatus\DM\ClientStatusDMResource;
use App\Http\Resources\ITPortal\DevSupportJobs\ClientStatus\IVA\ClientStatusDescriptionIVAResource;
use App\Http\Resources\ITPortal\DevSupportJobs\ClientStatus\IVA\ClientStatusIVAResource;
use App\Jobs\ITPortal\ITSupport\ClientStatus\DMDebtsolvUpdateClientStatus;
use App\Jobs\ITPortal\ITSupport\ClientStatus\IVADebtsolvUpdateClientStatus;
use App\Models\ITPortal\DevSupportJobs\ClientStatus\DM\ClientStatusDescriptionDM;
use App\Models\ITPortal\DevSupportJobs\ClientStatus\DM\ClientStatusDM;
use App\Models\ITPortal\DevSupportJobs\ClientStatus\IVA\ClientStatusDescriptionIVA;
use App\Models\ITPortal\DevSupportJobs\ClientStatus\IVA\ClientStatusIVA;
use Illuminate\Http\JsonResponse;


class ClientStatusController extends Controller
{
    /**
     * Search for a client's status on a client's file in Debtsolv DM.
     */
    public function getDMDebtsolvClientStatus(ClientIdDMRequest $request) : JsonResponse
    {
        return response()->json([
            'clientStatus' => ClientStatusDMResource::collection(ClientStatusDM::where('ID', $request->client_id)->get()),
            'clientStatusDescription' => ClientStatusDescriptionDMResource::collection(ClientStatusDescriptionDM::all())
        ]);
    }

    /**
     * Update a client's status on a client's file in Debtsolv DM.
     */
    public function updateDMDebtsolvClientStatus(ClientIdDMRequest $clientIdRequest, ClientStatusDMRequest $clientStatusRequest, AuditReasonRequest $reasonRequest)
    {
        return DMDebtsolvUpdateClientStatus::dispatchSync(
            $clientIdRequest->client_id,
            $clientStatusRequest->client_status,
            $reasonRequest->reason
        );
    }

    /**
     * Search for a client's status on a client's file in Debtsolv IVA.
     */
    public function getIVADebtsolvClientStatus(ClientIdIVARequest $request) : JsonResponse
    {
        return response()->json([
            'clientStatus' => ClientStatusIVAResource::collection(ClientStatusIVA::where('ID', $request->client_id)->get()),
            'clientStatusDescription' => ClientStatusDescriptionIVAResource::collection(ClientStatusDescriptionIVA::all())
        ]);
    }

    /**
     * Update a client's status on a client's file in Debtsolv IVA.
     */
    public function updateIVADebtsolvClientStatus(ClientIdIVARequest $clientIdRequest, ClientStatusIVARequest $clientStatusRequest, AuditReasonRequest $reasonRequest)
    {
        return IVADebtsolvUpdateClientStatus::dispatchSync(
            $clientIdRequest->client_id,
            $clientStatusRequest->client_status,
            $reasonRequest->reason
        );
    }

}
