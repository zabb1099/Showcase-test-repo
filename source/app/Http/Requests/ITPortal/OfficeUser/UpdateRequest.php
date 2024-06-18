<?php

namespace App\Http\Requests\ITPortal\OfficeUser;

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
            'ID' => 'nullable|integer',
            'Version' => 'nullable|string',
            'Key' => 'nullable|string',
            'email' => 'nullable|email',
            'password' => 'nullable|string',
            'PCName' => 'nullable|string',
            'UserName' => 'nullable|string',
            'LastUpdatedBy' => 'nullable|integer|exists:tbl_sys_Users,USR_ID',
            'LastUpdatedOn' => 'nullable|date',
            'Notes' => 'nullable|string'
        ];
    }
}

