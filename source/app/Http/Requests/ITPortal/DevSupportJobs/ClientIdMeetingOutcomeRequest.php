<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs;

use Illuminate\Foundation\Http\FormRequest;

class ClientIdMeetingOutcomeRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'client_id' => 'required|integer|exists:debtsolv_iva.Client_IVAMeeting,ClientID'
        ];
    }
}

