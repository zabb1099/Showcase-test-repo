<?php

namespace App\Http\Resources\ITPortal\DevSupportJobs\MeetingOutcome;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingOutcomeTypeResource extends JsonResource
{

    /**
     * @param Request $request
     * @return array
     */

    public function toArray($request) : array
    {
        return [
            'id' => $this->ID,
            'description' => $this->Description
        ];
    }
}
