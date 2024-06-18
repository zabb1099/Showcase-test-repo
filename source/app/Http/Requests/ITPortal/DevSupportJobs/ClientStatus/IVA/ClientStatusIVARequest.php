<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\ClientStatus\IVA;

use Illuminate\Foundation\Http\FormRequest;

class ClientStatusIVARequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'client_status' => 'required|integer|exists:debtsolv_iva.Type_Client_Status,ID'
        ];
    }
}

