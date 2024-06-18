<?php

namespace App\Http\Resources\ITPortal\KnowledgeBase;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class KnowledgeBaseCollection extends ResourceCollection {

    /**
     * @param Request $request
     * @return array
     */

    public function toArray($request) : array
    {
        return parent::toArray($request);
    }
}
