<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\LeadsUser;

use Illuminate\Foundation\Http\FormRequest;

class HistoryUserRequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'historyUsers.*.id' => 'required|exists:leads.History,HistoryID',
            'historyUsers.*.userId' => 'required|exists:leads.Users,UserID'
        ];
    }
}

