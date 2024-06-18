<?php

namespace App\Http\Resources\BWPortal\Reports\SelfStudyOutstandingReport;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SelfStudyOutstandingReportCollection extends ResourceCollection
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






