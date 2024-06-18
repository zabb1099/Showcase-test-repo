<?php

namespace App\Http\Resources\BWPortal\Account\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{

    /**
     * @param Request $request
     * @return array
     */

    public function toArray($request) : array
    {
        return [
            'USR_ID' => $this->USR_ID,
            'COMP_ID' => $this->COMP_ID,
            'DEPT_ID' => $this->DEPT_ID,
            'TEAM_ID' => $this->TEAM_ID,
            'ROLE_ID' => $this->ROLE_ID,
            'EMP_NI_Number' => $this->EMP_NI_Number,
            'EMP_Date_of_Birth' => $this->EMP_Date_of_Birth,
            'EMP_DFH_Start_Date' => $this->EMP_DFH_Start_Date,
            'EMP_Start_Date' => $this->EMP_Start_Date,
            'EMP_Probation_End_Date' => $this->EMP_Probation_End_Date,
            'EMP_Probation_Extented_Date' => $this->EMP_Probation_Extented_Date,
            'EMP_Home_Tel' => $this->EMP_Home_Tel,
            'EMP_Mobile_Tel' => $this->EMP_Mobile_Tel,
            'EMP_Email' => $this->EMP_Email,
            'EMP_Work_Email' => $this->EMP_Work_Email,
            'EMP_Emergency_Contact' => $this->EMP_Emergency_Contact,
            'EMP_Leave_Date' => $this->EMP_Leave_Date,
            'EMP_Reason_Leaving' => $this->EMP_Reason_Leaving,
            'EMP_Starter_Pack_Send' => $this->EMP_Starter_Pack_Send,
            'Date_Created' => $this->Date_Created,
            'EMP_Line1' => $this->EMP_Line1,
            'EMP_Line2' => $this->EMP_Line2,
            'EMP_Line3' => $this->EMP_Line3,
            'EMP_Line4' => $this->EMP_Line4,
            'EMP_Postcode' => $this->EMP_Postcode,
            'HOL_Per_Year' => $this->HOL_Per_Year,
            'EMP_Bank_AcNo' => $this->EMP_Bank_AcNo,
            'EMP_Bank_SC' => $this->EMP_Bank_SC,
            'EMP_Bank_Name' => $this->EMP_Bank_Name,
            'H_L1_Manager' => $this->H_L1_Manager,
            'H_F_Manager' => $this->H_F_Manager
        ];
    }
}
