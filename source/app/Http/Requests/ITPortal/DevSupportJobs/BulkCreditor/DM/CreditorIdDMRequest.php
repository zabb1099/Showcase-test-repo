<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\BulkCreditor\DM;

use Illuminate\Foundation\Http\FormRequest;

class CreditorIdDMRequest extends FormRequest
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

