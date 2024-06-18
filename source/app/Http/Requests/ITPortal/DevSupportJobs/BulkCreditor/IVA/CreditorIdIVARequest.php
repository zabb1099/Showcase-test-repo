<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\BulkCreditor\IVA;

use Illuminate\Foundation\Http\FormRequest;

class CreditorIdIVARequest extends FormRequest
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

