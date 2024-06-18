<?php

namespace App\Http\Controllers\ITPortal\DevSupportJobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\DevSupportJobs\AuditReasonRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\ClientIdRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\IdRequest;
use App\Jobs\ITPortal\ITSupport\UnlockClientFile\DMDebtsolvUnlockClientFile;
use App\Jobs\ITPortal\ITSupport\UnlockClientFile\FSSUnlockClientFile;
use App\Jobs\ITPortal\ITSupport\UnlockClientFile\IVADebtsolvUnlockClientFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class UnlockClientFileController extends Controller
{
    /**
     * Search for a lock on a client's file in FSS.
     */
    public function getFSSUnlockClientFile(ClientIdRequest $request) : Collection
    {
        return DB::connection('leads')
            ->table('tbl_Client_Lock')
            ->join('Users',
                'tbl_Client_Lock.Created_By',
                '=',
                'Users.UserID')
            ->select(
                'tbl_Client_Lock.ACC_ID',
                'tbl_Client_Lock.Client_ID',
                'tbl_Client_Lock.Date_Created',
                'Users.UserFullName'
            )
            ->where('tbl_Client_Lock.Client_ID', '=', $request->client_id)
            ->whereNull('tbl_Client_Lock.Closed_By')
            ->whereNull('tbl_Client_Lock.Date_Closed')
            ->get();
    }

    public function FSSUnlockClientFile(IdRequest $idRequest, AuditReasonRequest $reasonRequest)
    {
        return FSSUnlockClientFile::dispatchSync(
            $idRequest->id,
            $reasonRequest->reason
        );
    }

    /**
     * Search for a lock on a client's file in Debtsolv DM.
     */
    public function getDMDebtsolvUnlockClientFile(ClientIdRequest $request) : Collection
    {
        return DB::connection('debtsolv')
            ->table('Client_Lock')
            ->join('Users',
                'Client_Lock.UserID',
                '=',
                'Users.ID')
            ->select(
                'Client_Lock.ClientID',
                'Users.ShortName'
            )
            ->where('Client_Lock.ClientID', '=', $request->client_id)
            ->get();
    }

    public function DMDebtsolvUnlockClientFile(ClientIdRequest $request, AuditReasonRequest $reasonRequest)
    {
        return DMDebtsolvUnlockClientFile::dispatchSync(
            $request->client_id,
            $reasonRequest->reason
        );
    }

    /**
     * Search for a lock on a client's file in Debtsolv IVA.
     */
    public function getIVADebtsolvUnlockClientFile(ClientIdRequest $request) : Collection
    {
        return DB::connection('debtsolv_iva')
            ->table('Client_Lock')
            ->join('Users',
                'Client_Lock.UserID',
                '=',
                'Users.ID')
            ->select(
                'Client_Lock.ClientID',
                'Users.ShortName'
            )
            ->where('Client_Lock.ClientID', '=', $request->client_id)
            ->get();
    }

    public function IVADebtsolvUnlockClientFile(ClientIdRequest $request, AuditReasonRequest $reasonRequest)
    {
        return IVADebtsolvUnlockClientFile::dispatchSync(
            $request->client_id,
            $reasonRequest->reason
        );
    }
}
