<?php

namespace App\Http\Resources\ITPortal\DevSupportJobs\PhoenixV1Login;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadsUserResource extends JsonResource
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
            'id' => $this->UserID,
            'leads_username' => $this->UserLoginName,
            'user_full_name' => $this->UserFullName,
            'user_email' => $this->UserEmailAddress,
            'user_department' => LeadsUserTypeResource::make($this->whenLoaded('userType')),
            'phoenix_username' => $this->username,
            'phoenix_status' => $this->status,
            'password_hash' => $this->password_hash,
            'ddi' => $this->DDI
        ];
    }
}
