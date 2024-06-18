<?php

namespace App\Http\Resources\BWPortal\Reports\LastAccess;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LastAccessCollection extends ResourceCollection
{

    /**
     * @param Request $request
     * @return array
     */

    public function toArray($request) : array
    {
        return parent::toArray($request);
    }
}






