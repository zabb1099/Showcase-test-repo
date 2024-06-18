<?php

namespace App\Http\Requests\ITPortal\OfficeUser;

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
            'email' => 'nullable|string',
            'UserName' => 'nullable|string',
        ];
    }
}

