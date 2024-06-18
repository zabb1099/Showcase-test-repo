<?php

namespace App\Http\Controllers\ITPortal\DevSupportJobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\DevSupportJobs\AuditReasonRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\CreditorIdRequest;
use App\Jobs\ITPortal\ITSupport\NewBACSCreditor\DMNewBACSCreditor;
use App\Jobs\ITPortal\ITSupport\NewBACSCreditor\IVANewBACSCreditor;


class NewBACSCreditorController extends Controller
{
    public function DMNewBACSCreditor(CreditorIdRequest $request, AuditReasonRequest $reasonRequest)
    {
        return DMNewBACSCreditor::dispatchSync(
            $request->creditor_id,
            $reasonRequest->reason
        );
    }

    public function IVANewBACSCreditor(CreditorIdRequest $request, AuditReasonRequest $reasonRequest)
    {
        return IVANewBACSCreditor::dispatchSync(
            $request->creditor_id,
            $reasonRequest->reason
        );
    }
}
