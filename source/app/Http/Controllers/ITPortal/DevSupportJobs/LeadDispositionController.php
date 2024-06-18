<?php

namespace App\Http\Controllers\ITPortal\DevSupportJobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\DevSupportJobs\AuditReasonRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\ClientIdRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\IdRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\LeadsUser\AssignedUserRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\LeadsUser\HistoryUserRequest;
use App\Jobs\ITPortal\ITSupport\LeadsUser\DeleteAssignedLeadDispositions;
use App\Jobs\ITPortal\ITSupport\LeadsUser\UpdateAssignedLeadDispositions;
use App\Jobs\ITPortal\ITSupport\LeadsUser\UpdateHistoryAssignedLeadDispositions;
use App\Jobs\ITPortal\ITSupport\LeadsUser\UpdateHistoryLeadDispositions;
use App\Jobs\ITPortal\ITSupport\LeadsUser\UpdateVerifiedLeadDispositions;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


class LeadDispositionController extends Controller
{
    public function getLeadDispositions(ClientIdRequest $request): JsonResponse
    {
        $clientHistory = DB::connection('leads')
            ->select("SELECT
								'H.' + CONVERT(VARCHAR, h.HistoryID) AS id,
								CONVERT(VARCHAR, h.HistoryDateTime, 120) AS dateTime,
							    u.UserFullName AS username,
                                u.UserID AS userId,
								CASE WHEN s.StatusDescription IS NULL
								    THEN 'New'
								    ELSE s.StatusDescription
								END AS statusDescription,
								h.HistoryID AS statusId,
								CASE WHEN s.StatusID = 152 THEN
                                    3
                                ELSE
                                    1
                                END AS statusType,
                                u.UST_ID AS teamId,
                                ut.UST_Name AS teamName
							FROM History h
							LEFT OUTER JOIN Users u ON u.UserID = h.HistoryUserID
							LEFT OUTER JOIN tbl_sys_User_Types ut ON ut.UST_ID = u.UST_ID
							LEFT OUTER JOIN Status s ON s.StatusID = h.HistoryStatus
							WHERE h.HistoryClientID = '" . $request->client_id . "'
								AND (h.HistoryIsDeleted = 0 OR h.HistoryIsDeleted IS NULL)
							UNION ALL
							SELECT
								'A.' + CONVERT(VARCHAR, ac.AssignedID) AS id,
								CONVERT(VARCHAR, ac.AssignedBeginDateTime, 120) AS dateTime,
								CASE WHEN u2.UserFullName IS NULL
								    THEN 'System'
								    ELSE u2.UserFullName
								END AS username,
								u.UserID AS userId,
								u.UserFullName AS statusDescription,
								ac.AssignedID AS statusId,
								2 AS statusType,
                                u.UST_ID AS teamId,
                                ut.UST_Name AS teamName
							FROM AssignedClients ac
							LEFT OUTER JOIN Users u ON u.UserID = ac.AssignedUserID
							LEFT OUTER JOIN Users u2 ON u2.UserID = ac.AssignedByUserID
							LEFT OUTER JOIN tbl_sys_User_Types ut ON ut.UST_ID = u.UST_ID
							LEFT OUTER JOIN AssignedClients_lead_weight lw ON lw.AssignedID = ac.AssignedID
							WHERE ac.AssignedClientID = '" . $request->client_id . "'
							    AND ac.AssignedBeginDateTime IS NOT NULL
							    AND lw.lead_weight IS NULL
							ORDER BY dateTime DESC, id DESC");

        $teamIDs = [];

        foreach ($clientHistory as $key => $val) {
            if (!in_array($val->teamId, $teamIDs)) {
                $teamIDs[] = $val->teamId;
            }
        }

        $users = [];

        $getUsers = DB::connection('leads')
            ->table('Users')
            ->select('UserID', 'UserFullName', 'UST_ID')
            ->whereIn('UST_ID', $teamIDs)
            ->where('UserIsDeleted', '!=', 1)
            ->orderBy('UserFullName')
            ->get();

        foreach ($getUsers as $key => $val) {
            $users[$val->UST_ID][] = (object)[
                'userId' => $val->UserID,
                'username' => $val->UserFullName
            ];
        }

        return response()->json([
            'clientHistory' => $clientHistory,
            'users' => $users
        ]);
    }

    public function updateHistory(IdRequest $request, AuditReasonRequest $reasonRequest)
    {
        $historyId = $request->id;
        $historyId = is_array($historyId) ? $historyId : [$historyId];

        return UpdateHistoryLeadDispositions::dispatchSync(
            $historyId,
            $reasonRequest->reason
        );
    }

    public function updateHistoryAssigned(HistoryUserRequest $request, AuditReasonRequest $reasonRequest)
    {
        foreach ($request->historyUsers as $key => $val) {
            UpdateHistoryAssignedLeadDispositions::dispatchSync(
                $val['id'],
                $val['userId'],
                $reasonRequest->reason
            );
        }
    }

    public function updateAssigned(AssignedUserRequest $request, AuditReasonRequest $reasonRequest)
    {
        foreach ($request->assignedUsers as $key => $val) {
            UpdateAssignedLeadDispositions::dispatchSync(
                $val['id'],
                $val['userId'],
                $reasonRequest->reason
            );
        }
    }

    public function deleteAssigned(IdRequest $request, AuditReasonRequest $reasonRequest)
    {
        $assignedId = $request->id;
        $assignedId = is_array($assignedId) ? $assignedId : [$assignedId];

        return DeleteAssignedLeadDispositions::dispatchSync(
            $assignedId,
            $reasonRequest->reason
        );
    }

    public function updateHistoryVerified(IdRequest $request, ClientIdRequest $clientIdRequest, AuditReasonRequest $reasonRequest)
    {
        $historyId = $request->id;
        $historyId = is_array($historyId) ? $historyId : [$historyId];

        UpdateHistoryLeadDispositions::dispatchSync(
            $historyId,
            $reasonRequest->reason
        );

        UpdateVerifiedLeadDispositions::dispatchSync(
            $clientIdRequest->client_id,
            $reasonRequest->reason
        );

    }
}
