<?php

namespace App\Http\Resources\ITPortal\OfficeUser;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfficeUserResource extends JsonResource
{

    /**
     * @param Request $request
     * @return array
     */

    public function toArray($request) : array
    {
        return [
            'id' => $this->ID,
            'version' => $this->Version,
            'key' => $this->Key,
            'email' => $this->email,
            'password' => $this->password,
            'pc_name' => $this->PCName,
            'user_name' => $this->UserName,
            'notes' => $this->Notes,
            'created_by' => $this->creator,
            'created_at' => $this->AddedOn,
            'updated_by' => $this->updater,
            'updated_at' => $this->LastUpdatedOn,
            'deleted_by' => $this->deleter,
            'deleted_at' => $this->Date_Deleted
        ];
    }
}
