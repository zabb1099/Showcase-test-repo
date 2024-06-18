<?php

namespace App\Http\Controllers\ITPortal\DevSupportJobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\DevSupportJobs\AuditReasonRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\LeadsUser\PhoenixUserRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\LeadsUser\UserFullNameRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\LeadsUser\UserIdRequest;
use App\Http\Resources\ITPortal\DevSupportJobs\PhoenixV1Login\LeadsUserResource;
use App\Jobs\ITPortal\ITSupport\LeadsUser\CreatePhoenixV1Login;
use App\Jobs\ITPortal\ITSupport\LeadsUser\CreatePhoenixV1LoginWithDDI;
use App\Jobs\ITPortal\ITSupport\LeadsUser\DeletePhoenixV1Login;
use App\Models\ITPortal\DevSupportJobs\PhoenixV1Login\LeadsUser;
use Illuminate\Http\JsonResponse;


class LeadsUserController extends Controller
{
    /**
     * Update Leads User table to create Phoenix V1 login.
     */
    public function getLeadsUser(UserFullNameRequest $request): JsonResponse
    {
        return response()->json([
            'leadsUser' => LeadsUserResource::collection(
                LeadsUser::where([
                    ['UserFullName', 'LIKE', '%' . $request->user_full_name . '%'],
                    ['UserIsDeleted', 0]
                ])->get()
            )
        ]);
    }

    public function createLeadsUser(PhoenixUserRequest $phoenixUserRequest, AuditReasonRequest $reasonRequest)
    {
        if ($phoenixUserRequest->user_group == 9) {
            return CreatePhoenixV1LoginWithDDI::dispatchSync(
                $phoenixUserRequest->user_id,
                $phoenixUserRequest->username,
                $phoenixUserRequest->password_hash,
                $phoenixUserRequest->ddi,
                $reasonRequest->reason
            );
        }

        return CreatePhoenixV1Login::dispatchSync(
            $phoenixUserRequest->user_id,
            $phoenixUserRequest->username,
            $phoenixUserRequest->password_hash,
            $reasonRequest->reason
        );
    }

    public function deleteLeadsUser(UserIdRequest $userIdRequest, AuditReasonRequest $reasonRequest)
    {
        return DeletePhoenixV1Login::dispatchSync(
            $userIdRequest->user_id,
            $reasonRequest->reason
        );
    }
}
