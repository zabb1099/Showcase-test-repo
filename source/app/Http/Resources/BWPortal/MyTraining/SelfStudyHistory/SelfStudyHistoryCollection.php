<?php

namespace App\Http\Resources\BWPortal\MyTraining\SelfStudyHistory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SelfStudyHistoryCollection extends ResourceCollection
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





