<?php

namespace App\Http\Resources\ITPortal\DevSupportJobs\ClientStatus\IVA;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientStatusIVAResource extends JsonResource
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
