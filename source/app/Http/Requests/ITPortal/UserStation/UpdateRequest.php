<?php

namespace App\Http\Requests\ITPortal\UserStation;

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
            'DeskName' => 'nullable|string',
            'ComputerName' => 'nullable|string',
            'AssignedTo' => 'nullable|integer|exists:tbl_sys_Users,USR_ID',
            'BankNo' => 'nullable|string',
            'PCNo' => 'required|string',
            'OS' => 'nullable|string',
            'RAM' => 'nullable|string',
            'Processor' => 'nullable|string',
            'MSOfficeVersion' => 'nullable|string',
            'IsDualMonitors' => 'nullable|string|digits_between:0,1',
            'Notes' => 'nullable|string',
            'LastUpdatedBy' => 'nullable|integer|exists:tbl_sys_Users,USR_ID',
            'LastUpdatedOn' => 'nullable|date'
        ];
    }
}

