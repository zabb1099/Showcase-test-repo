<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\ClientType\IVA;

use Illuminate\Foundation\Http\FormRequest;

class ClientIdIVARequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'client_id' => 'required|integer|exists:debtsolv_iva.Client_Status,ClientID'
        ];
    }
}

