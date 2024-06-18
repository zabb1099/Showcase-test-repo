<?php

namespace App\Http\Resources\ITPortal\DevSupportJobs\ClientType\IVA;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientTypeIVAResource extends JsonResource
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
            'client_id' => $this->ClientID,
            'client_type' => $this->clientTypeDescription
        ];
    }
}
