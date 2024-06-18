<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\BulkCreditor\DM;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCreditorInfoDMRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'id' => 'required|integer|exists:bacs_dm.DS_Bulk_Creditors,ID',
            'bulk_creditor_id' => 'required|integer',
            'to_email' => 'required|string',
            'cc_email' => 'nullable|string',
            'from_email' => 'required|string',
            'contact_type' => 'required|integer',
            'file_password' => 'required|string',
            'email_template_id' => 'required|integer',
            'bulk_email_group_id' => 'nullable|integer'
        ];
    }
}

