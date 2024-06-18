<?php

namespace App\Http\Requests\ITPortal\ITNotice;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'priority_level' => 'nullable|string',
            'created_by' => 'nullable|integer',
        ];
    }
}

