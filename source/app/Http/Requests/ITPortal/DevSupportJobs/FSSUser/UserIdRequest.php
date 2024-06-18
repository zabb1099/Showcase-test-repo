<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\FSSUser;

use Illuminate\Foundation\Http\FormRequest;

class UserIdRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'user_id' => 'required|integer|exists:fss.Users,UserID'
        ];
    }
}

