<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\FSSUser;

use Illuminate\Foundation\Http\FormRequest;

class UserFirstNameRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'user_first_name' => 'required|string'
        ];
    }
}

