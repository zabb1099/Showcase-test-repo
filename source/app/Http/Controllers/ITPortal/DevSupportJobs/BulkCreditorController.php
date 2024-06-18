<?php

namespace App\Http\Controllers\ITPortal\DevSupportJobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\DevSupportJobs\AuditReasonRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\BulkCreditor\DM\CreateCreditorInfoDMRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\BulkCreditor\DM\CreditorIdDMRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\BulkCreditor\DM\UpdateCreditorInfoDMRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\BulkCreditor\IVA\CreateCreditorInfoIVARequest;
use App\Http\Requests\ITPortal\DevSupportJobs\BulkCreditor\IVA\CreditorIdIVARequest;
use App\Http\Requests\ITPortal\DevSupportJobs\BulkCreditor\IVA\UpdateCreditorInfoIVARequest;
use App\Jobs\ITPortal\ITSupport\BulkCreditor\DMCreateBulkCreditor;
use App\Jobs\ITPortal\ITSupport\BulkCreditor\DMUpdateBulkCreditor;
use App\Jobs\ITPortal\ITSupport\BulkCreditor\IVACreateBulkCreditor;
use App\Jobs\ITPortal\ITSupport\BulkCreditor\IVAUpdateBulkCreditor;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class BulkCreditorController extends Controller
{
    /**
     * Search for a bulk creditor on the BACS database - DM.
     */
    public function getDMBulkCreditor(CreditorIdDMRequest $request) : Collection
    {
        return DB::connection('bacs_dm')
            ->table('DS_Bulk_Creditors')
            ->select('*')
            ->where('CreditorID', '=', $request->creditor_id)
            ->get();
    }

    /**
     * Create a bulk creditor on the BACS database - DM.
     */
    public function createDMBulkCreditor(CreateCreditorInfoDMRequest $creditorInfo, AuditReasonRequest $reasonRequest)
    {
        return DMCreateBulkCreditor::dispatchSync(
            $creditorInfo->creditor_id,
            $creditorInfo->creditor_name,
            $creditorInfo->to_email,
            $creditorInfo->cc_email,
            $reasonRequest->reason
        );
    }

    /**
     * Update a bulk creditor on the BACS database - DM.
     */
    public function updateDMBulkCreditor(UpdateCreditorInfoDMRequest $creditorInfo, AuditReasonRequest $reasonRequest)
    {
        return DMUpdateBulkCreditor::dispatchSync(
            $creditorInfo->id,
            $creditorInfo->bulk_creditor_id,
            $creditorInfo->to_email,
            $creditorInfo->cc_email,
            $creditorInfo->from_email,
            $creditorInfo->contact_type,
            $creditorInfo->file_password,
            $creditorInfo->email_template_id,
            $creditorInfo->bulk_email_group_id,
            $reasonRequest->reason
        );
    }

    /**
     * Search for a bulk creditor on the BACS database - IVA.
     */
    public function getIVABulkCreditor(CreditorIdIVARequest $request) : Collection
    {
        return DB::connection('bacs_iva')
            ->table('DS_Bulk_Creditors')
            ->select('*')
            ->where('CreditorID', '=', $request->creditor_id)
            ->get();
    }

    /**
     * Create a bulk creditor on the BACS database - IVA.
     */
    public function createIVABulkCreditor(CreateCreditorInfoIVARequest $creditorInfo, AuditReasonRequest $reasonRequest)
    {
        return IVACreateBulkCreditor::dispatchSync(
            $creditorInfo->creditor_id,
            $creditorInfo->creditor_name,
            $creditorInfo->to_email,
            $creditorInfo->cc_email,
            $reasonRequest->reason
        );
    }

    /**
     * Update a bulk creditor on the BACS database - IVA.
     */
    public function updateIVABulkCreditor(UpdateCreditorInfoIVARequest $creditorInfo, AuditReasonRequest $reasonRequest)
    {
        return IVAUpdateBulkCreditor::dispatchSync(
            $creditorInfo->id,
            $creditorInfo->bulk_creditor_id,
            $creditorInfo->to_email,
            $creditorInfo->cc_email,
            $creditorInfo->from_email,
            $creditorInfo->contact_type,
            $creditorInfo->file_password,
            $creditorInfo->email_template_id,
            $creditorInfo->bulk_email_group_id,
            $reasonRequest->reason
        );
    }

}
