<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs;

use Illuminate\Foundation\Http\FormRequest;

class DateRequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'date' => 'required|date'
        ];
    }
}

