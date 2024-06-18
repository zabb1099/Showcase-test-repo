<?php

namespace App\Http\Controllers\ITPortal\DevSupportJobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\DevSupportJobs\AuditReasonRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\ClientIdRequest;
use App\Jobs\ITPortal\ITSupport\XMLGeneration\GenerateXML;


class XMLGenerationController extends Controller
{
    public function generateXML(ClientIdRequest $request, AuditReasonRequest $reasonRequest)
    {
        return GenerateXML::dispatchSync(
            $request->client_id,
            $reasonRequest->reason
        );
    }
}
