<?php

namespace App\Http\Requests\ITPortal\ITNotice;

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
            'notice_header' => 'nullable|string',
            'notice_body' => 'nullable|string',
            'priority_level' => 'required|string',
            'updated_at' => 'nullable|date',
            'updated_by' => 'nullable|integer|exists:tbl_sys_Users,USR_ID'
        ];
    }
}

