<?php

namespace App\Http\Resources\BWPortal\Management\StarterForm;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StarterFormCollection extends ResourceCollection
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



