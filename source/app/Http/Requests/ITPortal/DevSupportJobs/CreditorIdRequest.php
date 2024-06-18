<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs;

use Illuminate\Foundation\Http\FormRequest;

class CreditorIdRequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'creditor_id' => 'required|integer'
        ];
    }
}

