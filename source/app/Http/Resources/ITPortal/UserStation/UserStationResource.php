<?php

namespace App\Http\Resources\ITPortal\UserStation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserStationResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */

    public function toArray($request) : array
    {
        return [
            'id' => $this->ID,
            'desk_name' => $this->DeskName,
            'computer_name' => $this->ComputerName,
            'assigned_to' => $this->users,
            'bank_no' => $this->BankNo,
            'pc_no' => $this->PCNo,
            'os' => $this->OS,
            'ram' => $this->RAM,
            'processor' => $this->Processor,
            'ms_office_version' => $this->MSOfficeVersion,
            'is_dual_monitors' => $this->IsDualMonitors,
            'notes' => $this->Notes,
            'created_by' => $this->creator,
            'created_at' => $this->AddedOn,
            'updated_by' => $this->updater,
            'updated_at' => $this->LastUpdatedOn,
            'deleted_by' => $this->usersDelete,
            'deleted_at' => $this->Date_Deleted
        ];
    }
}
