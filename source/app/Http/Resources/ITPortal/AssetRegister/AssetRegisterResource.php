<?php

namespace App\Http\Resources\ITPortal\AssetRegister;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetRegisterResource extends JsonResource
{

    /**
     * @param Request $request
     * @return array
     */

    public function toArray($request) : array
    {
        return [
            'id' => $this->ID,
            'name' => $this->Name,
            'asset_type' => $this->Asset_Type,
            'model' => $this->Model,
            'serial_no' => $this->Serial_No,
            'zero_tier_ip_laptop' => $this->ZeroTier_IP_LPT,
            'zero_tier_ip_pc' => $this->Zero_Tier_IP_PC,
            'employee_id' => $this->EMP_ID,
            'employee_name' => $this->EmployeeName,
            'laptop_username' => $this->LP_username,
            'laptop_password' => $this->LP_password,
            'date_given' => $this->Date_Given,
            'created_on' => $this->Date_Added,
            'updated_on' => $this->Last_Updated_On,
            'updated_by' => $this->updater,
            'deleted_at' => $this->Date_Deleted,
            'deleted_by' => $this->deleter
        ];
    }
}
