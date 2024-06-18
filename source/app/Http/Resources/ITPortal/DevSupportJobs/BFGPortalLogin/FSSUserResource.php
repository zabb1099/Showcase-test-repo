<?php

namespace App\Http\Resources\ITPortal\DevSupportJobs\BFGPortalLogin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FSSUserResource extends JsonResource
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
            'user_id' => $this->UserID,
            'username' => $this->username,
            'user_full_name' => $this->UserFullName,
            'user_first_name' => $this->UserFirstName,
            'user_last_name' => $this->UserLastName,
            'user_email' => $this->UserEmailAddress,
            'phone_number' => $this->UserTelephoneNumber,
            'dm_user_id' => $this->UserDSUserID,
            'iva_user_id' => $this->UserIVAUserID,
            'user_department' => FSSUserTypeResource::make($this->whenLoaded('userType'))
        ];
    }
}
