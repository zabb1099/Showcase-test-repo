<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\LeadsUser;

use Illuminate\Foundation\Http\FormRequest;

class AssignedUserRequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'assignedUsers.*.id' => 'required|exists:leads.AssignedClients,AssignedID',
            'assignedUsers.*.userId' => 'required|exists:leads.Users,UserID'
        ];
    }
}

