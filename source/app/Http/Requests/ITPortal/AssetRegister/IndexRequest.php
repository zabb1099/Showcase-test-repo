<?php

namespace App\Http\Requests\ITPortal\AssetRegister;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest {

    public function authorize () : bool
    {
        return true;
    }

    public function rules () : array
    {
        return [
            'search' => 'nullable|string'
        ];
    }
}

