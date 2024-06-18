<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\IVAMeeting;

use Illuminate\Foundation\Http\FormRequest;

class MeetingIdRequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'id.*' => 'required|string'
        ];
    }
}

