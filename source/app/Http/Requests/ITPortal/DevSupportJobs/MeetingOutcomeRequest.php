<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs;

use Illuminate\Foundation\Http\FormRequest;

class MeetingOutcomeRequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'meeting_outcome' => 'required|integer|exists:debtsolv_iva.Type_MeetingOutcome,ID'
        ];
    }
}

