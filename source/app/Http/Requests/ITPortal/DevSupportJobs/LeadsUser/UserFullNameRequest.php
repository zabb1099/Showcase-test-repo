<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\LeadsUser;

use Illuminate\Foundation\Http\FormRequest;

class UserFullNameRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'user_full_name' => 'required|string'
        ];
    }
}

