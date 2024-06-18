<?php

namespace App\Http\Requests\BWPortal\Account\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'EMP_ID' => 'nullable|integer',
            'COMP_ID' => 'nullable|integer',
            'DEPT_ID' => 'nullable|integer',
            'TEAM_ID' => 'nullable|integer',
            'ROLE_ID' => 'nullable|integer',
            'EMP_Work_Email' => 'nullable|string',
            'EMP_Emergency_Contact' => 'nullable|string',
            'EMP_Leave_Date' => 'nullable|date',
            'EMP_Reason_Leaving' => 'nullable|string',
            'EMP_NI_Number' => 'nullable|string',
            'EMP_Date_of_Birth' => 'nullable|date',
            'EMP_DFH_Start_Date' => 'nullable|date',
            'EMP_Start_Date' => 'nullable|date',
            'EMP_Probation_End_Date' => 'nullable|date',
            'EMP_Probation_Extented_Date' => 'nullable|date',
            'EMP_Home_Tel' => 'nullable|integer',
            'EMP_Mobile_Tel' => 'nullable|integer',
            'EMP_Email' => 'nullable|string'
        ];
    }
}

