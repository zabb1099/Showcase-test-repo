<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\LeadsUser;

use Illuminate\Foundation\Http\FormRequest;

class UserNameRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'username' => 'required|string|exists:leads.Users,UserLoginName'
        ];
    }
}

