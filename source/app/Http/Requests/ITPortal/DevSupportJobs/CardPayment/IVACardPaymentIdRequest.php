<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\CardPayment;

use Illuminate\Foundation\Http\FormRequest;

class IVACardPaymentIdRequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'id.*' => 'required|string|exists:debtsolv_iva.BulkProcesses,ID'
        ];
    }
}

