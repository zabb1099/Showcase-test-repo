<?php

namespace App\Http\Requests\ITPortal\UserStation;

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
            'DeskName' => 'nullable|string',
            'OS' => 'nullable|string',
        ];
    }
}

