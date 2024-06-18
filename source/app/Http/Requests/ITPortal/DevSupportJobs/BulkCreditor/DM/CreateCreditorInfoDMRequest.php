<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\BulkCreditor\DM;

use Illuminate\Foundation\Http\FormRequest;

class CreateCreditorInfoDMRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'creditor_id' => 'required|integer|unique:bacs_dm.DS_Bulk_Creditors,CreditorID',
            'creditor_name' => 'required|string',
            'to_email' => 'required|string',
            'cc_email' => 'nullable|string'
        ];
    }
}

