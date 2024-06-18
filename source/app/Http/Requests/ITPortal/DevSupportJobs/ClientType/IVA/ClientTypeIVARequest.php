<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\ClientType\IVA;

use Illuminate\Foundation\Http\FormRequest;

class ClientTypeIVARequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'client_type' => 'required|integer|exists:debtsolv_iva.Type_ClientDefinition,ID'
        ];
    }
}

