<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs;

use Illuminate\Foundation\Http\FormRequest;

class IsRX1RequiredRequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'RX1_not_required' => 'required|boolean|exists:debtsolv_iva.DFH_Client_Contact',
            'Is_property_HA' => 'required|boolean|exists:debtsolv_iva.DFH_Client_Contact'
        ];
    }
}

