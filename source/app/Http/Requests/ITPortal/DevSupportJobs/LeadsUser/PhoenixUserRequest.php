<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\LeadsUser;

use Illuminate\Foundation\Http\FormRequest;

class PhoenixUserRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'user_id' => 'required|integer|exists:leads.Users,UserID',
            'username' => 'required|string|exists:leads.Users,UserLoginName',
            'password_hash' => 'required|string',
            'ddi' => 'nullable|integer',
            'user_group' => 'required|integer'
        ];
    }
}

