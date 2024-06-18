<?php
namespace App\Http\Resources\ITPortal\ITNotice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ITNoticeResource extends JsonResource {

    /**
     * @param Request $request
     * @return array
     */

    public function toArray($request) : array
    {
        return [
            'id' => $this->id,
            'notice_header' => $this->notice_header,
            'notice_body' => $this->notice_body,
            'priority_level' => $this->priority_level,
            'created_by' => $this->creator,
            'created_at' => $this->created_at,
            'updated_by' => $this->updater,
            'updated_at' => $this->updated_at,
            'deleted_by' => $this->deleter,
            'deleted_at' => $this->deleted_at
        ];
    }
}

