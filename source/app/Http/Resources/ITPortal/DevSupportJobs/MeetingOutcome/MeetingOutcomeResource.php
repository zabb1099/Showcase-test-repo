<?php

namespace App\Http\Resources\ITPortal\DevSupportJobs\MeetingOutcome;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingOutcomeResource extends JsonResource
{

    /**
     * @param Request $request
     * @return array
     */

    public function toArray($request) : array
    {
        return [
            'id' => $this->ID,
            'client_id' => $this->ClientID,
            'description' => $this->Description,
            'meeting_decision' => $this->meetingOutcomeType
        ];
    }
}
