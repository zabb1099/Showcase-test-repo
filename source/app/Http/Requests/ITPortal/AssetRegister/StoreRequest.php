<?php

namespace App\Http\Requests\ITPortal\AssetRegister;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'Name' => 'nullable|string',
            'Asset_Type' => 'nullable|string',
            'Model' => 'nullable|string',
            'Serial_No' => 'nullable|string',
            'Date_Added' => 'required|date',
            'ZeroTier_IP_LPT' => 'nullable|string',
            'Zero_Tier_IP_PC' => 'nullable|string',
            'Last_Updated_By' => 'nullable|integer|exists:tbl_sys_Users,USR_ID',
            'EMP_ID' => 'nullable|integer|exists:tbl_sys_Users,USR_ID',
            'EmployeeName' => 'nullable|string|exists:tbl_sys_Users,USR_Full_Name',
            'LP_username' => 'nullable|string',
            'LP_password' => 'nullable|string',
            'Date_Given' => 'nullable|string',
        ];
    }
}

