<?php

namespace App\Http\Requests\ITPortal\KnowledgeBase;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'ITP_ID' => 'nullable|integer|exists:tbl_IT_Projects,ITP_ID',
            'TEAM_ID' => 'nullable|integer|exists:tbl_Team_Names,TEAM_ID',
            'Issue_Type' => 'nullable|string',
            'Short_Name' => 'required|string',
            'Issue_Description' => 'nullable|string',
            'Solution_Description' => 'nullable|string',
            'Date_Created' => 'required|date',
            'Created_By' => 'nullable|integer|exists:tbl_sys_Users,USR_ID',
        ];
    }
}

