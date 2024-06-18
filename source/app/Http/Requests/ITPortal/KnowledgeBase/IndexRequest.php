<?php

namespace App\Http\Requests\ITPortal\KnowledgeBase;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'ITP_ID' => 'nullable|integer',
            'TEAM_ID' => 'nullable|integer',
            'Issue_Type' => 'nullable|string',
            'Short_Name' => 'nullable|string',
            'Created_By' => 'nullable|integer',
        ];
    }
}

