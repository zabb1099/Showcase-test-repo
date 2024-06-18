<?php

namespace App\Http\Resources\ITPortal\DevSupportJobs\ClientType\DM;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientTypeDescriptionDMResource extends JsonResource
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
            'id' => $this->ID,
            'description' => $this->Description
        ];
    }
}
