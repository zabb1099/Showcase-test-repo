<?php

namespace App\Http\Resources\ITPortal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    /**
     * @param Request $request
     * @return array
     */

    public function toArray($request) : array
    {
        return [
            'id' => $this->USR_ID,
            'title' => $this->UST_Title,
            'first_name' => $this->UST_First_Name,
            'last_name' => $this->UST_Last_Name,
            'full_name' => $this->USR_Full_Name
        ];
    }
}
