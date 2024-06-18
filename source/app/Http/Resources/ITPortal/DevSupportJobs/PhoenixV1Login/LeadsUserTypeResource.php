<?php

namespace App\Http\Resources\ITPortal\DevSupportJobs\PhoenixV1Login;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadsUserTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->UST_ID,
            'name' => $this->UST_Name
        ];
    }
}
