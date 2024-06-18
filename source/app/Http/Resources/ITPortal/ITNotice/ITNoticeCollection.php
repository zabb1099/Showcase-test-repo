<?php

namespace App\Http\Resources\ITPortal\ITNotice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ITNoticeCollection extends ResourceCollection
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
