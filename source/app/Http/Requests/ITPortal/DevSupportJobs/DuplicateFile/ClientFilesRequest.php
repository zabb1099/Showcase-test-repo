<?php

namespace App\Http\Requests\ITPortal\DevSupportJobs\DuplicateFile;

use Illuminate\Foundation\Http\FormRequest;

class ClientFilesRequest extends FormRequest
{

    public function authorize() : bool
    {
        return true;
    }

    public function rules() : array
    {
        return [
            'client_id_to_keep' => 'required|integer|exists:debtsolv.Client_Contact,ID',
            'client_ids_to_remove.*' => 'required|integer'
        ];
    }
}

