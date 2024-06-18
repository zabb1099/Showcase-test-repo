<?php

namespace App\Http\Requests\ITPortal\OfficeUser;

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
            'Version' => 'nullable|string',
            'Key' => 'nullable|string',
            'email' => 'nullable|email',
            'password' => 'nullable|string',
            'PCName' => 'nullable|string',
            'UserName' => 'nullable|string',
            'AddedBy' => 'nullable|integer|exists:tbl_sys_Users,USR_ID',
            'AddedOn' => 'nullable|date',
            'Notes' => 'nullable|string',
        ];
    }
}

