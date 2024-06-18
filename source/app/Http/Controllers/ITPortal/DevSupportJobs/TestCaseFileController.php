<?php

namespace App\Http\Controllers\ITPortal\DevSupportJobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\DevSupportJobs\AuditReasonRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\ClientIdRequest;
use App\Jobs\ITPortal\ITSupport\TestCaseFile\LeadsClientFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class TestCaseFileController extends Controller
{
    public function getLeadsClientFile(ClientIdRequest $request) : Collection
    {
        return DB::connection('leads')
            ->table('MarketingData')
            ->join('TypeLeadSource',
                'MarketingData.MarketingDataLeadSourceID',
                '=',
                'TypeLeadSource.TypeLeadSourceID')
            ->select(
                'MarketingData.MarketingDataID',
                'MarketingData.MarketingDataClientID',
                'TypeLeadSource.TypeLeadSourceDescription'
            )
            ->where('MarketingData.MarketingDataClientID', '=', $request->client_id)
            ->get();
    }

    public function updateLeadsClientFile(ClientIdRequest $request, AuditReasonRequest $reasonRequest)
    {
        return LeadsClientFile::dispatchSync(
            $request->client_id,
            $reasonRequest->reason
        );
    }
}
