<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\ClientType\DM;

use Illuminate\Foundation\Http\FormRequest;

class ClientIdDMRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'client_id' => 'required|integer|exists:debtsolv.Client_Status,ClientID'
        ];
    }
}

