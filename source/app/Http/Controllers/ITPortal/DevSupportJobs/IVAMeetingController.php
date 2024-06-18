<?php

namespace App\Http\Controllers\ITPortal\DevSupportJobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\DevSupportJobs\AuditReasonRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\ClientIdMeetingOutcomeRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\IVAMeeting\MeetingIdRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\IdRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\MeetingOutcomeRequest;
use App\Http\Resources\ITPortal\DevSupportJobs\MeetingOutcome\MeetingOutcomeResource;
use App\Http\Resources\ITPortal\DevSupportJobs\MeetingOutcome\MeetingOutcomeTypeResource;
use App\Jobs\ITPortal\ITSupport\IVAMeeting\UpdateMeetingOutcome;
use App\Jobs\ITPortal\ITSupport\IVAMeeting\RemoveSecondMeeting;
use App\Models\ITPortal\DevSupportJobs\MeetingOutcome\MeetingOutcome;
use App\Models\ITPortal\DevSupportJobs\MeetingOutcome\MeetingOutcomeType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class IVAMeetingController extends Controller
{
    /**
     * Remove second meeting.
     */
    public function getClientIVAMeetings(ClientIdMeetingOutcomeRequest $request) : Collection
    {
        return DB::connection('debtsolv_iva')
            ->table('Client_IVAMeeting')
            ->select(
                'ID',
                'ClientID',
                'Description'
            )
            ->where('ClientID', '=', $request->client_id)
            ->get();
    }

    public function updateSecondMeeting(MeetingIdRequest $idRequest, ClientIdMeetingOutcomeRequest $clientIdRequest, AuditReasonRequest $reasonRequest)
    {
        return RemoveSecondMeeting::dispatchSync(
            $idRequest->id,
            $clientIdRequest->client_id,
            $reasonRequest->reason
        );
    }

    /**
     * Update meeting outcome.
     */
    public function getMeetingOutcome(ClientIdMeetingOutcomeRequest $request) : JsonResponse
    {
        return response()->json([
            'meetingOutcome' => MeetingOutcomeResource::collection(MeetingOutcome::where('ClientID', $request->client_id)->get()),
            'meetingOutcomeType' => MeetingOutcomeTypeResource::collection(MeetingOutcomeType::all())
        ]);
    }

    public function updateMeetingOutcome(IdRequest $idRequest, ClientIdMeetingOutcomeRequest $clientIdRequest, MeetingOutcomeRequest $meetingOutcomeRequest, AuditReasonRequest $reasonRequest)
    {
        return UpdateMeetingOutcome::dispatchSync(
            $idRequest->id,
            $clientIdRequest->client_id,
            $meetingOutcomeRequest->meeting_outcome,
            $reasonRequest->reason
        );
    }
}
