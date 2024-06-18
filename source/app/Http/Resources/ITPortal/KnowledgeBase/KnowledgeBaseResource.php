<?php

namespace App\Http\Resources\ITPortal\KnowledgeBase;

use App\Http\Resources\ITPortal\ITProjectResource;
use App\Models\ITProject;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KnowledgeBaseResource extends JsonResource
{

    /**
     * @param Request $request
     * @return array
     */

    public function toArray($request) : array
    {
        return [
            'id' => $this->ITL_ID,
            'itl_gr_id' => $this->ITL_GR_ID,
            'team_id' => $this->TEAM_ID,
            'project_id' => $this->ITP_ID,
            'team_name' => $this->teamNames,
            'project_name' => ITProjectResource::make($this->whenLoaded('itProjects')),
            'issue_type' => $this->Issue_Type,
            'short_name' => $this->Short_Name,
            'issue_description' => $this->Issue_Description,
            'solution_description' => $this->Solution_Description,
            'created_by' => $this->creator,
            'created_at' => $this->Date_Created,
            'deleted_by' => $this->deleter,
            'deleted_at' => $this->Date_Deleted
        ];
    }
}
