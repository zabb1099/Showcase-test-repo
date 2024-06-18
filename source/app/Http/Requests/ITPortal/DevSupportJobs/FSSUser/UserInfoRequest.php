<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\FSSUser;

use Illuminate\Foundation\Http\FormRequest;

class UserInfoRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'user_id' => 'required|integer|exists:fss.Users,UserID',
            'username' => 'required|string',
            'user_first_name' => 'required|string',
            'user_last_name' => 'required|string',
            'user_full_name' => 'required|string',
            'email_address' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'iva_debtsolv_user_id' => 'nullable|integer|exists:debtsolv_iva.Users,ID',
            'dm_debtsolv_user_id' => 'nullable|integer|exists:debtsolv.Users,ID',
            'permission_group' => 'required|integer',
            'password_hash' => 'nullable|string'
        ];
    }
}

