<?php

namespace App\Http\Controllers\ITPortal\DevSupportJobs;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\DevSupportJobs\AuditReasonRequest;
use App\Http\Requests\ITPortal\DevSupportJobs\DuplicateFile\ClientFilesRequest;
use App\Jobs\ITPortal\ITSupport\DuplicateFile\DeleteDuplicateDMDebtsolvFiles;
use App\Jobs\ITPortal\ITSupport\DuplicateFile\UpdateDebtsolvDMClientId;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class DuplicateDebtsolvFileDMController extends Controller
{
    public function deleteDuplicateDebtsolvFilesDM(ClientFilesRequest $clientFileIds, AuditReasonRequest $reasonRequest)
    {
        $clientIdToKeep = $clientFileIds->client_id_to_keep;
        $clientIdsToDelete = $clientFileIds->client_ids_to_remove;
        $clientIdsToDelete = is_array($clientIdsToDelete) ? $clientIdsToDelete : [$clientIdsToDelete];
        $clientIds = $clientIdsToDelete;

        array_push($clientIds, $clientIdToKeep);

         if (count(array_unique($this->checkClientDetailsAreTheSame($clientIds))) === 1) {

             if (count(array_unique($this->checkLeadReferencesMatch($clientIds))) === 1) {

                 $clientIdsToDelete = array_unique(array_merge($clientIdsToDelete, $this->checkOtherFilesForSameLeadReference($clientIds)));

                 if ($this->checkLeadsDatabaseHasCorrectDebtsolvClientId($clientIds) != $clientIdToKeep) {
                     $leadReference = $this->checkLeadReferencesMatch($clientIds);

                     UpdateDebtsolvDMClientId::dispatchSync(
                         $clientIdToKeep,
                         $leadReference[0],
                         $reasonRequest->reason
                     );
                 }

                 if ($this->checkFilesToBeDeletedAreNotTheLatestDebtsolvFileCreated() != $clientIdsToDelete) {
                     return DeleteDuplicateDMDebtsolvFiles::dispatchSync(
                         $clientIdsToDelete,
                         $reasonRequest->reason
                     );
                 }
             }
         }
        return response()->json('There are no duplicate files to remove.', 400);
    }

    private function checkClientDetailsAreTheSame($clientIds): array
    {
        $getClients = DB::connection('debtsolv')
            ->table('Client_Contact')
            ->select(DB::raw("CONCAT(Client_Contact.Forename,' ',Client_Contact.Surname) AS FullName"))
            ->whereIn('ID', $clientIds)
            ->get();

        $clients = [];

        foreach ($getClients as $key => $val) {
            if (!in_array($val->FullName, $clients)) $clients[] = $val->FullName;
        }

        return $clients;
    }

    private function checkLeadReferencesMatch($clientIds): array
    {
        $getLeadReferences = DB::connection('debtsolv')
            ->table('Client_LeadData')
            ->select('LeadReference')
            ->whereIn('Client_ID', $clientIds)
            ->get();

        $leadReferences = [];

        foreach ($getLeadReferences as $key => $val) {
            if (!in_array($val->LeadReference, $leadReferences)) $leadReferences[] = $val->LeadReference;
        }

        return $leadReferences;
    }

    private function checkOtherFilesForSameLeadReference($clientIds): array
    {
        $checkForMoreLeadReferences = DB::connection('debtsolv')
            ->table('Client_LeadData')
            ->select('Client_ID')
            ->whereIn('LeadReference', $this->checkLeadReferencesMatch($clientIds))
            ->whereNotIn('Client_ID', $clientIds)
            ->get();

        $newLeadReferences = [];

        foreach ($checkForMoreLeadReferences as $key => $val) {
            if (!in_array($val->Client_ID, $newLeadReferences)) $newLeadReferences[] = (int)$val->Client_ID;
        }

        return $newLeadReferences;
    }

    private function checkLeadsDatabaseHasCorrectDebtsolvClientId($clientIds)
    {
        $checkDebtsolvClientIdCorrect = DB::connection('leads')
            ->table('Clients')
            ->select('DS_IVA_CL_ID')
            ->whereIn('ClientID', $this->checkLeadReferencesMatch($clientIds))
            ->get();

        return $checkDebtsolvClientIdCorrect[0]->DS_IVA_CL_ID;
    }

    private function checkFilesToBeDeletedAreNotTheLatestDebtsolvFileCreated()
    {
        $lastFileCreated = DB::connection('debtsolv')
            ->table('Client_Contact')
            ->select(DB::raw('TOP 1 ID'))
            ->get();

        return $lastFileCreated[0]->ID;
    }
}
