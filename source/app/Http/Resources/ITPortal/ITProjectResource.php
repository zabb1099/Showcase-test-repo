<?php

namespace App\Http\Resources\ITPortal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ITProjectResource extends JsonResource
{

    /**
     * @param Request $request
     * @return array
     */

    public function toArray($request) : array
    {
        return [
            'id' => $this->ITP_ID,
            'project_name' => $this->Project_Name,
            'project_decription' => $this->Project_Decription,
            'project_link' => $this->Project_Link,
            'created_at' => $this->Date_Created
        ];
    }
}
