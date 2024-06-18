<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\ProcessPayout;

use Illuminate\Foundation\Http\FormRequest;

class IdRequest extends FormRequest
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

