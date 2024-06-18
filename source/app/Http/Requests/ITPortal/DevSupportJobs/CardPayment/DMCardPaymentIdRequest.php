<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\CardPayment;

use Illuminate\Foundation\Http\FormRequest;

class DMCardPaymentIdRequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'id.*' => 'required|string|exists:debtsolv.BulkProcesses,ID'
        ];
    }
}

