<?php

namespace App\Http\Resources\ITPortal\DevSupportJobs\ClientStatus\DM;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientStatusDMResource extends JsonResource
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
            'client_id' => $this->ID,
            'client_status' => $this->clientStatusDescription
        ];
    }
}
