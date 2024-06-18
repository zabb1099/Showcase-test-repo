<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\ClientType\DM;

use Illuminate\Foundation\Http\FormRequest;

class ClientTypeDMRequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'client_type' => 'required|integer|exists:debtsolv.Type_ClientDefinition,ID'
        ];
    }
}

