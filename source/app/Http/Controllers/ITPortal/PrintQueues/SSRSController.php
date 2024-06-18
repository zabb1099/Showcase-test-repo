<?php

namespace App\Http\Controllers\ITPortal\PrintQueues;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


class SSRSController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'latestCount' => $this->getCurrentCount(),
            'thirtyMinCount' => $this->getThirtyMinCount()
        ]);
    }

    public function getCurrentCount(): int
    {
        return DB::connection('debtsolv_iva_ceres')
            ->table('ssrs_PrintQueue_Letters')
            ->where('ReadyToPrint', '=', 1)
            ->whereNotNull('BookmarkGroupID')
            ->count();
    }

    public function getThirtyMinCount(): int
    {
        // Sub Queries
        $clientAssets = DB::table('debtsolv_iva.dbo.Client_Assets')
            ->select('ClientID', DB::raw('MAX(ID) as ID'))
            ->where('TypeOfAsset', '=', 20)
            ->groupBy('ClientID');

        $signablePrintQueue = DB::table('leads.dbo.Signable_PrintQueue')
            ->select('DSREF', DB::raw('MAX(ID) as ID'))
            ->where('DOC_TYPE', '=', 9)
            ->where('ReadyToPrint', '=', 0)
            ->groupBy('DSREF');

        // Main Query
        return DB::connection('debtsolv_iva_ceres')
            ->table('ssrs_PrintQueue_Letters', 'PQ')
            ->leftJoinSub($clientAssets, 'CA', function ($join) {
                $join->on('CA.ClientID', '=', 'PQ.ClientID');
            })
            ->leftJoinSub($signablePrintQueue, 'SPQ', function ($join) {
                $join->on('SPQ.DSREF', '=', 'PQ.ClientID');
            })
            ->leftJoin('DFH_Client_Contact as DCC', 'DCC.Client_ID', '=', 'PQ.ClientID')
            ->where(function ($query) {
                $query->whereNull('CA.ClientID')
                    ->orWhereNotNull('SPQ.DSREF')
                    ->orWhereRaw('ISNULL(DCC.RX1_not_required,0) = 1')
                    ->orWhereRaw('ISNULL(DCC.Is_property_HA,0) = 1');
            })
            ->where('PQ.ReadyToPrint', '=', 1)
            ->whereRaw('PQ.Date_Created < [dbo].[fn_SSRS_PrintQueue_TimeSlot]()')
            ->whereNotNull('PQ.BookmarkGroupID')
            ->count();
    }
}
