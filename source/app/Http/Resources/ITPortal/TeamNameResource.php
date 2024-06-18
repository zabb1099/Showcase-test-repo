<?php

namespace App\Http\Resources\ITPortal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamNameResource extends JsonResource
{

    /**
     * @param Request $request
     * @return array
     */

    public function toArray($request) : array
    {
        return [
            'id' => $this->TEAM_ID,
            'team_name' => $this->TEAM_Name,
            'deleted_at' => $this->Date_Deleted
        ];
    }
}
