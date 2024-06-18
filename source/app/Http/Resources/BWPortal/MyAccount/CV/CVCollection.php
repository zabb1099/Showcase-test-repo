<?php

namespace App\Http\Resources\BWPortal\MyAccount\CV;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CVCollection extends ResourceCollection
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




