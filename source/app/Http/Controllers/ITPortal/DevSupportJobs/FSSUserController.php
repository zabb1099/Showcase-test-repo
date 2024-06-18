<?php

namespace App\Http\Controllers\ITPortal\DevSupportJobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\DevSupportJobs\AuditReasonRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\FSSUser\UserFirstNameRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\FSSUser\UserIdRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\FSSUser\UserInfoRequest;
use App\Http\Resources\ITPortal\DevSupportJobs\BFGPortalLogin\FSSUserResource;
use App\Http\Resources\ITPortal\DevSupportJobs\BFGPortalLogin\FSSUserTypeResource;
use App\Jobs\ITPortal\ITSupport\FSSUser\DeleteBFGPortalLogin;
use App\Jobs\ITPortal\ITSupport\FSSUser\UpdateBFGPortalLogin;
use App\Models\ITPortal\DevSupportJobs\BFGPortalLogin\FSSUser;
use App\Models\ITPortal\DevSupportJobs\BFGPortalLogin\FSSUserType;
use Illuminate\Http\JsonResponse;


class FSSUserController extends Controller
{
    /**
     * Update FSS User table to update BFG Portal login details.
     */
    public function getFSSUser(UserFirstNameRequest $request): JsonResponse
    {
        return response()->json([
            'fssUser' => FSSUserResource::collection(
                FSSUser::where([
                    ['UserFirstName', 'LIKE', '%' . $request->user_first_name . '%'],
                    ['UserIsDeleted', 0]
                ])->get()
            ),
            'userGroups' => FSSUserTypeResource::collection(FSSUserType::all())
        ]);
    }

    public function updateFSSUser(UserInfoRequest $userInfoRequest, AuditReasonRequest $reasonRequest)
    {
        return UpdateBFGPortalLogin::dispatchSync(
            $userInfoRequest->user_id,
            $userInfoRequest->username,
            $userInfoRequest->user_first_name,
            $userInfoRequest->user_last_name,
            $userInfoRequest->user_full_name,
            $userInfoRequest->email_address,
            $userInfoRequest->phone_number,
            $userInfoRequest->iva_debtsolv_user_id,
            $userInfoRequest->dm_debtsolv_user_id,
            $userInfoRequest->permission_group,
            $userInfoRequest->password_hash,
            $reasonRequest->reason
        );
    }

    public function deleteFSSUser(UserIdRequest $userIdRequest, AuditReasonRequest $reasonRequest)
    {
        return DeleteBFGPortalLogin::dispatchSync(
            $userIdRequest->user_id,
            $reasonRequest->reason
        );
    }
}
