<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\ClientStatus\DM;

use Illuminate\Foundation\Http\FormRequest;

class ClientStatusDMRequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'client_status' => 'required|integer|exists:debtsolv.Type_Client_Status,ID'
        ];
    }
}

